<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RisingStar;
use App\Models\RisingStarType;
use App\Models\Hsi;
use App\Models\User;
use App\Models\Telda;
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

    public function teldaTable()
    {
        $teldas = [
            'medan'           => 'Medan',
            'binjai'          => 'Binjai',
            'deliserdang'     => 'Deli Serdang',
            'simalungun'      => 'Simalungun',
            'pematangsiantar' => 'Pematang Siantar',
            'tebingtinggi'    => 'Tebing Tinggi',
            'asahan'          => 'Asahan',
            'labuhanbatu'     => 'Labuhan Batu',
            'tapanuli'        => 'Tapanuli',
        ];

        $currentPeriode = Carbon::now()->startOfMonth()->toDateString();

        // Ambil semua record periode ini, index by region
        $existingByRegion = Telda::where('periode', $currentPeriode)
            ->get()
            ->keyBy('region');

        // Semua riwayat, di-group by periode lalu by region
        $history = Telda::orderBy('periode', 'desc')->get();

        $historyByPeriode = $history->groupBy('periode');

        $users = User::all();

        return view('admin.telda.telda', compact(
            'teldas',
            'existingByRegion',
            'history',
            'historyByPeriode',
            'users'
        ));
    }

    public function teldaStore(Request $request)
    {
        $request->validate([
            'periode'          => 'required|string',
            'regions'          => 'required|array',
            'regions.*.region'     => 'required|string',
            'regions.*.commitment' => 'nullable|numeric|min:0',
            'regions.*.real_ratio' => 'nullable|numeric|min:0',
        ]);

        $periode = $request->periode . '-01';

        foreach ($request->regions as $regionKey => $data) {
            Telda::updateOrCreate(
                [
                    'periode' => $periode,
                    'region'  => $data['region'],
                ],
                [
                    'user_id'    => Auth::id(),
                    'status'     => $data['status'] ?? 'active',
                    'commitment' => $data['commitment'] ?? null,
                    'real_ratio' => $data['real_ratio'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Data Telda berhasil disimpan');
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
