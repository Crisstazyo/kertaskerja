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
    public function index()
    {
        return view('admin.index');
    }

    // ══════════════════════════════════════════════════════
    // Helper: upsert RisingStar per (user_id, type_id, periode)
    // Kolom yang tidak dikirim tidak ditimpa.
    // ══════════════════════════════════════════════════════
    private function upsertRisingStar(int $typeId, int $userId, array $values, string $periode = null): RisingStar
    {
        $periode = $periode ?? Carbon::now()->format('Y-m-01');

        $record = RisingStar::firstOrNew([
            'user_id' => $userId,
            'type_id' => $typeId,
            'periode' => $periode,
        ]);

        foreach ($values as $col => $val) {
            $record->{$col} = $val;
        }

        if (! $record->exists) {
            $record->status = $values['status'] ?? 'active';
        }

        $record->save();

        return $record;
    }

    // ══ Rising Star Tables ══

    public function risingStar1Table()
    {
        $types  = RisingStarType::where('type', '1')->get();
        $rstars = RisingStar::with(['type', 'user'])
            ->mainType(1)
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        $users = User::all();
        return view('admin.risingstar.risingStar1', compact('rstars', 'types', 'users'));
    }

    public function risingStar2Table()
    {
        $types  = RisingStarType::where('type', '2')->get();
        $rstars = RisingStar::with(['type', 'user'])
            ->mainType(2)
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        $users = User::all();
        return view('admin.risingstar.risingStar2', compact('rstars', 'types', 'users'));
    }

    public function risingStar3Table()
    {
        $types  = RisingStarType::where('type', '3')->get();
        $rstars = RisingStar::with(['type', 'user'])
            ->mainType(3)
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        $users = User::all();
        return view('admin.risingstar.risingStar3', compact('rstars', 'types', 'users'));
    }

    public function risingStar4Table()
    {
        $types  = RisingStarType::where('type', '4')->get();
        $rstars = RisingStar::with(['type', 'user'])
            ->mainType(4)
            ->orderBy('periode', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        $users = User::all();
        return view('admin.risingstar.risingStar4', compact('rstars', 'types', 'users'));
    }

    // ══ Rising Star Store ══
    // Upsert per (user_id, type_id, periode) — tidak buat baris baru jika periode sama.
    public function risingStarStore(Request $request)
    {
        $request->validate([
            'status'     => 'required|in:active,inactive',
            'type_id'    => 'required|exists:rising_star_types,id',
            'periode'    => 'nullable|string',
            'commitment' => 'nullable|numeric|min:0',
            'real_ratio' => 'nullable|numeric|min:0',
            // segment hanya wajib untuk type 4
            'segment'    => 'nullable|in:gov,sme',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        // Tentukan user_id:
        // - Jika ada segment (type 4), mapping ke user fixed
        // - Jika ada user_id di request (type 1/2/3 pakai auth user), pakai itu
        if ($request->filled('segment')) {
            $segmentUserMap = [
                'gov' => 2,
                'sme' => 4,
            ];
            $userId = $segmentUserMap[$request->segment];
        } else {
            $userId = $request->filled('user_id') ? (int) $request->user_id : Auth::id();
        }

        $periode = $request->filled('periode')
            ? Carbon::parse($request->periode . '-01')->format('Y-m-d')
            : Carbon::now()->format('Y-m-01');

        $this->upsertRisingStar(
            typeId:  (int) $request->type_id,
            userId:  $userId,
            values:  [
                'status'     => $request->status,
                'commitment' => $request->commitment,
                'real_ratio' => $request->real_ratio,
            ],
            periode: $periode,
        );

        if ($request->filled('segment')) {
            $segmentLabel = $request->segment === 'gov' ? 'Government' : 'SME';
            return back()->with('success', "Data untuk segment {$segmentLabel} periode " . Carbon::parse($periode)->format('F Y') . " berhasil disimpan / diperbarui.");
        }

        return back()->with('success', "Data Rising Star periode " . Carbon::parse($periode)->format('F Y') . " berhasil disimpan / diperbarui.");
    }

    // ══ HSI ══

    public function hsiTable()
    {
        $currentPeriode = Carbon::now()->format('Y-m') . '-01';
        $existing = Hsi::where('created_at', '>=', $currentPeriode)
            ->where('created_at', '<', Carbon::parse($currentPeriode)->addMonth())
            ->first();

        $hsi   = Hsi::with('user')->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $users = User::all();

        return view('admin.hsiagency.hsi', compact('existing', 'hsi', 'users'));
    }

    public function hsiStore(Request $request)
    {
        $request->validate([
            'commitment' => 'nullable|string',
            'real_ratio' => 'nullable|string',
        ]);

        Hsi::create([
            'user_id'    => Auth::id(),
            'commitment' => $request->commitment,
            'real_ratio' => $request->real_ratio,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    // ══ Telda ══

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

        $currentPeriode    = Carbon::now()->startOfMonth()->toDateString();
        $existingByRegion  = Telda::where('periode', $currentPeriode)->get()->keyBy('region');
        $history           = Telda::orderBy('periode', 'desc')->get();
        $historyByPeriode  = $history->groupBy('periode');
        $users             = User::all();

        return view('admin.telda.telda', compact(
            'teldas', 'existingByRegion', 'history', 'historyByPeriode', 'users'
        ));
    }

    public function teldaStore(Request $request)
    {
        $request->validate([
            'periode'                  => 'required|string',
            'regions'                  => 'required|array',
            'regions.*.region'         => 'required|string',
            'regions.*.commitment'     => 'nullable|numeric|min:0',
            'regions.*.real_ratio'     => 'nullable|numeric|min:0',
        ]);

        $periode = $request->periode . '-01';

        foreach ($request->regions as $data) {
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

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
