<?php

namespace App\Http\Controllers;
use App\Models\ScallingImport;
use App\Models\ScallingData;
use App\Models\RisingStar;
use App\Models\Hsi;

use Illuminate\Http\Request;

class SmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function lopOnHand()
    {
        // gunakan parameter periode (format YYYY-MM) daripada month/year terpisah
        $currentPeriode = request()->get('periode', date('Y-m'));
        // kolom periode di database disimpan sebagai DATE (YYYY-MM-01), jadi tambahkan '-01'
        $currentPeriodeDate = $currentPeriode . '-01';

        // produce list of available periods (YYYY-MM) from past imports
        $periodOptions = ScallingImport::where('type', 'on-hand')
            ->where('segment', 'sme')
            ->orderBy('periode', 'desc')
            ->get()
            ->pluck('periode')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
            ->unique()
            ->values();
            // dd($periodOptions);

        $latestImport = ScallingImport::with(['data.funnel.todayProgress'])
            ->where('type', 'on-hand')
            ->where('segment', 'sme')
            ->where('periode', $currentPeriodeDate)
            ->latest()
            ->first();
            // dd($latestImport);

        // Get admin note

        return view('dashboard.sme.lop-on-hand', compact('latestImport', 'currentPeriode', 'periodOptions'));
    }

    public function lopKoreksi()
    {
        // gunakan parameter periode (format YYYY-MM) daripada month/year terpisah
        $currentPeriode = request()->get('periode', date('Y-m'));
        // kolom periode di database disimpan sebagai DATE (YYYY-MM-01), jadi tambahkan '-01'
        $currentPeriodeDate = $currentPeriode . '-01';

        // produce list of available periods (YYYY-MM) from past imports
        $periodOptions = ScallingImport::where('type', 'koreksi')
            ->where('segment', 'sme')
            ->orderBy('periode', 'desc')
            ->get()
            ->pluck('periode')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
            ->unique()
            ->values();

        $latestImport = ScallingImport::with(['data.funnel.todayProgress'])
            ->where('type', 'koreksi')
            ->where('segment', 'sme')
            ->where('periode', $currentPeriodeDate)
            ->latest()
            ->first();

        $rows = $latestImport
        ? \App\Models\Koreksi::where('imports_log_id', $latestImport->id)->get()
        : collect();

        return view('dashboard.sme.lop-koreksi', compact('latestImport', 'rows', 'currentPeriode', 'periodOptions'));
    }

    public function updateRealisasiKoreksi(Request $request)
    {
        $request->validate([
            'id'        => 'required|integer|exists:koreksis,id',
            'realisasi' => 'required|numeric|min:0',
        ]);

        $koreksi = \App\Models\Koreksi::findOrFail($request->id);
        $koreksi->update(['realisasi' => $request->realisasi]);

        return response()->json(['success' => true]);
    }

    public function lopQualified()
    {
        // gunakan parameter periode (format YYYY-MM) daripada month/year terpisah
        $currentPeriode = request()->get('periode', date('Y-m'));
        // kolom periode di database disimpan sebagai DATE (YYYY-MM-01), jadi tambahkan '-01'
        $currentPeriodeDate = $currentPeriode . '-01';

        // produce list of available periods (YYYY-MM) from past imports
        $periodOptions = ScallingImport::where('type', 'qualified')
            ->where('segment', 'sme')
            ->orderBy('periode', 'desc')
            ->get()
            ->pluck('periode')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
            ->unique()
            ->values();

        $latestImport = ScallingImport::with(['data.funnel.todayProgress'])
            ->where('type', 'qualified')
            ->where('segment', 'sme')
            ->where('periode', $currentPeriodeDate)
            ->latest()
            ->first();

        // Get admin note

        return view('dashboard.sme.lop-qualified', compact('latestImport', 'currentPeriode', 'periodOptions'));
    }
    public function lopInitiate()
    {
        $currentPeriode = request()->get('periode', date('Y-m'));
        $currentPeriodeDate = $currentPeriode . '-01';

        $periodOptions = ScallingImport::where('type', 'initiate')
            ->where('segment', 'sme')
            ->orderBy('periode', 'desc')
            ->get()
            ->pluck('periode')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m'))
            ->unique()
            ->values();

        $rows = ScallingData::with(['funnel.todayProgress'])
            ->whereHas('scallingImport', function ($query) use ($currentPeriodeDate) {
                $query->where('type', 'initiate')
                    // ->where('status', 'active')
                    ->where('segment', 'sme')
                    ->where('periode', $currentPeriodeDate);
            })
            ->get()
            ->filter(fn($item) => strtoupper(trim($item->no ?? '')) !== 'TOTAL');

        $latestImport = ScallingImport::with(['data.funnel.todayProgress'])
            ->where('type', 'initiate')
            ->where('segment', 'sme')
            ->where('periode', $currentPeriodeDate)
            ->latest()
            ->first();

        // Hitung total langsung dari $rows yang sudah difilter
        $totalEstNilai = $rows->sum(fn($item) => floatval($item->est_nilai_bc ?? 0));

        $totalBillComp = $rows->sum(function ($item) {
            $funnel        = $item->first()->funnel;
            $master        = $funnel;
            $todayProgress = $funnel?->todayProgress;

            $masterChecked = $master && $master->delivery_billing_complete;
            $todayChecked  = $todayProgress && $todayProgress->delivery_billing_complete;

            if ($todayChecked || $masterChecked) {
                $nilai = $todayProgress->delivery_nilai_billcomp
                    ?? ($masterChecked ? $master->delivery_nilai_billcomp : null);

                if (!$nilai) {
                    $cleanValue = str_replace(['.', ','], '', $item->est_nilai_bc ?? '0');
                    $nilai = (float) $cleanValue;
                }
                return (float) $nilai;
            }
            return 0;
        });

        return view('dashboard.sme.lop-initiate', compact(
            'latestImport', 'currentPeriode', 'periodOptions', 'rows', 'totalEstNilai', 'totalBillComp'
        ));
    }

    public function storeData(Request $request)
    {
        $request->validate([
            'status'                   => 'required|in:active,inactive',
            'periode'                  => 'required|date_format:Y-m',
            'project'                  => 'required|string|max:255',
            'id_lop'                   => 'required|string|max:100',
            'cc'                       => 'required|string|max:100',
            'nipnas'                   => 'required|string|max:50',
            'am'                       => 'required|string|max:100',
            'mitra'                    => 'nullable|string|max:255',
            'plan_bulan_billcomp_2025' => 'required|integer|min:1|max:12',
            'est_nilai_bc'             => 'required|numeric|min:0',
        ], [
            'status.required'                   => 'Status wajib diisi',
            'status.in'                         => 'Status harus berupa "active" atau "inactive"',
            'periode.required'                  => 'Periode wajib diisi',
            'periode.date_format'               => 'Format periode harus berupa bulan dan tahun (contoh: 2025-03)',
            'project.required'                  => 'Nama project wajib diisi',
            'project.max'                       => 'Nama project maksimal 255 karakter',
            'id_lop.required'                   => 'ID LOP wajib diisi',
            'id_lop.max'                        => 'ID LOP maksimal 100 karakter',
            'cc.required'                       => 'CC wajib diisi',
            'cc.max'                            => 'CC maksimal 100 karakter',
            'nipnas.required'                   => 'NIPNAS wajib diisi',
            'nipnas.max'                        => 'NIPNAS maksimal 50 karakter',
            'am.required'                       => 'Nama AM wajib diisi',
            'am.max'                            => 'Nama AM maksimal 100 karakter',
            'plan_bulan_billcomp_2025.required' => 'Plan bulan wajib diisi',
            'plan_bulan_billcomp_2025.integer'  => 'Plan harus berupa angka (contoh: 10)',
            'plan_bulan_billcomp_2025.min'      => 'Plan bulan minimal 1',
            'plan_bulan_billcomp_2025.max'      => 'Plan bulan maksimal 12',
            'est_nilai_bc.required'             => 'Estimasi nilai BC wajib diisi',
            'est_nilai_bc.numeric'              => 'Estimasi nilai BC harus berupa angka (contoh: 10000)',
            'est_nilai_bc.min'                  => 'Estimasi nilai BC tidak boleh negatif',
        ]);

        $periodeDate = $request->periode . '-01';

        $log = ScallingImport::where('periode', $periodeDate)
            ->where('type', $request->type)
            ->where('segment', $request->segment)
            ->first();

        if($log) {
            $data = ScallingData::create([
            'no'                      => $log->data()->count() + 1, // Auto-increment berdasarkan jumlah data yang sudah ada untuk log ini
            'imports_log_id'           => $log->id,
            'project'                  => $request->project,
            'id_lop'                   => $request->id_lop,
            'cc'                       => $request->cc,
            'nipnas'                   => $request->nipnas,
            'am'                       => $request->am,
            'mitra'                    => $request->mitra,
            'plan_bulan_billcomp_2025' => $request->plan_bulan_billcomp_2025,
            'est_nilai_bc'             => $request->est_nilai_bc,
        ]);
        } else {
            $import = ScallingImport::create([
                'original_filename'   => 'manual-input',
                'status'              => $request->status,
                'type'                => $request->type,
                'segment'             => $request->segment,
                'periode'             => $periodeDate,
                'total_rows_imported' => 0,
                'uploaded_by'         => auth()->user()->name ?? $request->ip(),
            ]);

            $data = ScallingData::create([
            'imports_log_id'           => $import->id,
            'project'                  => $request->project,
            'id_lop'                   => $request->id_lop,
            'cc'                       => $request->cc,
            'nipnas'                   => $request->nipnas,
            'am'                       => $request->am,
            'mitra'                    => $request->mitra,
            'plan_bulan_billcomp_2025' => $request->plan_bulan_billcomp_2025,
            'est_nilai_bc'             => $request->est_nilai_bc,
        ]);
        }



        return redirect()->back()->with('success', "Data untuk project \"{$data->project}\" berhasil disimpan.");
    }

    public function updateFunnelCheckbox(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:on-hand,qualified,koreksi,initiate',
            'data_id' => 'required|integer',
            'field' => 'required|string',
            'value' => 'required',
            'est_nilai_bc' => 'nullable',
        ]);

        if (auth()->user()->role !== 'admin') {
            $scallingData = \App\Models\ScallingData::find($request->data_id);
            if ($scallingData) {
               $import = $scallingData->scallingImport;
                if ($import && ($import->status ?? 'active') !== 'active') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data ini sedang dikunci oleh admin dan tidak dapat diubah.',
                    ], 403);
                }
            }
        }

        // Convert value to boolean (handles both true/false and "true"/"false")
        $value = filter_var($request->value, FILTER_VALIDATE_BOOLEAN);
        // note: est_nilai_bc may come as formatted string; keep raw for later calculation
        $rawEst = $request->est_nilai_bc ?? null;

        // Find or create the funnel tracking record
        $funnel = \App\Models\FunnelTracking::firstOrCreate(
            [
                'data_type' => $request->data_type,
                'data_id' => $request->data_id,
            ]
        );

        // when billing checkbox flips we may need to toggle every other boolean field
        $autoFields = [];

        // mirror the requested checkbox on master
        $funnel->{$request->field} = $value;

        if ($request->field === 'delivery_billing_complete') {
            // set billcomp value or clear it
            if ($value) {
                $funnel->delivery_nilai_billcomp = is_numeric($rawEst) ? (float) $rawEst : null;
            } else {
                $funnel->delivery_nilai_billcomp = null;
            }

            // gather all boolean fields except the billing flag itself
            $autoFields = collect($funnel->getCasts())
                ->filter(fn($c, $k) => $c === 'boolean' && $k !== 'delivery_billing_complete' && $k !== 'cancel')
                ->keys()
                ->toArray();

            // apply the same check/uncheck to each of them
            foreach ($autoFields as $fld) {
                $funnel->{$fld} = $value;
            }
        }

        $funnel->save();

        // Find or create today's task progress for this user
        $taskProgress = \App\Models\TaskProgress::firstOrCreate(
            [
                'task_id' => $funnel->id,
                'user_id' => auth()->id(),
                'tanggal' => today(),
            ]
        );

        // Update the checkbox field in task_progress
        $taskProgress->{$request->field} = $value;

        // billing complete uses the raw est value - compute only here
        if ($request->field === 'delivery_billing_complete') {
            if ($value) {
                $taskProgress->delivery_nilai_billcomp = is_numeric($rawEst) ? (float) $rawEst : null;
            } else {
                $taskProgress->delivery_nilai_billcomp = null;
            }

            // mirror the same boolean toggle on progress row
            foreach ($autoFields as $fld) {
                $taskProgress->{$fld} = $value;
            }
        }

        $taskProgress->save();

        $dataId   = $request->data_id;
        $funnel   = \App\Models\FunnelTracking::where('data_id', $dataId)->first();
        $periodeImport = \App\Models\ScallingData::find($dataId)?->scallingImport;

        $dataIdsInPeriode = collect();
        if ($periodeImport) {
            $dataIdsInPeriode = \App\Models\ScallingData::where('imports_log_id', $periodeImport->id)
                ->pluck('id');
        }

        $total = \App\Models\FunnelTracking::whereIn('data_id', $dataIdsInPeriode)
            ->where('delivery_billing_complete', true)
            ->whereNotNull('delivery_nilai_billcomp')
            ->sum('delivery_nilai_billcomp');

        return response()->json([
            'success' => true,
            'nilai_billcomp' => $taskProgress->delivery_nilai_billcomp,
            'total' => number_format((float) $total, 0, ',', '.'),
            // let frontend know which other fields to toggle and what value to apply
            'auto_fields' => $autoFields,
            'auto_value' => $request->field === 'delivery_billing_complete' ? $value : null,
        ]);
    }

    // ══════════════════════════════════════════════════════
    // Helper: upsert RisingStar per (user_id, type_id, periode)
    // Hanya kolom yang dikirim yang diupdate — tidak overwrite kolom lain.
    // ══════════════════════════════════════════════════════
    private function upsertRisingStar(int $typeId, array $values): RisingStar
    {
        $periode = now()->format('Y-m-01');

        $record = RisingStar::firstOrNew([
            'user_id'  => auth()->id(),
            'type_id'  => $typeId,
            'periode'  => $periode,
        ]);

        // Hanya isi kolom yang memang dikirim, kolom lain dibiarkan
        foreach ($values as $col => $val) {
            $record->{$col} = $val;
        }

        // Set status active jika record baru
        if (! $record->exists) {
            $record->status = 'active';
        }

        $record->save();

        return $record;
    }

    // ══ AOSODOMORO 0-3 Bulan (type_id: 7) ══

public function aosodomoro03Bulan(Request $request)
{
    $periode = now()->format('Y-m-01');

    $existing = RisingStar::where('user_id', auth()->id())
        ->where('type_id', 7)
        ->where('periode', $periode)
        ->orderBy('created_at', 'desc')
        ->first();

    $query = RisingStar::with(['user', 'type'])
        ->where('user_id', auth()->id())
        ->where('type_id', 7)
        ->orderBy('created_at', 'desc');

    if ($request->filled('bulan')) {
        $query->whereMonth('periode', $request->bulan);
    }
    if ($request->filled('tahun')) {
        $query->whereYear('periode', $request->tahun);
    }
    if ($request->filled('cari')) {
        $query->where(function($q) use ($request) {
            $q->where('commitment', 'like', '%'.$request->cari.'%')
              ->orWhere('real_ratio', 'like', '%'.$request->cari.'%');
        });
    }

    $history = $query->paginate(20)->withQueryString();

    $tahuns = RisingStar::where('user_id', auth()->id())
        ->where('type_id', 7)
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;
    $selectedCari  = $request->cari;

    return view('dashboard.sme.aosodomoro-0-3-bulan', compact(
        'history', 'existing', 'tahuns',
        'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

public function storeAosodomoro03Bulan(Request $request)
{
    $request->validate([
        'real_ratio' => 'required|numeric|min:0',
    ]);

    $periode = now()->format('Y-m-01');

    $lastCommitment = RisingStar::where('user_id', auth()->id())
        ->where('type_id', 7)
        ->where('periode', $periode)
        ->whereNotNull('commitment')
        ->orderBy('created_at', 'desc')
        ->value('commitment');

    RisingStar::create([
        'user_id'    => auth()->id(),
        'type_id'    => 7,
        'periode'    => $periode,
        'status'     => 'active',
        'commitment' => $lastCommitment,
        'real_ratio' => $request->real_ratio,
    ]);

    return redirect()->route('dashboard.sme.aosodomoro-0-3-bulan')
        ->with('success', 'Data realisasi Aosodomoro 0-3 Bulan berhasil disimpan.');
}

    // ══ AOSODOMORO > 3 Bulan (type_id: 8) ══

    public function aosodomoroAbove3Bulan(Request $request)
{
    $periode = now()->format('Y-m-01');

    $existing = RisingStar::where('user_id', auth()->id())
        ->where('type_id', 8)
        ->where('periode', $periode)
        ->orderBy('created_at', 'desc')
        ->first();

    $query = RisingStar::with(['user', 'type'])
        ->where('user_id', auth()->id())
        ->where('type_id', 8)
        ->orderBy('created_at', 'desc');

    if ($request->filled('bulan')) {
        $query->whereMonth('periode', $request->bulan);
    }
    if ($request->filled('tahun')) {
        $query->whereYear('periode', $request->tahun);
    }
    if ($request->filled('cari')) {
        $query->where(function($q) use ($request) {
            $q->where('commitment', 'like', '%'.$request->cari.'%')
              ->orWhere('real_ratio', 'like', '%'.$request->cari.'%');
        });
    }

    $history = $query->paginate(20)->withQueryString();

    $tahuns = RisingStar::where('user_id', auth()->id())
        ->where('type_id', 8)
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;
    $selectedCari  = $request->cari;

    return view('dashboard.sme.aosodomoro-above-3-bulan', compact(
        'history', 'existing', 'tahuns',
        'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

    public function storeAosodomoroAbove3Bulan(Request $request)
{
    $request->validate([
        'real_ratio' => 'required|numeric|min:0',
    ]);

    $periode = now()->format('Y-m-01');

    $lastCommitment = RisingStar::where('user_id', auth()->id())
        ->where('type_id', 8)
        ->where('periode', $periode)
        ->whereNotNull('commitment')
        ->orderBy('created_at', 'desc')
        ->value('commitment');

    RisingStar::create([
        'user_id'    => auth()->id(),
        'type_id'    => 8,
        'periode'    => $periode,
        'status'     => 'active',
        'commitment' => $lastCommitment,
        'real_ratio' => $request->real_ratio,
    ]);

    return redirect()->route('dashboard.sme.aosodomoro-above-3-bulan')
        ->with('success', 'Data realisasi Aosodomoro >3 Bulan berhasil disimpan.');
}

public function upselling(Request $request)
{
    $periode = now()->format('Y-m-01');

    $existing = Hsi::where('user_id', auth()->id())
        ->where('type', 'Next Level HSI')
        ->where('periode', $periode)
        ->orderBy('created_at', 'desc')
        ->first();

    $query = Hsi::with(['user'])
        ->where('user_id', auth()->id())
        ->where('type', 'Next Level HSI')
        ->orderBy('created_at', 'desc');

    if ($request->filled('bulan')) {
        $query->whereMonth('periode', $request->bulan);
    }
    if ($request->filled('tahun')) {
        $query->whereYear('periode', $request->tahun);
    }
    if ($request->filled('cari')) {
        $query->where(function($q) use ($request) {
            $q->where('commitment', 'like', '%'.$request->cari.'%')
              ->orWhere('real_ratio', 'like', '%'.$request->cari.'%');
        });
    }

    $history = $query->paginate(20)->withQueryString();

    $tahuns = Hsi::where('user_id', auth()->id())
        ->where('type', 'Next Level HSI')
        ->selectRaw('YEAR(periode) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    $selectedBulan = $request->bulan;
    $selectedTahun = $request->tahun;
    $selectedCari  = $request->cari;

    return view('dashboard.sme.upselling', compact(
        'history', 'existing', 'tahuns',
        'selectedBulan', 'selectedTahun', 'selectedCari'
    ));
}

public function storeUpselling(Request $request)
{
    $request->validate([
        'type'       => 'required|string',
        'real_ratio' => 'required|numeric|min:0',
        'commitment' => 'nullable|numeric|min:0',
    ]);

    $periode = now()->format('Y-m-01');

    $lastRecord = Hsi::where('user_id', auth()->id())
        ->where('type', $request->type)
        ->where('periode', $periode)
        ->whereNotNull('commitment')
        ->orderBy('created_at', 'desc')
        ->first();

    $commitment = $request->filled('commitment') && $request->commitment > 0
        ? $request->commitment
        : ($lastRecord->commitment ?? null);

    Hsi::create([
        'user_id'    => auth()->id(),
        'type'       => $request->type,
        'periode'    => $periode,
        'commitment' => $commitment,
        'real_ratio' => $request->real_ratio,
    ]);

    return redirect()->route('dashboard.sme.upselling')
        ->with('success', 'Data realisasi Upselling berhasil disimpan.');
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
