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
        return view('gov.psak');
    }
    
    public function lopOnHand()
    {
        $currentMonth = request()->get('month', date('n'));
        $currentYear = request()->get('year', date('Y'));
        
        $latestImport = LopOnHandImport::with(['data.funnel'])
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
        
        $latestImport = LopQualifiedImport::with(['data.funnel'])
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
        
        $latestImport = LopKoreksiImport::with(['data.funnel'])
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
        
        $data = LopInitiateData::with('funnel')
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
    
    public function updateFunnelCheckbox(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:on_hand,qualified,koreksi,initiate',
            'data_id' => 'required|integer',
            'field' => 'required|string',
            'value' => 'required|boolean',
            'est_nilai_bc' => 'nullable|numeric',
        ]);
        
        $funnel = \App\Models\FunnelTracking::firstOrCreate(
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
        $total = \App\Models\FunnelTracking::where('data_type', $request->data_type)
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
