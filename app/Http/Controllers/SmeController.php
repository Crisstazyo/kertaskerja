<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LopSmeOnHandImport;
use App\Models\LopSmeQualifiedImport;
use App\Models\LopSmeInitiatedImport;
use App\Models\LopSmeCorrectionImport;
use App\Models\LopAdminNote;
use App\Models\FunnelTracking;
use Illuminate\Support\Facades\Auth;

class SmeController extends Controller
{
    public function dashboard()
    {
        return view('sme.dashboard');
    }
    
    public function scalling()
    {
        return view('sme.scalling');
    }
    
    public function lopOnHand()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSmeOnHandImport::with(['data.funnel'])
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
        
        $latestImport = LopSmeQualifiedImport::with(['data.funnel'])
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
        
        $latestImport = LopSmeInitiatedImport::with(['data.funnel'])
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
    
    public function lopCorrection()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopSmeCorrectionImport::with(['data.funnel'])
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
            'value' => 'required|boolean',
            'est_nilai_bc' => 'nullable|numeric',
        ]);
        
        $funnel = FunnelTracking::firstOrCreate(
            [
                'data_type' => $request->data_type,
                'data_id' => $request->data_id,
            ]
        );
        
        // Update the checkbox field
        $funnel->{$request->field} = $request->value;
        
        // Track user and timestamp
        $funnel->updated_by = auth()->id();
        $funnel->last_updated_at = now();
        
        // If the field is delivery_billing_complete and it's being checked
        if ($request->field === 'delivery_billing_complete' && $request->value) {
            // Set delivery_nilai_billcomp to est_nilai_bc value
            $funnel->delivery_nilai_billcomp = $request->est_nilai_bc ?? 0;
        } elseif ($request->field === 'delivery_billing_complete' && !$request->value) {
            // If unchecked, clear the nilai_billcomp
            $funnel->delivery_nilai_billcomp = null;
        }
        
        $funnel->save();
        
        // Calculate total for all billing complete values in this data type
        $total = FunnelTracking::where('data_type', $request->data_type)
            ->where('delivery_billing_complete', true)
            ->whereNotNull('delivery_nilai_billcomp')
            ->sum('delivery_nilai_billcomp');
        
        return response()->json([
            'success' => true,
            'nilai_billcomp' => $funnel->delivery_nilai_billcomp,
            'total' => number_format($total, 0, ',', '.'),
            'updated_by' => auth()->user()->name,
            'updated_at' => $funnel->last_updated_at->format('d M Y H:i'),
        ]);
    }
}
