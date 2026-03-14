<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    $comm = Collection::where('type', 'C3MR')
        ->whereYear('periode', $currentDate->year)
        ->whereMonth('periode', $currentDate->month)
        ->where('is_latest', true)
        ->whereNotNull('commitment')
        ->first();
        // dd($comm);

    $periode = Collection::where('type', 'C3MR')
        ->orderBy('updated_at', 'asc')
        ->whereYear('periode', $currentDate->year)
        ->whereMonth('periode', $currentDate->month)
        ->first();

    $query = Collection::where('type', 'C3MR')
        ->orderBy('created_at', 'desc');
        // dd($query->get());

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
         'activities', 'comm', 'periode',
        'tahuns', 'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

    public function storeC3mrRealisasi(Request $request)
{
    $request->validate([
        'periode'      => 'required|string',
        'ratio_aktual' => 'required|numeric',
    ]);

    $lastCommitment = Collection::where('type', 'C3MR')
        ->where('periode', $request->periode)
        ->where('is_latest', true)   // ← ambil dari is_latest, bukan orderBy
        ->value('commitment');

    DB::transaction(function () use ($request, $lastCommitment) {
        // Set semua record periode ini is_latest = false
        Collection::where('type', 'C3MR')
            ->where('periode', $request->periode)
            ->update(['is_latest' => false]);

        Collection::create([
            'user_id'         => Auth::id(),
            'type'            => 'C3MR',
            'periode'         => $request->periode,
            'is_latest'       => true,
            'commitment'      => $lastCommitment,
            'real_ratio'      => $request->ratio_aktual,
            'real_updated_at' => now(),
        ]);
    });

    return redirect()->back()->with('success', 'C3MR Realisasi berhasil disimpan');
}

    public function billing(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $currentDate = Carbon::now();

        $bill = Collection::where('type', 'Billing Perdana')
            ->whereYear('periode', $currentDate->year)
            ->whereMonth('periode', $currentDate->month)
            ->where('is_latest', true)
            ->whereNotNull('commitment')
            ->first();
        // dd($bill);

        $periode = Collection::where('type', 'Billing Perdana')
            ->orderBy('updated_at', 'asc')
            ->whereYear('periode', $currentDate->year)
            ->whereMonth('periode', $currentDate->month)
            ->first();

        $query = Collection::where('type', 'Billing Perdana')
            ->orderBy('created_at', 'desc');

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
             'activities', 'bill', 'periode',
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
            ->where('is_latest', true)
            ->value('commitment');

        DB::transaction(function () use ($request, $lastCommitment) {
            // Set semua record periode ini is_latest = false
            Collection::where('type', 'Billing Perdana')
                ->where('periode', $request->periode)
                ->update(['is_latest' => false]);

            Collection::create([
                'user_id'         => Auth::id(),
                'type'            => 'Billing Perdana',
                'periode'         => $request->periode,
                'is_latest'       => true,
                'commitment'      => $lastCommitment,
                'real_ratio'      => $request->ratio_aktual,
                'real_updated_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Billing Perdana Realisasi berhasil disimpan');
    }

    public function cr(Request $request)
    {
        $query = Collection::where('type', 'Collection Ratio')
            ->orderBy('created_at', 'desc');

        // ← Ganti filter role admin + orderBy ke is_latest, scope per segment
        $latestSeg = Collection::where('type', 'Collection Ratio')
            ->where('is_latest', true)
            ->whereYear('periode', now()->year)
            ->whereMonth('periode', now()->month)
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
            ->whereNotNull('segment')->distinct()->orderBy('segment')->pluck('segment');

        $tahuns = Collection::where('type', 'Collection Ratio')
            ->selectRaw('YEAR(periode) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

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
            'segment'    => 'required|string',
            'real_ratio' => 'nullable|string',
        ]);

        $periodeDate = $request->periode . '-01';

        // ← Ambil commitment dari is_latest, scope per segment
        $lastCommitment = Collection::where('type', 'Collection Ratio')
            ->where('segment', $request->segment)
            ->where('periode', $periodeDate)
            ->where('is_latest', true)
            ->value('commitment');

        DB::transaction(function () use ($request, $periodeDate, $lastCommitment) {
            Collection::where('type', 'Collection Ratio')
                ->where('segment', $request->segment)
                ->where('periode', $periodeDate)
                ->update(['is_latest' => false]);

            Collection::create([
                'user_id'         => Auth::id(),
                'type'            => 'Collection Ratio',
                'segment'         => $request->segment,
                'periode'         => $periodeDate,
                'status'          => $request->status,
                'is_latest'       => true,
                'commitment'      => $lastCommitment,
                'real_ratio'      => $request->real_ratio,
                'real_updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function utip(Request $request)
    {
        $currentDate = Carbon::now();

        // ← Tambahkan filter whereYear + whereMonth periode
        $utips = Collection::where('type', 'like', '%UTIP%')
            ->where('is_latest', true)
            ->where('status', 'active')
            ->whereYear('periode', $currentDate->year)
            ->whereMonth('periode', $currentDate->month)
            ->orderByRaw("CASE WHEN type LIKE '%Corrective%' THEN 0 ELSE 1 END")
            ->orderBy('type')
            ->get();

        $query = Collection::where('type', 'like', '%UTIP%')
            ->orderByRaw("CASE WHEN type LIKE '%Corrective%' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');

        if ($request->filled('tipe'))  $query->where('type', $request->tipe);
        if ($request->filled('bulan')) $query->whereMonth('periode', $request->bulan); // ← fix: periode
        if ($request->filled('tahun')) $query->whereYear('periode', $request->tahun);  // ← fix: periode
        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('type', 'like', '%'.$request->cari.'%')
                ->orWhere('real_ratio', 'like', '%'.$request->cari.'%')
                ->orWhere('commitment', 'like', '%'.$request->cari.'%');
            });
        }

        $activities = $query->paginate(10)->withQueryString();

        // ← fix: tahun dari periode
        $tahuns = Collection::where('type', 'like', '%UTIP%')
            ->selectRaw('YEAR(periode) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        $tipes = Collection::where('type', 'like', '%UTIP%')
            ->distinct()->orderBy('type')->pluck('type');

        $selectedTipe  = $request->tipe;
        $selectedBulan = $request->bulan;
        $selectedTahun = $request->tahun;
        $selectedCari  = $request->cari;

        // ← hapus $hasMonthlyCommitment dari compact
        return view('dashboard.collection.utip', compact(
            'activities', 'utips',
            'tahuns', 'tipes', 'selectedTipe', 'selectedBulan', 'selectedTahun', 'selectedCari'
        ));
    }

    public function storeUtipRealisasi(Request $request)
    {
        $request->validate([
            'ratio_aktual' => 'required|numeric',
            'type'         => 'required|string',
        ]);

        // ← Ambil semua dari is_latest, scope per type
        $latest = Collection::where('type', $request->type)
            ->where('is_latest', true)
            ->first();

        // Tolak jika tipe belum punya data is_latest (belum di-setup admin)
        abort_if(!$latest, 422, 'Tipe UTIP ini belum memiliki data aktif.');

        DB::transaction(function () use ($request, $latest) {
            Collection::where('type', $request->type)
                ->where('periode', $latest->periode)
                ->update(['is_latest' => false]);

            Collection::create([
                'user_id'         => Auth::id(),
                'type'            => $request->type,
                'periode'         => $latest->periode,
                'is_latest'       => true,
                'plan'            => $latest->plan,
                'commitment'      => $latest->commitment,
                'real_ratio'      => $request->ratio_aktual,
                'real_updated_at' => now(),
            ]);
        });

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
