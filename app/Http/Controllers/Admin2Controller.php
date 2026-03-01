<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RisingStar;
use App\Models\RisingStarType;
use App\Models\Hsi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Admin2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    public function risingStar1Table()
    {
        $types = RisingStarType::where('type', '1')->get();
        $rstars = RisingStar::with(['type', 'user'])
        ->mainType(1)
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        // dd($rstars);

        $users = User::all();
        return view('admin.risingstar.risingStar1', compact('rstars', 'types', 'users'));
    }
    
    public function risingStar2Table()
    {
        $types = RisingStarType::where('type', '2')->get();
        $rstars = RisingStar::with(['type', 'user'])
        ->mainType(2)
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        // dd($rstars);

        $users = User::all();
        return view('admin.risingstar.risingStar2', compact('rstars', 'types', 'users'));
    }

    public function risingStar3Table()
    {
        $types = RisingStarType::where('type', '3')->get();
        $rstars = RisingStar::with(['type', 'user'])
        ->mainType(3)
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        // dd($rstars);

        $users = User::all();
        return view('admin.risingstar.risingStar3', compact('rstars', 'types', 'users'));
    }

    public function risingStar4Table()
    {
        $types = RisingStarType::where('type', '4')->get();
        $rstars = RisingStar::with(['type', 'user'])
        ->mainType(4    )
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        // dd($rstars);

        $users = User::all();
        return view('admin.risingstar.risingStar4', compact('rstars', 'types', 'users'));
    }

    public function risingStarStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'type_id'    => 'required|exists:rising_star_types,id',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        RisingStar::create([
            'user_id'    => Auth::id(),          // otomatis user login
            'status'     => $request->status,
            'type_id'    => $request->type_id,
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function hsiTable()
    {
        $currentPeriode = Carbon::now()->format('Y-m') . '-01';
        $existing = Hsi::where('created_at', '>=', $currentPeriode)
            ->where('created_at', '<', Carbon::parse($currentPeriode)->addMonth())
            ->first();
        $hsi = Hsi::with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();
        $users = User::all();
        return view('admin.hsiagency.hsi', compact('existing','hsi', 'users'));
    }

    public function hsiStore(Request $request)
    {
        $request->validate([
            // 'status'     => 'required|in:active,inactive',
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Hsi::create([
            'user_id'    => Auth::id(),          // otomatis user login
            // 'status'     => $request->status,
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
