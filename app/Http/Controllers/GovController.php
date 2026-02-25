<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScallingData;
use App\Models\ScallingGovResponse;
use App\Models\LopOnHandImport;
use App\Models\LopQualifiedImport;
use App\Models\LopKoreksiImport;
use App\Models\LopInitiateData;
use App\Models\LopAdminNote;
use App\Models\PsakGovernment;
use Illuminate\Support\Facades\Auth;

class GovController extends Controller
{
    public function dashboard()
    {
        return view('gov.dashboard');
    }
    
    public function scalling()
    {
        // Scalling page acts as parent menu for LOP categories
        return view('gov.scalling');
    }
    
    public function psak()
    {
        $userId = auth()->id();
        $today = now()->format('Y-m-d');
        
        $psak = PsakGovernment::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();
        
        return view('gov.psak', compact('psak'));
    }
    
    public function savePsak(Request $request)
    {
        $validated = $request->validate([
            'commitment_ssl' => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'commitment_rp' => 'nullable|numeric',
            'real_rp' => 'nullable|numeric',
        ]);
        
        $psak = PsakGovernment::updateOrCreate(
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
        
        $latestImport = LopOnHandImport::with(['data.funnel.todayProgress'])
            ->where('entity_type', 'government')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        // Get admin note
        $adminNote = LopAdminNote::where('entity_type', 'government')
            ->where('category', 'on_hand')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('gov.lop-on-hand', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopQualified()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopQualifiedImport::with(['data.funnel.todayProgress'])
            ->where('entity_type', 'government')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'government')
            ->where('category', 'qualified')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('gov.lop-qualified', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopKoreksi()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopKoreksiImport::with(['data.funnel.todayProgress'])
            ->where('entity_type', 'government')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'government')
            ->where('category', 'koreksi')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('gov.lop-koreksi', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopInitiate()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $data = LopInitiateData::with('funnel.todayProgress')
            ->where('entity_type', 'government')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->get();
        
        $adminNote = LopAdminNote::where('entity_type', 'government')
            ->where('category', 'initiate')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('gov.lop-initiate', compact('data', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function createLopInitiate()
    {
        return view('gov.lop-initiate-create');
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
        
        // Get the last no for auto-increment
        $lastNo = LopInitiateData::where('entity_type', 'government')
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->max('no');
        
        // Create new project
        $project = LopInitiateData::create([
            'entity_type' => 'government',
            'created_by' => auth()->user()->name ?? 'User',
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
        
        return redirect()->route('gov.lop.initiate', [
            'month' => $validated['month'],
            'year' => $validated['year']
        ])->with('success', 'Project has been successfully added to LOP Initiate!');
    }
    
    public function lopInitiated()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        // Note: Government doesn't have separate initiated import model like private/soe/sme
        // Using the same data as lopInitiate for now
        $data = LopInitiateData::with('funnel.todayProgress')
            ->where('entity_type', 'government')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->get();
        
        $adminNote = LopAdminNote::where('entity_type', 'government')
            ->where('category', 'initiated')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('gov.lop-initiated', compact('data', 'adminNote', 'currentMonth', 'currentYear'));
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
        $estNilai = $request->est_nilai_bc ? floatval(str_replace([',', '.'], '', $request->est_nilai_bc)) : 0;
        
        // Find or create the funnel tracking record
        $funnel = \App\Models\FunnelTracking::firstOrCreate(
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
