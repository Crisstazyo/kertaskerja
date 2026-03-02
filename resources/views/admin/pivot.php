<?php

namespace App\Http\Controllers;

use App\Models\ScallingImport;
use App\Models\RisingStar;
use Illuminate\Http\Request;

class GovController extends Controller
{
    public function index()
    {
        return view('dashboard.gov.index');
    }

    public function scalling()
    {
        return view('dashboard.gov.scalling');
    }

    public function lopOnHand()
    {
        $currentPeriode     = request()->get('periode', date('Y-m'));
        $currentPeriodeDate = $currentPeriode . '-01';

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

        return view('dashboard.gov.lop-on-hand', compact('latestImport', 'currentPeriode', 'periodOptions'));
    }

    public function lopKoreksi()
    {
        $currentPeriode     = request()->get('periode', date('Y-m'));
        $currentPeriodeDate = $currentPeriode . '-01';

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

        return view('dashboard.gov.lop-koreksi', compact('latestImport', 'currentPeriode', 'periodOptions'));
    }

    public function lopQualified()
    {
        $currentPeriode = request()->get('periode', date('Y-m'));
        $currentPeriodeDate = $currentPeriode . '-01';

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

    // ══════════════════════════════════════════════════════
    // Helper: upsert RisingStar per (user_id, type_id, periode)
    // Hanya kolom yang dikirim yang diupdate — tidak overwrite kolom lain.
    // ══════════════════════════════════════════════════════
    private function upsertRisingStar(int $typeId, array $values): RisingStar
    {
        $periode = now()->format('Y-m-01');

        $record = RisingStar::firstOrNew([
            'user_id'  => auth()->id(),
            'type_id'  => $typeId,
            'periode'  => $periode,
        ]);

        // Hanya isi kolom yang memang dikirim, kolom lain dibiarkan
        foreach ($values as $col => $val) {
            $record->{$col} = $val;
        }

        // Set status active jika record baru
        if (! $record->exists) {
            $record->status = 'active';
        }

        $record->save();

        return $record;
    }

    // ══ AOSODOMORO 0-3 Bulan (type_id: 7) ══

    public function aosodomoro03Bulan()
    {
        $periode = now()->format('Y-m-01');

        // Record milik user login di periode ini
        $existing = RisingStar::where('user_id', auth()->id())
            ->where('type_id', 7)
            ->where('periode', $periode)
            ->first();

        // History hanya milik user login
        $history = RisingStar::with(['user', 'type'])
            ->where('user_id', auth()->id())
            ->where('type_id', 7)
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('dashboard.gov.aosodomoro-0-3-bulan', compact('history', 'existing'));
    }

    public function storeAosodomoro03Bulan(Request $request)
    {
        $request->validate([
            'real_ratio' => 'required|numeric|min:0',
        ]);

        $this->upsertRisingStar(7, [
            'real_ratio' => $request->real_ratio,
        ]);

        return redirect()->route('dashboard.gov.aosodomoro-0-3-bulan')
            ->with('success', 'Data realisasi Aosodomoro 0-3 Bulan berhasil disimpan.');
    }

    // ══ AOSODOMORO > 3 Bulan (type_id: 8) ══

    public function aosodomoroAbove3Bulan()
    {
        $periode = now()->format('Y-m-01');

        $existing = RisingStar::where('user_id', auth()->id())
            ->where('type_id', 8)
            ->where('periode', $periode)
            ->first();

        // History hanya milik user login
        $history = RisingStar::with(['user', 'type'])
            ->where('user_id', auth()->id())
            ->where('type_id', 8)
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('dashboard.gov.aosodomoro-above-3-bulan', compact('history', 'existing'));
    }

    public function storeAosodomoroAbove3Bulan(Request $request)
    {
        $request->validate([
            'real_ratio' => 'required|numeric|min:0',
        ]);

        $this->upsertRisingStar(8, [
            'real_ratio' => $request->real_ratio,
        ]);

        return redirect()->route('dashboard.gov.aosodomoro-above-3-bulan')
            ->with('success', 'Data realisasi Aosodomoro >3 Bulan berhasil disimpan.');
    }

    // ══════════════════════════════════════════════════════
    // Funnel Checkbox (tidak diubah logikanya)
    // ══════════════════════════════════════════════════════

    public function updateFunnelCheckbox(Request $request)
    {
        $request->validate([
            'data_type'    => 'required|in:on_hand,qualified,koreksi,initiate',
            'data_id'      => 'required|integer',
            'field'        => 'required|string',
            'value'        => 'required',
            'est_nilai_bc' => 'nullable',
        ]);

        $value  = filter_var($request->value, FILTER_VALIDATE_BOOLEAN);
        $rawEst = $request->est_nilai_bc ?? null;

        $funnel = \App\Models\FunnelTracking::firstOrCreate([
            'data_type' => $request->data_type,
            'data_id'   => $request->data_id,
        ]);

        $autoFields         = [];
        $funnel->{$request->field} = $value;

        if ($request->field === 'delivery_billing_complete') {
            $funnel->delivery_nilai_billcomp = $value && is_numeric($rawEst) ? (float) $rawEst : null;

            $autoFields = collect($funnel->getCasts())
                ->filter(fn($c, $k) => $c === 'boolean' && $k !== 'delivery_billing_complete')
                ->keys()
                ->toArray();

            foreach ($autoFields as $fld) {
                $funnel->{$fld} = $value;
            }
        }

        $funnel->save();

        $taskProgress = \App\Models\TaskProgress::firstOrCreate([
            'task_id' => $funnel->id,
            'user_id' => auth()->id(),
            'tanggal' => today(),
        ]);

        $taskProgress->{$request->field} = $value;

        if ($request->field === 'delivery_billing_complete') {
            $taskProgress->delivery_nilai_billcomp = $value && is_numeric($rawEst) ? (float) $rawEst : null;

            foreach ($autoFields as $fld) {
                $taskProgress->{$fld} = $value;
            }
        }

        $taskProgress->save();

        $total = \App\Models\TaskProgress::whereHas('task', fn($q) => $q->where('data_type', $request->data_type))
            ->where('user_id', auth()->id())
            ->whereDate('tanggal', today())
            ->where('delivery_billing_complete', true)
            ->whereNotNull('delivery_nilai_billcomp')
            ->sum('delivery_nilai_billcomp');

        return response()->json([
            'success'        => true,
            'nilai_billcomp' => $taskProgress->delivery_nilai_billcomp,
            'total'          => number_format((float) $total, 0, ',', '.'),
            'auto_fields'    => $autoFields,
            'auto_value'     => $request->field === 'delivery_billing_complete' ? $value : null,
        ]);
    }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}