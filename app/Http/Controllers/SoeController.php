<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LopSoeOnHandImport;
use App\Models\LopSoeQualifiedImport;
use App\Models\LopSoeInitiatedImport;
use App\Models\LopSoeInitiatedData;
use App\Models\LopSoeCorrectionImport;
use App\Models\LopAdminNote;
use App\Models\FunnelTracking;
use App\Models\PsakSoe;
use Illuminate\Support\Facades\Auth;

class SoeController extends Controller
{
    public function createLopInitiate()
    {
        return view('soe.lop-initiate-create');
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

        $lastNo = LopSoeInitiatedData::where('import_id', $validated['month'])
            ->where('year', $validated['year'])
            ->max('no');

        $project = LopSoeInitiatedData::create([
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

        return redirect()->route('soe.lop.initiate', [
            'month' => $validated['month'],
            'year' => $validated['year']
        ])->with('success', 'Project has been successfully added to LOP Initiate!');
    }
    public function dashboard()
    {
        return view('soe.dashboard');
    }
    
    public function scalling()
    {
        return view('soe.scalling');
    }
    
    public function psak()
    {
        $userId = auth()->id();
        $today = now()->format('Y-m-d');
        
        $psak = PsakSoe::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();
        
        return view('soe.psak', compact('psak'));
    }
    
    public function savePsak(Request $request)
    {
        $validated = $request->validate([
            'commitment_ssl' => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'commitment_rp' => 'nullable|numeric',
            'real_rp' => 'nullable|numeric',
        ]);
        
        $psak = PsakSoe::updateOrCreate(
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
        
        $latestImport = LopSoeOnHandImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'soe')
            ->where('category', 'on_hand')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('soe.lop-on-hand', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopQualified()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSoeQualifiedImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'soe')
            ->where('category', 'qualified')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('soe.lop-qualified', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopInitiated()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSoeInitiatedImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'soe')
            ->where('category', 'initiated')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('soe.lop-initiated', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function createLopInitiated()
    {
        return view('soe.lop-initiated-create');
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
        $import = LopSoeInitiatedImport::firstOrCreate([
            'month' => date('n'),
            'year' => date('Y'),
            'file_name' => 'User Added Data',
            'uploaded_by' => 'user_' . auth()->id(),
        ]);
        
        // Get the last no for auto-increment
        $lastNo = LopSoeInitiatedData::where('import_id', $import->id)
            ->max('no');
        
        // Create new project
        $project = LopSoeInitiatedData::create([
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
        
        return redirect()->route('soe.lop.initiated', [
            'month' => date('n'),
            'year' => date('Y')
        ])->with('success', 'Project has been successfully added to LOP Initiated!');
    }
    
    public function lopCorrection()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSoeCorrectionImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'soe')
            ->where('category', 'correction')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('soe.lop-correction', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
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
            'total' => number_format($total, 0, ',', '.'),
        ]);
    }
}
