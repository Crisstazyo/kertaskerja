<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaidCt0Data;
use App\Models\CombatChurnData;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CtcController extends Controller
{
    public function dashboard()
    {
        return view('ctc.dashboard');
    }
    
    public function paidCt0()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = PaidCt0Data::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = PaidCt0Data::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('ctc.paid-ct0', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function combatTheChurn()
    {
        return view('ctc.combat-the-churn');
    }
    
    public function combatChurnCt0()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CombatChurnData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'ct0')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CombatChurnData::where('user_id', Auth::id())
            ->where('category', 'ct0')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('ctc.combat-churn-ct0', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function combatChurnSalesHsi()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CombatChurnData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'sales_hsi')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CombatChurnData::where('user_id', Auth::id())
            ->where('category', 'sales_hsi')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('ctc.combat-churn-sales-hsi', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function combatChurnChurn()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CombatChurnData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'churn')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CombatChurnData::where('user_id', Auth::id())
            ->where('category', 'churn')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('ctc.combat-churn-churn', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function combatChurnWinback()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CombatChurnData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'winback')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CombatChurnData::where('user_id', Auth::id())
            ->where('category', 'winback')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('ctc.combat-churn-winback', compact('hasMonthlyCommitment', 'data'));
    }
    
    // Store Methods for Data Submission
    
    public function storePaidCt0(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'region' => 'required|string',
            'nominal' => 'required|numeric|min:0',
        ]);
        
        PaidCt0Data::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'region' => $validated['region'],
            'nominal' => $validated['nominal'],
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Paid CT0 {$message} berhasil disimpan");
    }
    
    public function storeCombatTheChurn(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'category' => 'required|in:winback,sales_hsi,churn',
            'region' => 'required|string',
            'quantity' => 'required|integer|min:0',
        ]);
        
        CombatChurnData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'category' => $validated['category'],
            'region' => $validated['region'],
            'quantity' => $validated['quantity'],
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Combat The Churn {$message} berhasil disimpan");
    }
}
