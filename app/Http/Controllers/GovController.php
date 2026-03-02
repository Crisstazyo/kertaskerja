<?php

namespace App\Http\Controllers;

use App\Models\ScallingImport;
use Illuminate\Http\Request;

class GovController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.gov.index');
    }

    public function scalling()
    {
        // Scalling page acts as parent menu for LOP categories
        return view('dashboard.gov.scalling');
    }

    public function lopOnHand()
    {
        // gunakan parameter periode (format YYYY-MM) daripada month/year terpisah
        $currentPeriode = request()->get('periode', date('Y-m'));
        // kolom periode di database disimpan sebagai DATE (YYYY-MM-01), jadi tambahkan '-01'
        $currentPeriodeDate = $currentPeriode . '-01';

        // produce list of available periods (YYYY-MM) from past imports
        $periodOptions = ScallingImport::where('type', 'on-hand')
            ->where('segment', 'government')
            ->where('status', 'active')
            ->orderBy('periode', 'desc')
            ->get()
            ->pluck('periode')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
            ->unique()
            ->values();

        $latestImport = ScallingImport::with(['data.funnel.todayProgress'])
            ->where('type', 'on-hand')
            ->where('status', 'active')
            ->where('segment', 'government')
            ->where('periode', $currentPeriodeDate)
            ->latest()
            ->first();
        
        // Get admin note
        
        return view('dashboard.gov.lop-on-hand', compact('latestImport', 'currentPeriode', 'periodOptions'));
    }

    public function lopKoreksi()
    {
        // gunakan parameter periode (format YYYY-MM) daripada month/year terpisah
        $currentPeriode = request()->get('periode', date('Y-m'));
        // kolom periode di database disimpan sebagai DATE (YYYY-MM-01), jadi tambahkan '-01'
        $currentPeriodeDate = $currentPeriode . '-01';

        // produce list of available periods (YYYY-MM) from past imports
        $periodOptions = ScallingImport::where('type', 'koreksi')
            ->where('segment', 'government')
            ->where('status', 'active')
            ->orderBy('periode', 'desc')
            ->get()
            ->pluck('periode')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
            ->unique()
            ->values();

        $latestImport = ScallingImport::with(['data.funnel.todayProgress'])
            ->where('type', 'koreksi')
            ->where('status', 'active')
            ->where('segment', 'government')
            ->where('periode', $currentPeriodeDate)
            ->latest()
            ->first();
        
        // Get admin note
        
        return view('dashboard.gov.lop-koreksi', compact('latestImport', 'currentPeriode', 'periodOptions'));
    }

    public function lopQualified()
    {
        // gunakan parameter periode (format YYYY-MM) daripada month/year terpisah
        $currentPeriode = request()->get('periode', date('Y-m'));
        // kolom periode di database disimpan sebagai DATE (YYYY-MM-01), jadi tambahkan '-01'
        $currentPeriodeDate = $currentPeriode . '-01';

        // produce list of available periods (YYYY-MM) from past imports
        $periodOptions = ScallingImport::where('type', 'qualified')
            ->where('segment', 'government')
            ->where('status', 'active')
            ->orderBy('periode', 'desc')
            ->get()
            ->pluck('periode')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
            ->unique()
            ->values();

        $latestImport = ScallingImport::with(['data.funnel.todayProgress'])
            ->where('type', 'qualified')
            ->where('status', 'active')
            ->where('segment', 'government')
            ->where('periode', $currentPeriodeDate)
            ->latest()
            ->first();
        
        // Get admin note
        
        return view('dashboard.gov.lop-qualified', compact('latestImport', 'currentPeriode', 'periodOptions'));
    }

    public function updateFunnelCheckbox(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:on_hand,qualified,koreksi,initiate',
            'data_id' => 'required|integer',
            'field' => 'required|string',
            'value' => 'required',
            'est_nilai_bc' => 'nullable',
        ]);
        
        // Convert value to boolean (handles both true/false and "true"/"false")
        $value = filter_var($request->value, FILTER_VALIDATE_BOOLEAN);
        // note: est_nilai_bc may come as formatted string; keep raw for later calculation
        $rawEst = $request->est_nilai_bc ?? null;
        
        // Find or create the funnel tracking record
        $funnel = \App\Models\FunnelTracking::firstOrCreate(
            [
                'data_type' => $request->data_type,
                'data_id' => $request->data_id,
            ]
        );

        // when billing checkbox flips we may need to toggle every other boolean field
        $autoFields = [];

        // mirror the requested checkbox on master
        $funnel->{$request->field} = $value;

        if ($request->field === 'delivery_billing_complete') {
            // set billcomp value or clear it
            if ($value) {
                $funnel->delivery_nilai_billcomp = is_numeric($rawEst) ? (float) $rawEst : null;
            } else {
                $funnel->delivery_nilai_billcomp = null;
            }

            // gather all boolean fields except the billing flag itself
            $autoFields = collect($funnel->getCasts())
                ->filter(fn($c, $k) => $c === 'boolean' && $k !== 'delivery_billing_complete')
                ->keys()
                ->toArray();

            // apply the same check/uncheck to each of them
            foreach ($autoFields as $fld) {
                $funnel->{$fld} = $value;
            }
        }

        $funnel->save();
        
        // Find or create today's task progress for this user
        $taskProgress = \App\Models\TaskProgress::firstOrCreate(
            [
                'task_id' => $funnel->id,
                'user_id' => auth()->id(),
                'tanggal' => today(),
            ]
        );
        
        // Update the checkbox field in task_progress
        $taskProgress->{$request->field} = $value;

        // billing complete uses the raw est value - compute only here
        if ($request->field === 'delivery_billing_complete') {
            if ($value) {
                $taskProgress->delivery_nilai_billcomp = is_numeric($rawEst) ? (float) $rawEst : null;
            } else {
                $taskProgress->delivery_nilai_billcomp = null;
            }

            // mirror the same boolean toggle on progress row
            foreach ($autoFields as $fld) {
                $taskProgress->{$fld} = $value;
            }
        }

        $taskProgress->save();
        
        // Calculate total for all billing complete values in this data type for today
        $total = \App\Models\TaskProgress::whereHas('task', function($q) use ($request) {
                $q->where('data_type', $request->data_type);
            })
            ->where('user_id', auth()->id())
            ->whereDate('tanggal', today())
            ->where('delivery_billing_complete', true)
            ->whereNotNull('delivery_nilai_billcomp')
            ->sum('delivery_nilai_billcomp');
        
        return response()->json([
            'success' => true,
            'nilai_billcomp' => $taskProgress->delivery_nilai_billcomp,
            'total' => number_format((float) $total, 0, ',', '.'),
            // let frontend know which other fields to toggle and what value to apply
            'auto_fields' => $autoFields,
            'auto_value' => $request->field === 'delivery_billing_complete' ? $value : null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
