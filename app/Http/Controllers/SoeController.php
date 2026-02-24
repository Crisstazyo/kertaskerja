<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LopSoeOnHandImport;
use App\Models\LopSoeQualifiedImport;
use App\Models\LopSoeInitiatedImport;
use App\Models\LopSoeCorrectionImport;
use App\Models\LopAdminNote;
use App\Models\FunnelTracking;
use Illuminate\Support\Facades\Auth;

class SoeController extends Controller
{
    public function dashboard()
    {
        return view('soe.dashboard');
    }
    
    public function scalling()
    {
        return view('soe.scalling');
    }
    
    public function lopOnHand()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSoeOnHandImport::with(['data.funnel'])
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
        
        $latestImport = LopSoeQualifiedImport::with(['data.funnel'])
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
        
        $latestImport = LopSoeInitiatedImport::with(['data.funnel'])
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
    
    public function lopCorrection()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSoeCorrectionImport::with(['data.funnel'])
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
