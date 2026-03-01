<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function c3mr()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = Collection::where('user_id', Auth::id())
            ->where('type', 'C3MR')
            ->where('status', 'active')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->exists();
            
        $activities = Collection::where('type', 'C3MR')
            ->orderBy('updated_at', 'desc')
            ->get();

        $comm = Collection::where('type', 'C3MR')
            ->orderBy('updated_at', 'asc')
            ->get();
        // dd($activities);
            
        return view('dashboard.collection.c3mr', compact('hasMonthlyCommitment', 'activities', 'comm'));
    }

    public function storeC3mrRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);

        Collection::create([
            'user_id' => Auth::id(),
            'type' => 'C3MR',
            'real_ratio' => $request->ratio_aktual,

        ]);
        
        return redirect()->back()->with('success', 'C3MR Realisasi berhasil disimpan');
    }

    public function billing()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = Collection::where('user_id', Auth::id())
            ->where('type', 'Billing Perdana')
            ->where('status', 'active')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->exists();
            
        $activities = Collection::where('type', 'Billing Perdana')
            ->orderBy('updated_at', 'desc')
            ->get();

        $bill = Collection::where('type', 'Billing Perdana')
            ->orderBy('updated_at', 'asc')
            ->get();
        // dd($activities);
            
        return view('dashboard.collection.billing', compact('hasMonthlyCommitment', 'activities', 'bill'));
    }

    public function storeBillingRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);

        Collection::create([
            'user_id' => Auth::id(),
            'type' => 'Billing Perdana',
            'real_ratio' => $request->ratio_aktual,

        ]);
        
        return redirect()->back()->with('success', 'Billing Perdana Realisasi berhasil disimpan');
    }

    public function cr()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = Collection::where('user_id', Auth::id())
            ->where('type', 'Collection Ratio')
            ->where('status', 'active')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->exists();
            
        $activities = Collection::where('type', 'Collection Ratio')
            ->orderBy('updated_at', 'desc')
            ->get();

        $ratio = Collection::where('type', 'Collection Ratio')
            ->orderBy('updated_at', 'asc')
            ->get();
        // dd($activities);
            
        return view('dashboard.collection.collectionRatio', compact('hasMonthlyCommitment', 'activities', 'ratio'));
    }

    public function storeCrRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
        ]);

        Collection::create([
            'user_id' => Auth::id(),
            'type' => 'Collection Ratio',
            'real_ratio' => $request->ratio_aktual,

        ]);
        
        return redirect()->back()->with('success', 'Collection Ratio Realisasi berhasil disimpan');
    }

    public function utip()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $hasMonthlyCommitment = Collection::where('user_id', Auth::id())
            ->where('type', 'like', '%UTIP%')
            ->where('status', 'active')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->exists();
            
        $activities = Collection::where('type', 'like', '%UTIP%')
            ->orderBy('updated_at', 'desc')
            ->get();

        $utips = Collection::select('id', 'type', 'commitment')
            ->where('type', 'like', '%UTIP%')
            ->get()
            ->unique('type')
            ->values();
        // dd($activities);
            
        return view('dashboard.collection.utip', compact('hasMonthlyCommitment', 'activities', 'utips'));
    }

    public function storeUtipRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
            'type' => 'required|string',
        ]);

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // try to find an existing entry for this user/type in the current month/year
        $existing = Collection::where('user_id', Auth::id())
            ->where('type', $request->type)
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->first();

        $data = [
            'user_id' => Auth::id(),
            'type' => $request->type,
            'commitment' => $request->commitment_value ?? 0,
            'real_ratio' => $request->ratio_aktual,
        ];

        if ($existing) {
            $existing->update($data);
        } else {
            Collection::create($data);
        }

        return redirect()->back()->with('success', 'UTIP Realisasi berhasil disimpan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
