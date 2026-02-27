<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LopSmeOnHandImport;
use App\Models\LopSmeQualifiedImport;
use App\Models\LopSmeInitiatedImport;
use App\Models\LopSmeInitiatedData;
use App\Models\LopSmeCorrectionImport;
use App\Models\LopAdminNote;
use App\Models\FunnelTracking;
use App\Models\PsakSme;
use App\Models\ScallingHsiAgency;
use App\Models\ScallingTelda;
use App\Models\ScallingData;
use App\Models\ScallingGovResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SmeController extends Controller
{
    public function createLopInitiate()
    {
        return view('sme.lop-initiate-create');
    }

    public function storeLopInitiate(Request $request)
    {
        $validated = $request->validate([
            'project' => 'required|string|max:255',
            'id_lop' => 'nullable|string|max:255',
            'cc' => 'nullable|string|max:255',
            'nipnas' => 'nullable|string|max:255',
            'am' => 'nullable|string|max:255',
            'mitra' => 'nullable|string|max:255',
            'plan_bulan_billcom_p_2025' => 'nullable|string|max:255',
            'est_nilai_bc' => 'nullable|numeric',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
        ]);

        $lastNo = LopSmeInitiatedData::where('import_id', $validated['month'])
            ->where('year', $validated['year'])
            ->max('no');

        $project = LopSmeInitiatedData::create([
            'import_id' => $validated['month'],
            'added_by_user_id' => auth()->id(),
            'is_user_added' => true,
            'no' => $lastNo ? $lastNo + 1 : 1,
            'project' => $validated['project'],
            'id_lop' => $validated['id_lop'],
            'cc' => $validated['cc'],
            'nipnas' => $validated['nipnas'],
            'am' => $validated['am'],
            'mitra' => $validated['mitra'],
            'plan_bulan_billcom_p_2025' => $validated['plan_bulan_billcom_p_2025'],
            'est_nilai_bc' => $validated['est_nilai_bc'],
            'month' => $validated['month'],
            'year' => $validated['year'],
        ]);

        return redirect()->route('sme.lop.initiate', [
            'month' => $validated['month'],
            'year' => $validated['year']
        ])->with('success', 'Project has been successfully added to LOP Initiate!');
    }
    public function dashboard()
    {
        return view('sme.dashboard');
    }
    
    public function scalling()
    {
        return view('sme.scalling');
    }
    
    public function psak()
    {
        $userId = auth()->id();
        $today = now()->format('Y-m-d');
        
        $psak = PsakSme::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();
        
        return view('sme.psak', compact('psak'));
    }
    
    public function savePsak(Request $request)
    {
        $validated = $request->validate([
            'commitment_ssl' => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'commitment_rp' => 'nullable|numeric',
            'real_rp' => 'nullable|numeric',
        ]);
        
        $psak = PsakSme::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'tanggal' => now()->format('Y-m-d')
            ],
            $validated
        );
        
        return response()->json([
            'success' => true,
            'message' => 'PSAK data saved successfully',
            'data' => $psak
        ]);
    }
    
    public function lopOnHand()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSmeOnHandImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'sme')
            ->where('category', 'on_hand')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('sme.lop-on-hand', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopQualified()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSmeQualifiedImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'sme')
            ->where('category', 'qualified')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('sme.lop-qualified', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopInitiated()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSmeInitiatedImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'sme')
            ->where('category', 'initiated')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('sme.lop-initiated', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function createLopInitiated()
    {
        return view('sme.lop-initiated-create');
    }
    
    public function storeLopInitiated(Request $request)
    {
        $validated = $request->validate([
            'project' => 'required|string|max:255',
            'id_lop' => 'nullable|string|max:255',
            'cc' => 'nullable|string|max:255',
            'nipnas' => 'nullable|string|max:255',
            'am' => 'nullable|string|max:255',
            'mitra' => 'nullable|string|max:255',
            'plan_bulan_billcom_p_2025' => 'nullable|string|max:255',
            'est_nilai_bc' => 'nullable|numeric',
        ]);
        
        // Create a dummy import to attach the data
        $import = LopSmeInitiatedImport::firstOrCreate([
            'month' => date('n'),
            'year' => date('Y'),
            'file_name' => 'User Added Data',
            'uploaded_by' => 'user_' . auth()->id(),
        ]);
        
        // Get the last no for auto-increment
        $lastNo = LopSmeInitiatedData::where('import_id', $import->id)
            ->max('no');
        
        // Create new project
        $project = LopSmeInitiatedData::create([
            'import_id' => $import->id,
            'added_by_user_id' => auth()->id(),
            'is_user_added' => true,
            'no' => $lastNo ? $lastNo + 1 : 1,
            'project' => $validated['project'],
            'id_lop' => $validated['id_lop'],
            'cc' => $validated['cc'],
            'nipnas' => $validated['nipnas'],
            'am' => $validated['am'],
            'mitra' => $validated['mitra'],
            'plan_bulan_billcom_p_2025' => $validated['plan_bulan_billcom_p_2025'],
            'est_nilai_bc' => $validated['est_nilai_bc'],
        ]);
        
        return redirect()->route('sme.lop.initiated', [
            'month' => date('n'),
            'year' => date('Y')
        ])->with('success', 'Project has been successfully added to LOP Initiated!');
    }
    
    public function lopCorrection()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSmeCorrectionImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'sme')
            ->where('category', 'correction')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('sme.lop-correction', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function updateFunnelCheckbox(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:on_hand,qualified,koreksi,initiate,initiated,correction',
            'data_id' => 'required|integer',
            'field' => 'required|string',
            'value' => 'required',
            'est_nilai_bc' => 'nullable',
        ]);
        
        // Convert value to boolean (handles both true/false and "true"/"false")
        $value = filter_var($request->value, FILTER_VALIDATE_BOOLEAN);
        $estNilai = $request->est_nilai_bc ? floatval(str_replace([',', '.'], '', $request->est_nilai_bc)) : 0;
        
        // Find or create the funnel tracking record
        $funnel = FunnelTracking::firstOrCreate(
            [
                'data_type' => $request->data_type,
                'data_id' => $request->data_id,
            ]
        );
        
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
        
        // If the field is delivery_billing_complete and it's being checked
        if ($request->field === 'delivery_billing_complete' && $value) {
            // Set delivery_nilai_billcomp to est_nilai_bc value
            $taskProgress->delivery_nilai_billcomp = $estNilai;
        } elseif ($request->field === 'delivery_billing_complete' && !$value) {
            // If unchecked, clear the nilai_billcomp
            $taskProgress->delivery_nilai_billcomp = null;
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
        ]);
    }

    // Asodomoro 0-3 Bulan
    public function asodomoro03Bulan()
    {
        $user = auth()->user();
        $history = \App\Models\Asodomoro03BulanData::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('sme.asodomoro-0-3-bulan', compact('user', 'history'));
    }

    public function storeAsodomoro03Bulan(Request $request)
    {
        $validated = $request->validate([
            'realisasi' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['entry_date'] = now()->toDateString();
        $validated['type'] = 'Realisasi';
        $validated['month'] = now()->month;
        $validated['year'] = now()->year;

        \App\Models\Asodomoro03BulanData::create($validated);

        return redirect()->route('sme.asodomoro-0-3-bulan')
            ->with('success', 'Realisasi Asodomoro 0-3 Bulan berhasil disimpan.');
    }

    // Asodomoro Above 3 Bulan
    public function asodomoroAbove3Bulan()
    {
        $user = auth()->user();
        $history = \App\Models\AsodomoroAbove3BulanData::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('sme.asodomoro-above-3-bulan', compact('user', 'history'));
    }

    public function storeAsodomoroAbove3Bulan(Request $request)
    {
        $validated = $request->validate([
            'realisasi' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['entry_date'] = now()->toDateString();
        $validated['type'] = 'Realisasi';
        $validated['month'] = now()->month;
        $validated['year'] = now()->year;

        \App\Models\AsodomoroAbove3BulanData::create($validated);

        return redirect()->route('sme.asodomoro-above-3-bulan')
            ->with('success', 'Realisasi Asodomoro >3 Bulan berhasil disimpan.');
    }

    // HSI Agency — User inputs Real
    public function hsiAgency()
    {
        $currentPeriode = Carbon::now()->format('Y-m') . '-01';
        $record = ScallingHsiAgency::where('periode', $currentPeriode)->first();
        $history = ScallingHsiAgency::orderBy('periode', 'desc')->get();
        return view('sme.scalling-hsi-agency', compact('record', 'history'));
    }

    public function storeHsiAgency(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'real'    => 'required|integer|min:0',
        ]);

        $periode = strlen($request->periode) === 7
            ? $request->periode . '-01'
            : $request->periode;

        $record = ScallingHsiAgency::where('periode', $periode)->first();

        if (!$record || is_null($record->commitment)) {
            return redirect()->back()->with('error', 'Admin belum mengatur commitment untuk periode ini.');
        }

        ScallingHsiAgency::updateOrCreate(
            ['periode' => $periode],
            ['real' => $request->real, 'user_id' => Auth::id()]
        );

        return redirect()->back()->with('success', 'Realisasi HSI Agency berhasil disimpan!');
    }

    // Scalling Telda — User inputs Real per Telda
    public function scallingTelda()
    {
        $currentPeriode = Carbon::now()->format('Y-m') . '-01';
        $record  = ScallingTelda::where('periode', $currentPeriode)->first();
        $history = ScallingTelda::orderBy('periode', 'desc')->get();
        $teldas  = ScallingTelda::TELDA_LOCATIONS;
        return view('sme.scalling-telda', compact('record', 'history', 'teldas'));
    }

    public function storeTelda(Request $request)
    {
        $request->validate(['periode' => 'required|string']);

        $periode = strlen($request->periode) === 7
            ? $request->periode . '-01'
            : $request->periode;

        $record    = ScallingTelda::where('periode', $periode)->first();
        $teldaKeys = array_keys(ScallingTelda::TELDA_LOCATIONS);
        $fields    = ['user_id' => Auth::id(), 'periode' => $periode];

        foreach ($teldaKeys as $telda) {
            $commitmentKey = $telda . '_commitment';
            $realKey       = $telda . '_real';
            $hasCommitment = $record && !is_null($record->$commitmentKey);

            if ($hasCommitment && $request->has($realKey) && $request->input($realKey) !== null) {
                $fields[$realKey] = $request->input($realKey);
            }
        }

        // Update the same global record so admin can see
        if ($record) {
            $record->update($fields);
        } else {
            return redirect()->back()->with('error', 'Admin belum mengatur commitment untuk periode ini.');
        }

        return redirect()->back()->with('success', 'Data Realisasi Telda berhasil disimpan!');
    }

    // ── Scalling LOP Table (ScallingData-based) ──────────────────────────────

    public function scallingLopTable($lopType)
    {
        $validTypes = ['on-hand', 'qualified', 'koreksi', 'initiate'];
        if (!in_array($lopType, $validTypes)) abort(404);

        $roleNormalized = 'sme';
        $lopTypeDisplay = ucfirst(str_replace('-', ' ', $lopType));
        $dataType       = 'scalling_' . $roleNormalized . '_' . $lopType;

        $latestData = ScallingData::where('role', $roleNormalized)
            ->where('lop_type', $lopType)
            ->latest()
            ->first();

        $funnelByRow = collect();
        if ($latestData) {
            $funnelByRow = \App\Models\FunnelTracking::where('data_type', $dataType)
                ->with(['todayProgress' => function ($q) {
                    $q->where('user_id', auth()->id())->whereDate('tanggal', today());
                }])
                ->get()
                ->keyBy('data_id');
        }

        return view('user.scalling-lop-table', compact(
            'latestData', 'funnelByRow', 'lopType', 'lopTypeDisplay', 'roleNormalized', 'dataType'
        ));
    }

    public function updateScallingFunnel(Request $request)
    {
        $request->validate([
            'data_type'    => 'required|string',
            'data_id'      => 'required|integer',
            'field'        => 'required|string',
            'value'        => 'required',
            'est_nilai_bc' => 'nullable',
        ]);

        $value    = filter_var($request->value, FILTER_VALIDATE_BOOLEAN);
        $estNilai = $request->est_nilai_bc
            ? floatval(str_replace([',', '.'], '', $request->est_nilai_bc)) : 0;

        $funnel = \App\Models\FunnelTracking::firstOrCreate([
            'data_type' => $request->data_type,
            'data_id'   => $request->data_id,
        ]);

        $taskProgress = \App\Models\TaskProgress::firstOrCreate([
            'task_id' => $funnel->id,
            'user_id' => auth()->id(),
            'tanggal' => today(),
        ]);

        $taskProgress->{$request->field} = $value;
        if ($request->field === 'delivery_billing_complete' && $value) {
            $taskProgress->delivery_nilai_billcomp = $estNilai;
        } elseif ($request->field === 'delivery_billing_complete' && !$value) {
            $taskProgress->delivery_nilai_billcomp = null;
        }
        $taskProgress->save();

        $total = (float) \App\Models\TaskProgress::whereHas('task', fn ($q) =>
                $q->where('data_type', $request->data_type))
            ->where('user_id', auth()->id())
            ->whereDate('tanggal', today())
            ->where('delivery_billing_complete', true)
            ->whereNotNull('delivery_nilai_billcomp')
            ->sum('delivery_nilai_billcomp');

        return response()->json([
            'success'                  => true,
            'delivery_nilai_billcomp'  => $taskProgress->delivery_nilai_billcomp,
            'total'                    => number_format((float) $total, 0, ',', '.'),
        ]);
    }
}
