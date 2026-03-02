<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filtered    = $request->has('filter');
        $filterBulan = $request->input('bulan');
        $filterTahun = $request->input('tahun');

        // Helper closure: filter periode berdasarkan bulan & tahun dari kolom 'periode' (format Y-m atau Y-m-d)
        $filterPeriode = function ($q) use ($filtered, $filterBulan, $filterTahun) {
            if ($filtered && $filterBulan) {
                $q->whereMonth('periode', $filterBulan);
            }
            if ($filtered && $filterTahun) {
                $q->whereYear('periode', $filterTahun);
            }
        };

        // ══ C3MR ══
        $c3mrKomitmen = Collection::where('type', 'c3mr')
            ->tap($filterPeriode)
            ->avg('commitment') ?? 0;

        $c3mrRealisasi = Collection::where('type', 'c3mr')
            ->tap($filterPeriode)
            ->avg('real_ratio') ?? 0;

        // ══ BILLING PERDANAN ══
        $bilperKomitmen = Collection::where('type', 'billing_perdanan')
            ->tap($filterPeriode)
            ->avg('commitment') ?? 0;

        $bilperRealisasi = Collection::where('type', 'billing_perdanan')
            ->tap($filterPeriode)
            ->avg('real_ratio') ?? 0;

        // ══ COLLECTION RATIO (per segment) ══
        $crData = [];
        foreach (['GOV', 'PRIVATE', 'SME', 'SOE'] as $seg) {
            $crData[$seg] = [
                'komitmen'  => Collection::where('type', 'collection_ratio')
                    ->where('segment', $seg)
                    ->tap($filterPeriode)
                    ->avg('commitment') ?? 0,

                'realisasi' => Collection::where('type', 'collection_ratio')
                    ->where('segment', $seg)
                    ->tap($filterPeriode)
                    ->avg('real_ratio') ?? 0,
            ];
        }

        // ══ UTIP CORRECTIVE ══
        $utipCorrective = [
            'label'    => 'UTIP Corrective',
            'planRp'   => Collection::where('type', 'utip_corrective')->tap($filterPeriode)->sum('plan')        ?? 0,
            'commitRp' => Collection::where('type', 'utip_corrective')->tap($filterPeriode)->sum('commitment')  ?? 0,
            'realRp'   => Collection::where('type', 'utip_corrective')->tap($filterPeriode)->sum('real_ratio')  ?? 0,
        ];

        // ══ NEW UTIP (per periode) ══
        $periodes = [
            ['bulan' => 7,  'tahun' => 2025, 'label' => 'New UTIP Jul 2025'],
            ['bulan' => 8,  'tahun' => 2025, 'label' => 'New UTIP Aug 2025'],
            ['bulan' => 9,  'tahun' => 2025, 'label' => 'New UTIP Sep 2025'],
            ['bulan' => 10, 'tahun' => 2025, 'label' => 'New UTIP Oct 2025'],
            ['bulan' => 11, 'tahun' => 2025, 'label' => 'New UTIP Nov 2025'],
            ['bulan' => 12, 'tahun' => 2025, 'label' => 'New UTIP Des 2025'],
            ['bulan' => 1,  'tahun' => 2026, 'label' => 'New UTIP Jan 2026'],
            ['bulan' => 2,  'tahun' => 2026, 'label' => 'New UTIP Feb 2026'],
            ['bulan' => 3,  'tahun' => 2026, 'label' => 'New UTIP Mar 2026'],
            ['bulan' => 4,  'tahun' => 2026, 'label' => 'New UTIP Apr 2026'],
            ['bulan' => 5,  'tahun' => 2026, 'label' => 'New UTIP May 2026'],
            ['bulan' => 6,  'tahun' => 2026, 'label' => 'New UTIP Jun 2026'],
            ['bulan' => 7,  'tahun' => 2026, 'label' => 'New UTIP Jul 2026'],
            ['bulan' => 8,  'tahun' => 2026, 'label' => 'New UTIP Aug 2026'],
            ['bulan' => 9,  'tahun' => 2026, 'label' => 'New UTIP Sep 2026'],
            ['bulan' => 10, 'tahun' => 2026, 'label' => 'New UTIP Oct 2026'],
            ['bulan' => 11, 'tahun' => 2026, 'label' => 'New UTIP Nov 2026'],
            ['bulan' => 12, 'tahun' => 2026, 'label' => 'New UTIP Des 2026'],
        ];

        // Ambil semua new_utip sekaligus, filter di PHP
        $newUtipAll = Collection::where('type', 'new_utip')
            ->tap($filterPeriode)
            ->get();

        $newUtipPeriodes = [];
        foreach ($periodes as $p) {
            // Skip periode yang tidak sesuai filter
            if ($filtered && $filterBulan && $filterBulan != $p['bulan']) continue;
            if ($filtered && $filterTahun && $filterTahun != $p['tahun']) continue;

            $rows = $newUtipAll
                ->filter(fn($row) =>
                    Carbon::parse($row->periode)->month == $p['bulan'] &&
                    Carbon::parse($row->periode)->year  == $p['tahun']
                );

            $newUtipPeriodes[] = [
                'label'    => $p['label'],
                'planRp'   => $rows->sum('plan'),
                'commitRp' => $rows->sum('commitment'),
                'realRp'   => $rows->sum('real_ratio'),
            ];
        }

        return view('report.report', compact(
            'filtered', 'filterBulan', 'filterTahun',
            'c3mrKomitmen', 'c3mrRealisasi',
            'bilperKomitmen', 'bilperRealisasi',
            'crData',
            'utipCorrective',
            'newUtipPeriodes'
        ));
    }
}
