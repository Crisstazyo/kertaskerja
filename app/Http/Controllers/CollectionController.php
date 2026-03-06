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

    public function c3mr()
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
            
        $activities = Collection::where('type', 'C3MR')
            ->whereMonth('periode', $currentMonth)
            ->whereYear('periode', $currentYear)
            ->orderBy('updated_at', 'desc')
            ->get();

        $comm = Collection::where('type', 'C3MR')
            ->orderBy('updated_at', 'asc')
            ->get();
        
        $periode = Collection::where('type', 'C3MR')
            ->orderBy('updated_at', 'asc')
            ->whereYear('periode', $currentDate->year)
            ->whereMonth('periode', $currentDate->month)
            ->first();
        // dd($comm);
            
        return view('dashboard.collection.c3mr', compact('hasMonthlyCommitment', 'activities', 'comm', 'periode'));
    }

    public function storeC3mrRealisasi(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'ratio_aktual' => 'required|numeric',
        ]);
        $log = Collection::where('periode', $request->periode)->where('type', 'C3MR')->where('segment', $request->segment)->first();

        if($log) {
            $log->update([
                'real_ratio' => $request->ratio_aktual,
            ]);
        } else {
             Collection::create([
                'user_id' => Auth::id(),
                'type' => 'C3MR',
                'periode' => $request->periode,
                'real_ratio' => $request->ratio_aktual,
            ]);
        }

        // Collection::create([
        //     'user_id' => Auth::id(),
        //     'type' => 'C3MR',
        //     'real_ratio' => $request->ratio_aktual,

        // ]);
        
        return redirect()->back()->with('success', 'C3MR Realisasi berhasil disimpan');
    }

    public function billing()
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
            
        $activities = Collection::where('type', 'Billing Perdana')
            ->whereMonth('periode', $currentMonth)
            ->whereYear('periode', $currentYear)
            ->orderBy('updated_at', 'desc')
            ->get();
            // dd($activities);

        $bill = Collection::where('type', 'Billing Perdana')
            ->orderBy('updated_at', 'asc')
            ->get();

        $periode = Collection::where('type', 'Billing Perdana')
            ->orderBy('updated_at', 'asc')
            ->whereYear('periode', $currentDate->year)
            ->whereMonth('periode', $currentDate->month)
            ->first();
        // dd($periode);
            
        return view('dashboard.collection.billing', compact('hasMonthlyCommitment', 'activities', 'bill', 'periode'));
    }

    public function storeBillingRealisasi(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
            'ratio_aktual' => 'required|numeric',
        ]);
        $log = Collection::where('periode', $request->periode)->where('type', 'Billing Perdana')->where('segment', $request->segment)->first();

        if($log) {
            $log->update([
                'real_ratio' => $request->ratio_aktual,
            ]);
        } else {
             Collection::create([
                'user_id' => Auth::id(),
                'type' => 'Billing Perdana',
                'periode' => $request->periode,
                'real_ratio' => $request->ratio_aktual,
            ]);
        }

        // Collection::create([
        //     'user_id' => Auth::id(),
        //     'type' => 'Billing Perdana',
        //     'real_ratio' => $request->ratio_aktual,

        // ]);
        
        return redirect()->back()->with('success', 'Billing Perdana Realisasi berhasil disimpan');
    }

    public function cr()
    {
        $collections = Collection::with('user')
        ->where('type', 'Collection Ratio')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        // collect all distinct periode values for Billing Perdana entries
        $periodes = Collection::where('type', 'Collection Ratio')
        ->selectRaw("DATE_FORMAT(periode, '%Y-%m') as periode")
        ->distinct()
        ->orderBy('periode', 'desc')
        ->pluck('periode')
        ->map(function ($item) {
            return Carbon::createFromFormat('Y-m', $item)
                ->locale('id')
                ->translatedFormat('F Y');
        });
            
        return view('dashboard.collection.collectionRatio', compact('collections', 'users', 'periodes'));
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

        // cek/update berdasarkan kombinasi type+segment+periode
        $attributes = [
            'type'    => 'Collection Ratio',
            'segment' => $request->segment,
            'periode' => $periodeDate,
        ];

        $values = [
            'user_id'    => Auth::id(),          // otomatis user login
            'status'     => $request->status,
            // 'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ];

        $collection = Collection::updateOrCreate($attributes, $values);
        $message = $collection->wasRecentlyCreated
            ? 'Data berhasil disimpan'
            : 'Data berhasil diperbarui';

        return back()->with('success', $message);
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
        $existing = Collection::where('type', $request->type)
            // ->where('periode', $request->periode)
            ->first();

        $data = [
            'user_id' => Auth::id(),
            'type' => $request->type,
            'perioede' => $request->periode,
            'plan' => $existing->plan ?? 0,
            'commitment' => $request->commitment ?? 0,
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
