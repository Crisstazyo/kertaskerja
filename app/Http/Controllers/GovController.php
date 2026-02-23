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
        $scallingData = ScallingData::with(['responses' => function($query) {
            $query->where('user_id', Auth::id());
        }])->latest()->get();
        
        return view('gov.scalling', compact('scallingData'));
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
}
