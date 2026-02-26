<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\C3mr;
use App\Models\BillingPerdanan;
use App\Models\UtipData;
use App\Models\CollectionRatioData;
use Carbon\Carbon;

class CollectionController extends Controller
{
    public function dashboard()
    {
        return view('collection.dashboard');
    }
    
    public function c3mr()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = C3mr::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $activities = C3mr::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.c3mr', compact('hasMonthlyCommitment', 'activities'));
    }
    
    public function billingPerdanan()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = BillingPerdanan::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $activities = BillingPerdanan::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.billing-perdanan', compact('hasMonthlyCommitment', 'activities'));
    }
    
    public function collectionRatio()
    {
        return view('collection.collection-ratio');
    }
    
    public function crGov()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'GOV')
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'GOV')
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.cr-gov', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function crPrivate()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'PRIVATE')
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'PRIVATE')
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.cr-private', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function crSme()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'SME')
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'SME')
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.cr-sme', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function crSoe()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'SOE')
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = CollectionRatioData::where('user_id', Auth::id())
            ->where('segment', 'SOE')
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.cr-soe', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function utip()
    {
        return view('collection.utip');
    }
    
    public function utipNew()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = UtipData::where('user_id', Auth::id())
            ->where('category', 'New UTIP')
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = UtipData::where('user_id', Auth::id())
            ->where('category', 'New UTIP')
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.utip-new', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function utipCorrective()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Definisi currentPeriod
        $currentPeriod = Carbon::now()->translatedFormat('F Y');
        
        // Cek apakah user sudah input komitmen bulan ini
        $hasMonthlyCommitment = UtipData::where('user_id', Auth::id())
            ->where('category', 'Corrective UTIP')
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
        
        // Ambil data plan yang sudah ada untuk periode ini
        $existingPlan = UtipData::where('user_id', Auth::id())
            ->where('category', 'Corrective UTIP')
            ->where('type', 'plan')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        // Ambil data komitmen yang sudah ada untuk periode ini
        $existingCommitment = UtipData::where('user_id', Auth::id())
            ->where('category', 'Corrective UTIP')
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->first();
        
        // Ambil data realisasi terbaru
        $latestRealisasi = UtipData::where('user_id', Auth::id())
            ->where('category', 'Corrective UTIP')
            ->where('type', 'realisasi')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->latest('created_at')
            ->first();
            
        // Ambil semua history data
        $data = UtipData::where('user_id', Auth::id())
            ->where('category', 'Corrective UTIP')
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('collection.utip-corrective', compact(
            'hasMonthlyCommitment', 
            'data', 
            'currentPeriod', 
            'existingPlan', 
            'existingCommitment', 
            'latestRealisasi'
        ));
    }
    
    // Store Methods for Data Submission
    
    // UTIP New
    public function storeUtipNewPlan(Request $request)
    {
        // $request->validate([
        //     'value' => 'required|numeric',
        // ]);
        
        // UtipData::create([
        //     'user_id' => Auth::id(),
        //     'entry_date' => Carbon::now(),
        //     'type' => 'plan',
        //     'category' => 'New UTIP',
        //     'value' => $request->value,
        //     'month' => Carbon::now()->month,
        //     'year' => Carbon::now()->year,
        // ]);

        return redirect()->back()->with('success', 'UTIP New Plan berhasil disimpan');
    }
    
    public function storeUtipNewKomitmen(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);
        
        UtipData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'category' => 'New UTIP',
            'value' => $request->value,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'UTIP New Komitmen berhasil disimpan');
    }
    
    public function storeUtipNewRealisasi(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);
        
        UtipData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'category' => 'New UTIP',
            'value' => $request->value,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'UTIP New Realisasi berhasil disimpan');
    }
    
    // UTIP Corrective
    public function storeUtipCorrectivePlan(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);
        
        UtipData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'plan',
            'category' => 'Corrective UTIP',
            'value' => $request->value,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);

        // Plan is not implemented yet - just redirect
        return redirect()->back()->with('success', 'UTIP Corrective Plan berhasil disimpan');
    }
    
    public function storeUtipCorrectiveKomitmen(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);
        
        UtipData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'category' => 'Corrective UTIP',
            'value' => $request->value,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'UTIP Corrective Komitmen berhasil disimpan');
    }
    
    public function storeUtipCorrectiveRealisasi(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);
        
        UtipData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'category' => 'Corrective UTIP',
            'value' => $request->value,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'UTIP Corrective Realisasi berhasil disimpan');
    }
    
    // CR Government
    public function storeCrGovKomitmen(Request $request)
    {
        $request->validate([
            'target_ratio' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'segment' => 'GOV',
            'target_ratio' => $request->target_ratio,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR Government Komitmen berhasil disimpan');
    }
    
    public function storeCrGovRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'segment' => 'GOV',
            'ratio_aktual' => $request->ratio_aktual,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR Government Realisasi berhasil disimpan');
    }
    
    // CR Private
    public function storeCrPrivateKomitmen(Request $request)
    {
        $request->validate([
            'target_ratio' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'segment' => 'PRIVATE',
            'target_ratio' => $request->target_ratio,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR Private Komitmen berhasil disimpan');
    }
    
    public function storeCrPrivateRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'segment' => 'PRIVATE',
            'ratio_aktual' => $request->ratio_aktual,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR Private Realisasi berhasil disimpan');
    }
    
    // CR SME
    public function storeCrSmeKomitmen(Request $request)
    {
        $request->validate([
            'target_ratio' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'segment' => 'SME',
            'target_ratio' => $request->target_ratio,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR SME Komitmen berhasil disimpan');
    }
    
    public function storeCrSmeRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'segment' => 'SME',
            'ratio_aktual' => $request->ratio_aktual,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR SME Realisasi berhasil disimpan');
    }
    
    // CR SOE
    public function storeCrSoeKomitmen(Request $request)
    {
        $request->validate([
            'target_ratio' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'segment' => 'SOE',
            'target_ratio' => $request->target_ratio,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR SOE Komitmen berhasil disimpan');
    }
    
    public function storeCrSoeRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);
        
        CollectionRatioData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'segment' => 'SOE',
            'ratio_aktual' => $request->ratio_aktual,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'CR SOE Realisasi berhasil disimpan');
    }
    
    // C3MR
    public function storeC3mrKomitmen(Request $request)
    {
        $request->validate([
            'target_ratio' => 'required|numeric',
        ]);
        
        C3mr::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'ratio' => $request->target_ratio,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'C3MR Komitmen berhasil disimpan');
    }
    
    public function storeC3mrRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);
        
        C3mr::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'ratio' => $request->ratio_aktual,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'C3MR Realisasi berhasil disimpan');
    }
    
    // Billing Perdanan
    public function storeBillingKomitmen(Request $request)
    {
        $request->validate([
            'target_ratio' => 'required|numeric',
        ]);
        
        BillingPerdanan::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'komitmen',
            'ratio' => $request->target_ratio,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'Billing Perdanan Komitmen berhasil disimpan');
    }
    
    public function storeBillingRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);
        
        BillingPerdanan::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => 'realisasi',
            'ratio' => $request->ratio_aktual,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        return redirect()->back()->with('success', 'Billing Perdanan Realisasi berhasil disimpan');
    }
}
