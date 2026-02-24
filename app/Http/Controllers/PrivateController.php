<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LopPrivateOnHandImport;
use App\Models\LopPrivateQualifiedImport;
use App\Models\LopPrivateInitiatedImport;
use App\Models\LopPrivateCorrectionImport;
use App\Models\LopAdminNote;
use App\Models\FunnelTracking;
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
    
    public function lopOnHand()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopPrivateOnHandImport::with(['data.funnel'])
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
        
        $latestImport = LopPrivateQualifiedImport::with(['data.funnel'])
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
        
        $latestImport = LopPrivateInitiatedImport::with(['data.funnel'])
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
        
        $latestImport = LopPrivateCorrectionImport::with(['data.funnel'])
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
        $dataId = $request->input('data_id');
        $dataType = $request->input('data_type');
        $field = $request->input('field');
        $value = $request->input('value');
        
        $funnel = FunnelTracking::updateOrCreate(
            [
                'data_id' => $dataId,
                'data_type' => $dataType,
            ],
            [
                $field => $value == 'true' || $value === true,
                'updated_by' => Auth::id(),
                'last_updated_at' => now(),
            ]
        );
        
        // Calculate total if billing complete
        $total = 0;
        if ($field === 'delivery_billing_complete' && ($value == 'true' || $value === true)) {
            $estNilaiBc = $request->input('est_nilai_bc', 0);
            $total = (int) str_replace(['.', ','], '', $estNilaiBc);
        }
        
        return response()->json([
            'success' => true,
            'nilai_billcomp' => $total,
            'total' => number_format($total, 0, ',', '.'),
            'updated_by' => Auth::user()->name ?? 'System',
            'updated_at' => now()->format('d M Y H:i'),
        ]);
    }
}
