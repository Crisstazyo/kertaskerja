<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
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

    public function c3mr(Request $request)
{
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;
    $currentDate = Carbon::now();

    $hasMonthlyCommitment = Collection::where('user_id', Auth::id())
        ->where('type', 'C3MR')
        ->where('status', 'active')
        ->whereYear('periode', $currentDate->year)
        ->whereMonth('periode', $currentDate->month)
        ->exists();

    $comm = Collection::where('type', 'C3MR')
        ->whereYear('periode', $currentDate->year)
        ->whereMonth('periode', $currentDate->month)
        ->where('status', 'active')
        ->whereHas('user', function ($query) {
            $query->where('role', 'admin');
        })
        ->whereNotNull('commitment')
        ->orderBy('updated_at', 'desc')
        ->first();

    $periode = Collection::where('type', 'C3MR')
        ->orderBy('updated_at', 'asc')
        ->whereYear('periode', $currentDate->year)
        ->whereMonth('periode', $currentDate->month)
        ->first();

    $query = Collection::where('type', 'C3MR')
        ->orderBy('updated_at', 'desc');

    if ($request->filled('bulan')) {
        $query->whereMonth('periode', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('periode', $request->tahun);
    }

    if ($request->filled('cari')) {
        $query->where(function($q) use ($request) {
            $q->where('real_ratio', 'like', '%'.$request->cari.'%')
              ->orWhere('commitment', 'like', '%'.$request->cari.'%');
        });
    }

    $activities = $query->paginate(10)->withQueryString();

    $tahuns = Collection::where('type', 'C3MR')
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;
    $selectedCari  = $request->cari;

    return view('dashboard.collection.c3mr', compact(
        'hasMonthlyCommitment', 'activities', 'comm', 'periode',
        'tahuns', 'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

    public function storeC3mrRealisasi(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'ratio_aktual' => 'required|numeric',
        ]);

        $lastCommitment = Collection::where('type', 'C3MR')
            ->where('periode', $request->periode)
            ->whereNotNull('commitment')
            ->orderBy('created_at', 'desc')
            ->value('commitment');

        Collection::create([
            'user_id'    => Auth::id(),
            'type'       => 'C3MR',
            'periode'    => $request->periode,
            'commitment' => $lastCommitment,
            'real_ratio' => $request->ratio_aktual,
            'real_updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'C3MR Realisasi berhasil disimpan');
    }

    public function billing(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $currentDate = Carbon::now();

        $hasMonthlyCommitment = Collection::where('user_id', Auth::id())
            ->where('type', 'Billing Perdana')
            ->where('status', 'active')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->exists();

        $bill = Collection::where('type', 'Billing Perdana')
            ->whereYear('periode', $currentDate->year)
            ->whereMonth('periode', $currentDate->month)
            ->where('status', 'active')
            ->whereHas('user', function ($query) {
                $query->where('role', 'admin');
            })
            ->whereNotNull('commitment')
            ->orderBy('updated_at', 'desc')
            ->first();

        $periode = Collection::where('type', 'Billing Perdana')
            ->orderBy('updated_at', 'asc')
            ->whereYear('periode', $currentDate->year)
            ->whereMonth('periode', $currentDate->month)
            ->first();

        $query = Collection::where('type', 'Billing Perdana')
            ->orderBy('updated_at', 'desc');

        if ($request->filled('bulan')) {
            $query->whereMonth('periode', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('periode', $request->tahun);
        }

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('real_ratio', 'like', '%'.$request->cari.'%')
                ->orWhere('commitment', 'like', '%'.$request->cari.'%');
            });
        }

        $activities = $query->paginate(10)->withQueryString();

        $tahuns = Collection::where('type', 'Billing Perdana')
            ->selectRaw('YEAR(periode) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $selectedBulan = $request->bulan;
        $selectedTahun = $request->tahun;
        $selectedCari  = $request->cari;

        return view('dashboard.collection.billing', compact(
            'hasMonthlyCommitment', 'activities', 'bill', 'periode',
            'tahuns', 'selectedBulan', 'selectedTahun', 'selectedCari'
        ));
    }

    public function storeBillingRealisasi(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'ratio_aktual' => 'required|numeric',
        ]);
        $lastCommitment = Collection::where('type', 'Billing Perdana')
            ->where('periode', $request->periode)
            ->whereNotNull('commitment')
            ->orderBy('created_at', 'desc')
            ->value('commitment');

        Collection::create([
            'user_id'    => Auth::id(),
            'type'       => 'Billing Perdana',
            'periode'    => $request->periode,
            'commitment' => $lastCommitment,
            'real_ratio' => $request->ratio_aktual,
            'real_updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Billing Perdana Realisasi berhasil disimpan');
    }

    public function cr(Request $request)
    {
        $query = Collection::where('type', 'Collection Ratio')
            ->orderBy('created_at', 'desc');

        $latestSeg = \App\Models\Collection::where('type', 'Collection Ratio')
                    ->where('status', 'active')
                    ->whereHas('user', function ($query) {
                        $query->where('role', 'admin');
                    })
                    ->whereYear('periode', now()->year)
                    ->whereMonth('periode', now()->month)
                    ->orderBy('created_at', 'desc')
                    ->get();

        if ($request->filled('segment')) {
            $query->where('segment', $request->segment);
        }

        if ($request->filled('bulan')) {
        $query->whereMonth('periode', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('periode', $request->tahun);
        }

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('segment', 'like', '%'.$request->cari.'%')
                ->orWhere('real_ratio', 'like', '%'.$request->cari.'%')
                ->orWhere('commitment', 'like', '%'.$request->cari.'%');
            });
        }

        $collections = $query->paginate(10)->withQueryString();

        $segments = Collection::where('type', 'Collection Ratio')
            ->whereNotNull('segment')
            ->distinct()
            ->orderBy('segment')
            ->pluck('segment');

        $tahuns = Collection::where('type', 'Collection Ratio')
            ->selectRaw('YEAR(periode) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $selectedSegment = $request->segment;
        $selectedBulan   = $request->bulan;
        $selectedTahun   = $request->tahun;
        $selectedCari    = $request->cari;

        return view('dashboard.collection.collectionRatio', compact(
            'collections', 'segments', 'tahuns', 'latestSeg',
            'selectedSegment', 'selectedBulan', 'selectedTahun', 'selectedCari'
        ));
    }

    public function storeCrRealisasi(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'periode'    => 'required|date_format:Y-m',
            'segment'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);
        $periodeDate = $request->periode . '-01';

        $lastCommitment = Collection::where('type', 'Collection Ratio')
            ->where('segment', $request->segment)
            ->where('periode', $periodeDate)
            ->whereNotNull('commitment')
            ->orderBy('created_at', 'desc')
            ->value('commitment');

        Collection::create([
            'user_id'    => Auth::id(),
            'type'       => 'Collection Ratio',
            'segment'    => $request->segment,
            'periode'    => $periodeDate,
            'status'     => $request->status,
            'commitment' => $lastCommitment,
            'real_ratio' => $request->real_ratio,
            'real_updated_at'  => now(),
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function utip(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $hasMonthlyCommitment = Collection::where('user_id', Auth::id())
            ->where('type', 'like', '%UTIP%')
            ->where('status', 'active')
            ->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->exists();

        $utips = Collection::select('id', 'type', 'plan', 'commitment', 'status')
            ->with('user:id,name,role')
            ->where('type', 'like', '%UTIP%')
            ->where('status', 'active')
            ->whereHas('user', function ($query) {
                $query->where('role', 'admin');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('type')
            ->values();

        $query = Collection::where('type', 'like', '%UTIP%')
            ->orderByRaw("CASE WHEN type LIKE '%Corrective%' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');

        if ($request->filled('tipe')) {
            $query->where('type', $request->tipe);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('updated_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('updated_at', $request->tahun);
        }

        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('type', 'like', '%'.$request->cari.'%')
                ->orWhere('real_ratio', 'like', '%'.$request->cari.'%')
                ->orWhere('commitment', 'like', '%'.$request->cari.'%');
            });
        }

        $activities = $query->paginate(10)->withQueryString();

        $tahuns = Collection::where('type', 'like', '%UTIP%')
            ->selectRaw('YEAR(updated_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $tipes = Collection::where('type', 'like', '%UTIP%')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        $selectedTipe  = $request->tipe;
        $selectedBulan = $request->bulan;
        $selectedTahun = $request->tahun;
        $selectedCari  = $request->cari;

        return view('dashboard.collection.utip', compact(
            'hasMonthlyCommitment', 'activities', 'utips',
            'tahuns', 'tipes', 'selectedTipe', 'selectedBulan', 'selectedTahun', 'selectedCari'
        ));
    }

    public function storeUtipRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
            'type' => 'required|string',
        ]);

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $lastCommitment = Collection::where('type', $request->type)
            ->whereNotNull('commitment')
            ->orderBy('created_at', 'desc')
            ->value('commitment');

        $lastPlan = Collection::where('type', $request->type)
            ->whereNotNull('plan')
            ->orderBy('created_at', 'desc')
            ->value('plan');

        $lastCommitment = Collection::where('type', $request->type)
            ->whereNotNull('commitment')
            ->orderBy('created_at', 'desc')
            ->value('commitment');

        $lastPeriode = Collection::where('type', $request->type)
            ->whereNotNull('periode')
            ->orderBy('created_at', 'desc')
            ->value('periode');

        Collection::create([
            'user_id'    => Auth::id(),
            'type'       => $request->type,
            'periode'    => $lastPeriode,
            'plan'       => $lastPlan,
            'commitment' => $lastCommitment,
            'real_ratio' => $request->ratio_aktual,
            'real_updated_at'  => now(),
        ]);

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
