<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LopPrivateOnHandImport;
use App\Models\LopPrivateQualifiedImport;
use App\Models\LopPrivateInitiatedImport;
use App\Models\LopPrivateCorrectionImport;
use App\Models\LopAdminNote;
use App\Models\FunnelTracking;
use App\Models\PsakPrivate;
use Illuminate\Support\Facades\Auth;

class PrivateController extends Controller
{
    public function dashboard()
    {
        return view('private.dashboard');
    }
    
    public function scalling()
    {
        return view('private.scalling');
    }
    
    public function psak()
    {
        $userId = auth()->id();
        $today = now()->format('Y-m-d');
        
        $psak = PsakPrivate::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();
        
        return view('private.psak', compact('psak'));
    }
    
    public function savePsak(Request $request)
    {
        $validated = $request->validate([
            'commitment_ssl' => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'commitment_rp' => 'nullable|numeric',
            'real_rp' => 'nullable|numeric',
        ]);
        
        $psak = PsakPrivate::updateOrCreate(
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
        
        $latestImport = LopPrivateOnHandImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'private')
            ->where('category', 'on_hand')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('private.lop-on-hand', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopQualified()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopPrivateQualifiedImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'private')
            ->where('category', 'qualified')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('private.lop-qualified', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopInitiated()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopPrivateInitiatedImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'private')
            ->where('category', 'initiated')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('private.lop-initiated', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
    }
    
    public function lopCorrection()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopPrivateCorrectionImport::with(['data.funnel.todayProgress'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest()
            ->first();
        
        $adminNote = LopAdminNote::where('entity_type', 'private')
            ->where('category', 'correction')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        return view('private.lop-correction', compact('latestImport', 'adminNote', 'currentMonth', 'currentYear'));
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
