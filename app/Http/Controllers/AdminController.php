<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Ctc;
use App\Models\Ct0;
use App\Models\Psak;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    public function collectionRatioTable(Request $request)
{
    $query = Collection::with('user')
        ->where('type', 'Collection Ratio')
        ->orderBy('created_at', 'asc');

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
            $q->where('real_ratio', 'like', '%'.$request->cari.'%')
              ->orWhere('commitment', 'like', '%'.$request->cari.'%')
              ->orWhere('segment', 'like', '%'.$request->cari.'%');
        });
    }

    $collections = $query->paginate(20)->withQueryString();

    $tahuns = Collection::where('type', 'Collection Ratio')
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $segments = Collection::where('type', 'Collection Ratio')
        ->whereNotNull('segment')
        ->distinct()
        ->orderBy('segment')
        ->pluck('segment');

    $users = User::all();
    $selectedSegment = $request->segment;
    $selectedBulan   = $request->bulan;
    $selectedTahun   = $request->tahun;
    $selectedCari    = $request->cari;

    return view('admin.collection.collectionRatio', compact(
        'collections', 'users', 'tahuns', 'segments',
        'selectedSegment', 'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

    public function collectionRatioStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'periode'    => 'required|date_format:Y-m',
            'segment'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);
        $periodeDate = $request->periode . '-01';

        $lastCommitment = $request->filled('commitment')
            ? $request->commitment
            : Collection::where('type', 'Collection Ratio')
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
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function c3mrTable(Request $request)
{
    $query = Collection::with('user')
        ->where('type', 'C3MR')
        ->orderBy('created_at', 'asc');

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

    $collections = $query->paginate(20)->withQueryString();

    $tahuns = Collection::where('type', 'C3MR')
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $users = User::all();
    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;
    $selectedCari  = $request->cari;

    return view('admin.collection.c3mr', compact(
        'collections', 'users', 'tahuns',
        'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

    public function c3mrStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'periode'    => 'required|date_format:Y-m',
            'segment'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);
        $periodeDate = $request->periode . '-01';

        $lastCommitment = $request->filled('commitment')
            ? $request->commitment
            : Collection::where('type', 'C3MR')
                ->where('periode', $periodeDate)
                ->whereNotNull('commitment')
                ->orderBy('created_at', 'desc')
                ->value('commitment');

        Collection::create([
            'user_id'    => Auth::id(),
            'type'       => 'C3MR',
            'segment'    => $request->segment,
            'periode'    => $periodeDate,
            'status'     => $request->status,
            'commitment' => $lastCommitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * Flip active/inactive status for a given collection record.
     */
    public function toggleCollectionStatus($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->status = $collection->status === 'active' ? 'inactive' : 'active';
        $collection->save();

        return back()->with('success', 'Status berhasil diubah');
    }

    public function billingTable(Request $request)
{
    $query = Collection::with('user')
        ->where('type', 'Billing Perdana')
        ->orderBy('created_at', 'asc');

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

    $collections = $query->paginate(20)->withQueryString();

    $tahuns = Collection::where('type', 'Billing Perdana')
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $users = User::all();
    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;
    $selectedCari  = $request->cari;

    return view('admin.collection.billingPerdana', compact(
        'collections', 'users', 'tahuns',
        'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

    public function billingStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'periode'    => 'required|date_format:Y-m',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);
        $periodeDate = $request->periode . '-01';

        $lastCommitment = $request->filled('commitment')
            ? $request->commitment
            : Collection::where('type', 'Billing Perdana')
                ->where('periode', $periodeDate)
                ->whereNotNull('commitment')
                ->orderBy('created_at', 'desc')
                ->value('commitment');

        Collection::create([
            'user_id'    => Auth::id(),
            'type'       => 'Billing Perdana',
            'periode'    => $periodeDate,
            'status'     => $request->status,
            'commitment' => $lastCommitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function utipTable(Request $request)
{
    $query = Collection::with('user')
        ->where('type', 'like', '%UTIP%')
        ->orderByRaw("CASE WHEN type LIKE '%Corrective%' THEN 0 ELSE 1 END")
        ->orderBy('created_at', 'asc');

    if ($request->filled('tipe')) {
        $query->where('type', $request->tipe);
    }
    if ($request->filled('bulan')) {
        $query->whereMonth('created_at', $request->bulan);
    }
    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }
    if ($request->filled('cari')) {
        $query->where(function($q) use ($request) {
            $q->where('type', 'like', '%'.$request->cari.'%')
              ->orWhere('real_ratio', 'like', '%'.$request->cari.'%')
              ->orWhere('commitment', 'like', '%'.$request->cari.'%');
        });
    }

    $collections = $query->paginate(20)->withQueryString();

    $tahuns = Collection::where('type', 'like', '%UTIP%')
        ->selectRaw('YEAR(created_at) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $tipes = Collection::where('type', 'like', '%UTIP%')
        ->distinct()
        ->orderByRaw("CASE WHEN type LIKE '%Corrective%' THEN 0 ELSE 1 END")
        ->orderBy('type')
        ->pluck('type');

    $users = User::all();
    $selectedTipe  = $request->tipe;
    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;
    $selectedCari  = $request->cari;

    return view('admin.collection.utip', compact(
        'collections', 'users', 'tahuns', 'tipes',
        'selectedTipe', 'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

    public function utipStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'periode'    => 'required|date_format:Y-m',
            'type'       => 'required|string',
            'plan'       => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);
        $periodeDate = $request->periode . '-01';

        $lastCommitment = $request->filled('commitment')
            ? $request->commitment
            : Collection::where('type', $request->type)
                ->whereNotNull('commitment')
                ->orderBy('created_at', 'desc')
                ->value('commitment');

        Collection::create([
            'user_id'    => Auth::id(),
            'type'       => $request->type,
            'periode'    => $periodeDate,
            'status'     => $request->status,
            'plan'       => $request->plan,
            'commitment' => $lastCommitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function ctcTable()
    {
        $collections = Ctc::with('user')   // sesuaikan nama model
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        $users = User::all();
        return view('admin.ctc.ctc', compact('collections', 'users'));
    }

    public function ctcStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'segment'    => 'required|string',
            'periode'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        $periode = $request->filled('periode')
            ? Carbon::parse($request->periode . '-01')->format('Y-m-d')
            : Carbon::now()->format('Y-m-01');

        Ctc::updateOrCreate(   // sesuaikan nama model
            [
                'user_id' => Auth::id(),
                'segment' => $request->segment,
                'periode' => $periode,
            ],
            [
                'status'     => $request->status,
                'commitment' => $request->commitment,
                'real_ratio' => $request->real_ratio,
            ]
        );

        return back()->with('success', 'Data CTC periode ' . Carbon::parse($periode)->format('F Y') . ' berhasil disimpan / diperbarui.');
    }

    public function ct0Table()
    {
        $collections = Ct0::with('user')
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        $users = User::all();
        return view('admin.ctc.ct0', compact('collections', 'users'));
    }

    public function ct0Store(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'region'     => 'required|string',
            'periode'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        $periode = $request->filled('periode')
            ? Carbon::parse($request->periode . '-01')->format('Y-m-d')
            : Carbon::now()->format('Y-m-01');

        Ct0::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'region'  => $request->region,
                'periode' => $periode,
            ],
            [
                'status'     => $request->status,
                'commitment' => $request->commitment,
                'real_ratio' => $request->real_ratio,
            ]
        );

        return back()->with('success', 'Data CT0 periode ' . Carbon::parse($periode)->format('F Y') . ' berhasil disimpan / diperbarui.');
    }

        public function psakGov(Request $request)
    {
        $query = Psak::with('user')
            ->where('type', 'Government');

        if ($request->filled('filter_month')) {
            $query->whereMonth('periode', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('periode', $request->filter_year);
        }
           if ($request->filled('segmen')) {
            $query->where('segment', $request->segmen);
        }

        $govs = $query
            ->orderBy('periode', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.gov', compact('govs', 'users'));
    }

    public function psakGovStore(Request $request)
    {
        $request->validate([
            'periode'  => 'required|string',
            'segment'  => 'required|string',
            'comm_ssl' => 'nullable|numeric',
            'comm_rp'  => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'real_rp'  => 'nullable|numeric',
        ]);

           $periode = $request->periode . '-01';

        $psak = Psak::firstOrNew([
            'user_id' => Auth::id(),
            'type'    => 'Government',
            'segment' => $request->segment,
            'periode' => $periode,
        ]);

        if ($request->filled('comm_ssl')) $psak->comm_ssl = $request->comm_ssl;
        if ($request->filled('comm_rp'))  $psak->comm_rp  = $request->comm_rp;
        if ($request->filled('real_ssl')) $psak->real_ssl = $request->real_ssl;
        if ($request->filled('real_rp'))  $psak->real_rp  = $request->real_rp;

        $psak->save();

        return back()->with('success', 'Data PSAK Government berhasil disimpan.');
    }

    public function psakPrivate(Request $request)
    {
        $query = Psak::with('user')
            ->where('type', 'Private');

        if ($request->filled('filter_month')) {
            $query->whereMonth('periode', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('periode', $request->filter_year);
        }
           if ($request->filled('segmen')) {
            $query->where('segment', $request->segmen);
        }

        $pvts = $query
            ->orderBy('periode', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.private', compact('pvts', 'users'));
    }

    public function psakPrivateStore(Request $request)
    {
        $request->validate([
            'periode'  => 'required|string',
            'segment'  => 'required|string',
            'comm_ssl' => 'nullable|numeric',
            'comm_rp'  => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'real_rp'  => 'nullable|numeric',
        ]);

           $periode = $request->periode . '-01';

        $psak = Psak::firstOrNew([
            'user_id' => Auth::id(),
            'type'    => 'Private',
            'segment' => $request->segment,
            'periode' => $periode,
        ]);

        if ($request->filled('comm_ssl')) $psak->comm_ssl = $request->comm_ssl;
        if ($request->filled('comm_rp'))  $psak->comm_rp  = $request->comm_rp;
        if ($request->filled('real_ssl')) $psak->real_ssl = $request->real_ssl;
        if ($request->filled('real_rp'))  $psak->real_rp  = $request->real_rp;

        $psak->save();

        return back()->with('success', 'Data PSAK Private berhasil disimpan.');
    }

    public function psakSoe(Request $request)
    {
        $query = Psak::with('user')
            ->where('type', 'SOE');

        if ($request->filled('filter_month')) {
            $query->whereMonth('periode', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('periode', $request->filter_year);
        }
           if ($request->filled('segmen')) {
            $query->where('segment', $request->segmen);
        }

        $soes = $query
            ->orderBy('periode', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.soe', compact('soes', 'users'));
    }

    public function psakSoeStore(Request $request)
    {
        $request->validate([
            'periode'  => 'required|string',
            'segment'  => 'required|string',
            'comm_ssl' => 'nullable|numeric',
            'comm_rp'  => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'real_rp'  => 'nullable|numeric',
        ]);

           $periode = $request->periode . '-01';

        $psak = Psak::firstOrNew([
            'user_id' => Auth::id(),
            'type'    => 'SOE',
            'segment' => $request->segment,
            'periode' => $periode,
        ]);

        if ($request->filled('comm_ssl')) $psak->comm_ssl = $request->comm_ssl;
        if ($request->filled('comm_rp'))  $psak->comm_rp  = $request->comm_rp;
        if ($request->filled('real_ssl')) $psak->real_ssl = $request->real_ssl;
        if ($request->filled('real_rp'))  $psak->real_rp  = $request->real_rp;

        $psak->save();

        return back()->with('success', 'Data PSAK SOE berhasil disimpan.');
    }

        public function psakSme(Request $request)
    {
        $query = Psak::with('user')
            ->where('type', 'SME');

        if ($request->filled('filter_month')) {
            $query->whereMonth('periode', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('periode', $request->filter_year);
        }
           if ($request->filled('segmen')) {
            $query->where('segment', $request->segmen);
        }

        $smes = $query
            ->orderBy('periode', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.sme', compact('smes', 'users'));
    }

    public function psakSmeStore(Request $request)
    {
        $request->validate([
            'periode'  => 'required|string',
            'segment'  => 'required|string',
            'comm_ssl' => 'nullable|numeric',
            'comm_rp'  => 'nullable|numeric',
            'real_ssl' => 'nullable|numeric',
            'real_rp'  => 'nullable|numeric',
        ]);

           $periode = $request->periode . '-01';

        $psak = Psak::firstOrNew([
            'user_id' => Auth::id(),
            'type'    => 'SME',
            'segment' => $request->segment,
            'periode' => $periode,
        ]);

        if ($request->filled('comm_ssl')) $psak->comm_ssl = $request->comm_ssl;
        if ($request->filled('comm_rp'))  $psak->comm_rp  = $request->comm_rp;
        if ($request->filled('real_ssl')) $psak->real_ssl = $request->real_ssl;
        if ($request->filled('real_rp'))  $psak->real_rp  = $request->real_rp;

        $psak->save();

        return back()->with('success', 'Data PSAK SME berhasil disimpan.');
    }

    public function risingStar1Table()
    {
        $collections = Ctc::with('user')
        // ->where('type', 'like', '%UTIP%')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.ctc.ctc', compact('collections', 'users'));
    }

    public function risingStar1Store(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'segment'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Ctc::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'status'     => $request->status,
            'segment'    => $request->segment,
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
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
