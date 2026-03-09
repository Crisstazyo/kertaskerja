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
    private function upsertRisingStar(int $typeId, int $userId, array $values, string $periode = null): RisingStar {

        $periode = $periode ?? Carbon::now()->format('Y-m-01');

        $record = RisingStar::firstOrNew([
            'user_id' => $userId,
            'type_id' => $typeId,
            'periode' => $periode,
        ]);

        // Selalu update user_id
        $record->user_id = $userId;

        // Hanya update kolom yang dikirim
        foreach ($values as $col => $val) {
            if ($val !== null) {   // ⬅️ KUNCI UTAMA DI SINI
                $record->{$col} = $val;
            }
        }

        // Jika record baru dan belum ada status
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
            'segment'    => 'nullable|in:gov,sme',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        // Tentukan user
        if ($request->filled('segment')) {
            $segmentUserMap = [
                'gov' => 2,
                'sme' => 4,
            ];
            $userId = $segmentUserMap[$request->segment] ?? Auth::id();
        } else {
            $userId = $request->filled('user_id')
                ? (int) $request->user_id
                : Auth::id();
        }

        $periode = $request->filled('periode')
            ? Carbon::parse($request->periode . '-01')->format('Y-m-d')
            : Carbon::now()->format('Y-m-01');

        // Bangun values secara dinamis
        $values = [
            'status'     => $request->status,
            'commitment' => $request->commitment,
        ];

        // Hanya masukkan real_ratio jika diinput
        if ($request->filled('real_ratio')) {
            $values['real_ratio'] = $request->real_ratio;
        }

        $this->upsertRisingStar(
            typeId:  (int) $request->type_id,
            userId:  $userId,
            values:  $values,
            periode: $periode,
        );

        return back()->with(
            'success',
            "Data Rising Star periode " .
            Carbon::parse($periode)->format('F Y') .
            " berhasil disimpan / diperbarui."
        );
    }

    // ══ HSI ══

    public function hsiTable(Request $request)
{
    $currentPeriode = Carbon::now()->format('Y-m') . '-01';

    $existing = Hsi::where('type', 'Sales HSI Non AM Non Telda')
        ->where('periode', $currentPeriode)
        ->orderBy('updated_at', 'desc')
        ->first();

    $query = Hsi::with('user')
        ->where('type', 'Sales HSI Non AM Non Telda')
        ->orderBy('periode', 'desc')
        ->orderBy('updated_at', 'desc');

    if ($request->filled('bulan')) {
        $query->whereMonth('periode', $request->bulan);
    }
    if ($request->filled('tahun')) {
        $query->whereYear('periode', $request->tahun);
    }

    $hsi = $query->paginate(10)->withQueryString();

    $tahuns = Hsi::where('type', 'Sales HSI Non AM Non Telda')
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $users         = User::all();
    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;

    return view('admin.hsiagency.hsi', compact(
        'existing', 'hsi', 'users', 'tahuns', 'selectedBulan', 'selectedTahun'
    ));
}

public function hsiStore(Request $request)
{
    $request->validate([
        'type'       => 'required|string',
        'periode'    => 'required|string',
        'commitment' => 'nullable|numeric|min:0',
        'real_ratio' => 'nullable|numeric|min:0',
    ]);

    $periodeDate = $request->periode . '-01';

    $existing = Hsi::where('type', $request->type)
        ->where('periode', $periodeDate)
        ->orderBy('updated_at', 'desc')
        ->first();

    $commitment = $request->filled('commitment')
        ? $request->commitment
        : ($existing->commitment ?? null);

    $realRatio = $request->filled('real_ratio')
        ? $request->real_ratio
        : ($existing->real_ratio ?? null);

    Hsi::create([
        'user_id'    => Auth::id(),
        'type'       => $request->type,
        'periode'    => $periodeDate,
        'commitment' => $commitment,
        'real_ratio' => $realRatio,
    ]);

    return back()->with('success', 'Data HSI periode ' . Carbon::parse($periodeDate)->format('F Y') . ' berhasil disimpan.');
}

    // ══ Telda ══
public function teldaTable(Request $request)
{
    $teldas = [
        'lubukpakam'      => 'Lubuk Pakam',
        'binjai'          => 'Binjai',
        'siantar'         => 'Siantar',
        'kisaran'         => 'Kisaran',
        'kabanjahe'       => 'Kabanjahe',
        'rantauprapat'    => 'Rantau Prapat',
        'toba'            => 'Toba',
        'sibolga'         => 'Sibolga',
        'padangsidempuan' => 'Padang Sidempuan',
    ];

    $selectedPeriode  = $request->get('periode', Carbon::now()->format('Y-m'));
    $periodeDate      = $selectedPeriode . '-01';

    // Untuk form input: ambil record terbaru per region pada periode ini
    $existingByRegion = Telda::where('periode', $periodeDate)
        ->orderBy('updated_at', 'desc')
        ->get()
        ->groupBy('region')
        ->map(fn($rows) => $rows->first());

    // Untuk tabel riwayat: semua baris, dengan filter
    $query = Telda::with('user')->orderBy('created_at', 'desc');

    if ($request->filled('bulan')) {
        $query->whereMonth('periode', $request->bulan);
    }
    if ($request->filled('tahun')) {
        $query->whereYear('periode', $request->tahun);
    }
    if ($request->filled('region')) {
        $query->where('region', $request->region);
    }

    $history = $query->paginate(15)->withQueryString();

    $tahuns = Telda::selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $users           = User::all();
    $selectedBulan   = $request->bulan;
    $selectedTahun   = $request->tahun;
    $selectedRegion  = $request->region;

    return view('admin.telda.telda', compact(
        'teldas', 'existingByRegion', 'history', 'users',
        'tahuns', 'selectedBulan', 'selectedTahun', 'selectedRegion', 'selectedPeriode'
    ));
}

public function teldaStore(Request $request)
{
    $request->validate([
        'periode'              => 'required|string',
        'regions'              => 'required|array',
        'regions.*.region'     => 'required|string',
        'regions.*.commitment' => 'nullable|numeric|min:0',
        'regions.*.real_ratio' => 'nullable|numeric|min:0',
    ]);

    $periode = $request->periode . '-01';

    foreach ($request->regions as $data) {
    $commitmentFilled = isset($data['commitment']) && $data['commitment'] !== '';
    $realFilled       = isset($data['real_ratio']) && $data['real_ratio'] !== '';

    // Skip region yang tidak diisi sama sekali
    if (!$commitmentFilled && !$realFilled) {
        continue;
    }

    $existing = Telda::where('periode', $periode)
        ->where('region', $data['region'])
        ->orderBy('updated_at', 'desc')
        ->first();

    $commitment = $commitmentFilled
        ? $data['commitment']
        : ($existing->commitment ?? null);

    $realRatio = $realFilled
        ? $data['real_ratio']
        : ($existing->real_ratio ?? null);

    Telda::create([
        'user_id'    => Auth::id(),
        'periode'    => $periode,
        'region'     => $data['region'],
        'status'     => $data['status'] ?? 'active',
        'commitment' => $commitment,
        'real_ratio' => $realRatio,
    ]);
}

    return back()->with('success', 'Data Telda periode ' . Carbon::parse($periode)->format('F Y') . ' berhasil disimpan.');
}

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
