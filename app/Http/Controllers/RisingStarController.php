<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asodomoro03BulanData;
use App\Models\AsodomoroAbove3BulanData;
use App\Models\VisitingData;
use App\Models\ProfilingData;
use App\Models\KecukupanLopData;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RisingStarController extends Controller
{
    public function dashboard()
    {
        return view('rising-star.dashboard');
    }
    
    public function risingStar1()
    {
        return view('rising-star.rising-star-1');
    }
    
    public function risingStar2()
    {
        return view('rising-star.rising-star-2');
    }
    
    public function risingStar3()
    {
        return view('rising-star.rising-star-3');
    }
    
    public function risingStar4()
    {
        $data03 = Asodomoro03BulanData::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
        
        $dataAbove3 = AsodomoroAbove3BulanData::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('rising-star.rising-star-4', compact('data03', 'dataAbove3'));
    }
    
    public function visitingGm()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = VisitingData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'visiting_gm')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = VisitingData::where('user_id', Auth::id())
            ->where('category', 'visiting_gm')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('rising-star.visiting-gm', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function visitingAm()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = VisitingData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'visiting_am')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = VisitingData::where('user_id', Auth::id())
            ->where('category', 'visiting_am')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('rising-star.visiting-am', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function visitingHotd()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = VisitingData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'visiting_hotd')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = VisitingData::where('user_id', Auth::id())
            ->where('category', 'visiting_hotd')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('rising-star.visiting-hotd', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function profilingMapsAm()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = ProfilingData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'profiling_maps_am')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = ProfilingData::where('user_id', Auth::id())
            ->where('category', 'profiling_maps_am')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('rising-star.profiling-maps-am', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function profilingOverallHotd()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = ProfilingData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('category', 'profiling_overall_hotd')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = ProfilingData::where('user_id', Auth::id())
            ->where('category', 'profiling_overall_hotd')
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('rising-star.profiling-overall-hotd', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function kecukupanLop()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = KecukupanLopData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = KecukupanLopData::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
        
        return view('rising-star.kecukupan-lop', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function asodomoro03Bulan()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = Asodomoro03BulanData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = Asodomoro03BulanData::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('rising-star.asodomoro-0-3-bulan', compact('hasMonthlyCommitment', 'data'));
    }
    
    public function asodomoroAbove3Bulan()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = AsodomoroAbove3BulanData::where('user_id', Auth::id())
            ->where('type', 'komitmen')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists();
            
        $data = AsodomoroAbove3BulanData::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->get();
            
        return view('rising-star.asodomoro-above-3-bulan', compact('hasMonthlyCommitment', 'data'));
    }
    
    // Store Methods for Data Submission
    
    public function storeVisitingGm(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'target_ratio' => 'nullable|numeric',
            'ratio_aktual' => 'nullable|numeric',
        ]);
        
        VisitingData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'category' => 'visiting_gm',
            'target_ratio' => $request->target_ratio,
            'ratio_aktual' => $request->ratio_aktual,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Visiting GM {$message} berhasil disimpan");
    }
    
    public function storeVisitingAm(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'target_ratio' => 'nullable|numeric',
            'ratio_aktual' => 'nullable|numeric',
        ]);
        
        VisitingData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'category' => 'visiting_am',
            'target_ratio' => $request->target_ratio,
            'ratio_aktual' => $request->ratio_aktual,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Visiting AM {$message} berhasil disimpan");
    }
    
    public function storeVisitingHotd(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'target_ratio' => 'nullable|numeric',
            'ratio_aktual' => 'nullable|numeric',
        ]);
        
        VisitingData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'category' => 'visiting_hotd',
            'target_ratio' => $request->target_ratio,
            'ratio_aktual' => $request->ratio_aktual,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Visiting HOTD {$message} berhasil disimpan");
    }
    
    public function storeProfilingMapsAm(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'target_ratio' => 'nullable|numeric',
            'ratio_aktual' => 'nullable|numeric',
        ]);
        
        ProfilingData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'category' => 'profiling_maps_am',
            'target_ratio' => $request->target_ratio,
            'ratio_aktual' => $request->ratio_aktual,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Profiling Maps AM {$message} berhasil disimpan");
    }
    
    public function storeProfilingOverallHotd(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'target_ratio' => 'nullable|numeric',
            'ratio_aktual' => 'nullable|numeric',
        ]);
        
        ProfilingData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'category' => 'profiling_overall_hotd',
            'target_ratio' => $request->target_ratio,
            'ratio_aktual' => $request->ratio_aktual,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Profiling Overall HOTD {$message} berhasil disimpan");
    }
    
    public function storeKecukupanLop(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'target_ratio' => 'nullable|numeric',
            'ratio_aktual' => 'nullable|numeric',
        ]);
        
        KecukupanLopData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'target_ratio' => $request->target_ratio,
            'ratio_aktual' => $request->ratio_aktual,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Kecukupan LOP {$message} berhasil disimpan");
    }
    
    public function storeAsodomoro(Request $request)
    {
        // General asodomoro - not used currently
        return redirect()->back()->with('success', 'Data Asodomoro berhasil disimpan');
    }
    
    public function storeAsodomoro03Bulan(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'jml_asodomoro' => 'nullable|numeric',
            'nilai_bc' => 'nullable|numeric',
        ]);
        
        Asodomoro03BulanData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'jml_asodomoro' => $request->jml_asodomoro,
            'nilai_bc' => $request->nilai_bc,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Asodomoro 0-3 Bulan {$message} berhasil disimpan");
    }
    
    public function storeAsodomoroAbove3Bulan(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|in:komitmen,realisasi',
            'jml_asodomoro' => 'nullable|numeric',
            'nilai_bc' => 'nullable|numeric',
        ]);
        
        AsodomoroAbove3BulanData::create([
            'user_id' => Auth::id(),
            'entry_date' => Carbon::now(),
            'type' => $validated['form_type'],
            'jml_asodomoro' => $request->jml_asodomoro,
            'nilai_bc' => $request->nilai_bc,
            'keterangan' => $request->keterangan,
            'description' => $request->description,
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
        ]);
        
        $message = $validated['form_type'] === 'komitmen' ? 'Komitmen' : 'Realisasi';
        return redirect()->back()->with('success', "Data Asodomoro >3 Bulan {$message} berhasil disimpan");
    }
}
