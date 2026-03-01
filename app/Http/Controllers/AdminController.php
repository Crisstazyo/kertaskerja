<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Ctc;
use App\Models\Ct0;
use App\Models\Psak;
use App\Models\User;
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

    public function collectionRatioTable()
    {
        $collections = Collection::with('user')
        ->where('type', 'Collection Ratio')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.collection.collectionRatio', compact('collections', 'users'));
    }

    public function collectionRatioStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'segment'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Collection::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'type'       => 'Collection Ratio',              // dipaksa dari backend
            'status'     => $request->status,
            'segment'    => $request->segment,
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function c3mrTable()
    {
        $collections = Collection::with('user')
        ->where('type', 'C3MR')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.collection.c3mr', compact('collections', 'users'));
    }

    public function c3mrStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'segment'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Collection::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'type'       => 'C3MR',              // dipaksa dari backend
            'status'     => $request->status,
            'segment'    => $request->segment,
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function billingTable()
    {
        $collections = Collection::with('user')
        ->where('type', 'Billing Perdana')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.collection.billingPerdana', compact('collections', 'users'));
    }

    public function billingStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'segment'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Collection::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'type'       => 'Billing Perdana',              // dipaksa dari backend
            'status'     => $request->status,
            'segment'    => $request->segment,
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function utipTable()
    {
        $collections = Collection::with('user')
        ->where('type', 'like', '%UTIP%')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.collection.utip', compact('collections', 'users'));
    }

    public function utipStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'type'    => 'nullable|string',
            'segment'    => 'nullable|string',
            'plan'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Collection::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'status'     => $request->status,
            'type'       => $request->type,              
            'segment'    => $request->segment,
            'plan'       => $request->plan,
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function ctcTable()
    {
        $collections = Ctc::with('user')
        // ->where('type', 'like', '%UTIP%')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.ctc.ctc', compact('collections', 'users'));
    }

    public function ctcStore(Request $request)
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

    public function ct0Table()
    {
        $collections = Ct0::with('user')
        // ->where('type', 'like', '%UTIP%')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.ctc.ct0', compact('collections', 'users'));
    }

    public function ct0Store(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'region'    => 'nullable|string',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Ct0::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'status'     => $request->status,
            'region'    => $request->region,
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function psakGov(Request $request)
    {
        // build query and optionally filter by month/year of created_at
        $query = Psak::with('user')
            ->where('type', 'Government');

        // filter parameters are expected as numeric values (1-12 for month, 4‑digit year)
        if ($request->filled('filter_month')) {
            $query->whereMonth('created_at', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('created_at', $request->filter_year);
        }

        // allow server‐side segment filtering (code values)
        if ($request->filled('segmen')) {
            $query->where('segment', $request->segmen);
        }

        // also select the month name and year if you want to use them in the view
        $govs = $query
            ->selectRaw("psaks.*, MONTHNAME(created_at) as month_name, YEAR(created_at) as year")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.gov', compact('govs', 'users'));
    }

    public function psakGovStore(Request $request)
    {
        $request->validate([
            'segment'    => 'nullable|string',
            'comm_ssl' => 'nullable|string',
            'comm_rp' => 'nullable|string',
            'real_ssl' => 'nullable|string',
            'real_rp' => 'nullable|string',
        ]);

        Psak::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'type'       => 'Government',              // dipaksa dari backend
            'segment'    => $request->segment,
            'comm_ssl' => $request->comm_ssl,
            'comm_rp' => $request->comm_rp,
            'real_ssl' => $request->real_ssl,
            'real_rp' => $request->real_rp,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function psakPrivate(Request $request)
    {
        // build query and optionally filter by month/year of created_at
        $query = Psak::with('user')
            ->where('type', 'Private');

        // filter parameters are expected as numeric values (1-12 for month, 4‑digit year)
        if ($request->filled('filter_month')) {
            $query->whereMonth('created_at', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('created_at', $request->filter_year);
        }

        // also select the month name and year if you want to use them in the view
        $pvts = $query
            ->selectRaw("psaks.*, MONTHNAME(created_at) as month_name, YEAR(created_at) as year")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.private', compact('pvts', 'users'));
    }

    public function psakPrivateStore(Request $request)
    {
        $request->validate([
            'segment'    => 'nullable|string',
            'comm_ssl' => 'nullable|string',
            'comm_rp' => 'nullable|string',
            'real_ssl' => 'nullable|string',
            'real_rp' => 'nullable|string',
        ]);

        Psak::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'type'       => 'Private',              // dipaksa dari backend
            'segment'    => $request->segment,
            'comm_ssl' => $request->comm_ssl,
            'comm_rp' => $request->comm_rp,
            'real_ssl' => $request->real_ssl,
            'real_rp' => $request->real_rp,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function psakSme(Request $request)
    {
        // build query and optionally filter by month/year of created_at
        $query = Psak::with('user')
            ->where('type', 'SME');

        // filter parameters are expected as numeric values (1-12 for month, 4‑digit year)
        if ($request->filled('filter_month')) {
            $query->whereMonth('created_at', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('created_at', $request->filter_year);
        }

        // also select the month name and year if you want to use them in the view
        $smes = $query
            ->selectRaw("psaks.*, MONTHNAME(created_at) as month_name, YEAR(created_at) as year")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.sme', compact('smes', 'users'));
    }

    public function psakSmeStore(Request $request)
    {
        $request->validate([
            'segment'    => 'nullable|string',
            'comm_ssl' => 'nullable|string',
            'comm_rp' => 'nullable|string',
            'real_ssl' => 'nullable|string',
            'real_rp' => 'nullable|string',
        ]);

        Psak::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'type'       => 'SME',              // dipaksa dari backend
            'segment'    => $request->segment,
            'comm_ssl' => $request->comm_ssl,
            'comm_rp' => $request->comm_rp,
            'real_ssl' => $request->real_ssl,
            'real_rp' => $request->real_rp,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function psakSoe(Request $request)
    {
        // build query and optionally filter by month/year of created_at
        $query = Psak::with('user')
            ->where('type', 'SOE');

        // filter parameters are expected as numeric values (1-12 for month, 4‑digit year)
        if ($request->filled('filter_month')) {
            $query->whereMonth('created_at', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('created_at', $request->filter_year);
        }

        // also select the month name and year if you want to use them in the view
        $soes = $query
            ->selectRaw("psaks.*, MONTHNAME(created_at) as month_name, YEAR(created_at) as year")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::all();
        return view('admin.psak.soe', compact('soes', 'users'));
    }

    public function psakSoeStore(Request $request)
    {
        $request->validate([
            'segment'    => 'nullable|string',
            'comm_ssl' => 'nullable|string',
            'comm_rp' => 'nullable|string',
            'real_ssl' => 'nullable|string',
            'real_rp' => 'nullable|string',
        ]);

        Psak::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'type'       => 'SOE',              // dipaksa dari backend
            'segment'    => $request->segment,
            'comm_ssl' => $request->comm_ssl,
            'comm_rp' => $request->comm_rp,
            'real_ssl' => $request->real_ssl,
            'real_rp' => $request->real_rp,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
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
