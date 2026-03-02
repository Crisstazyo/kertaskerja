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

        $filterPeriode = function ($q) use ($filtered, $filterBulan, $filterTahun) {
            if ($filtered && $filterBulan) {
                $q->whereMonth('periode', $filterBulan);
            }
            if ($filtered && $filterTahun) {
                $q->whereYear('periode', $filterTahun);
            }
        };

        $avgCol = function (string $type, string $col, ?string $segment = null) use ($filterPeriode) {
            return Collection::where('type', $type)
                ->when($segment, fn($q) => $q->where('segment', $segment))
                ->tap($filterPeriode)
                ->selectRaw('AVG(CAST(REPLACE(' . $col . ', \',\', \'.\') AS DECIMAL(10,2))) as result')
                ->value('result') ?? 0;
        };

        $sumCol = function (string $type, string $col) use ($filterPeriode) {
            return Collection::where('type', $type)
                ->tap($filterPeriode)
                ->selectRaw('SUM(CAST(REPLACE(' . $col . ', \',\', \'.\') AS DECIMAL(15,2))) as result')
                ->value('result') ?? 0;
        };

        $c3mrKomitmen  = $avgCol('C3MR', 'commitment');
        $c3mrRealisasi = $avgCol('C3MR', 'real_ratio');

        $bilperKomitmen  = $avgCol('Billing Perdana', 'commitment');
        $bilperRealisasi = $avgCol('Billing Perdana', 'real_ratio');

        $crData = [];
        $segmentMap = [
            'GOV'     => 'Government',
            'PRIVATE' => 'Private',
            'SME'     => 'SME',
            'SOE'     => 'SOE',
        ];
        foreach ($segmentMap as $key => $dbSegment) {
            $crData[$key] = [
                'komitmen'  => $avgCol('Collection Ratio', 'commitment', $dbSegment),
                'realisasi' => $avgCol('Collection Ratio', 'real_ratio', $dbSegment),
            ];
        }

        $utipCorrective = [
            'label'    => 'UTIP Corrective',
            'planRp'   => $sumCol('UTIP Corrective', 'plan'),
            'commitRp' => $sumCol('UTIP Corrective', 'commitment'),
            'realRp'   => $sumCol('UTIP Corrective', 'real_ratio'),
        ];

        $newUtipAll = Collection::where('type', 'like', 'New UTIP%')
            ->tap($filterPeriode)
            ->get();

        $periodes = [
            ['bulan' => 7,  'tahun' => 2025, 'label' => 'New UTIP Jul 2025'],
            ['bulan' => 8,  'tahun' => 2025, 'label' => 'New UTIP Aug 2025'],
            ['bulan' => 9,  'tahun' => 2025, 'label' => 'New UTIP Sep 2025'],
            ['bulan' => 10, 'tahun' => 2025, 'label' => 'New UTIP Okt 2025'],
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
            ['bulan' => 10, 'tahun' => 2026, 'label' => 'New UTIP Okt 2026'],
            ['bulan' => 11, 'tahun' => 2026, 'label' => 'New UTIP Nov 2026'],
            ['bulan' => 12, 'tahun' => 2026, 'label' => 'New UTIP Des 2026'],
        ];

        $newUtipPeriodes = [];
        foreach ($periodes as $p) {
            if ($filtered && $filterBulan && $filterBulan != $p['bulan']) continue;
            if ($filtered && $filterTahun && $filterTahun != $p['tahun']) continue;

            $rows = $newUtipAll->filter(fn($row) =>
                Carbon::parse($row->periode)->month == $p['bulan'] &&
                Carbon::parse($row->periode)->year  == $p['tahun']
            );

            if (!$filtered || $rows->isNotEmpty()) {
                $toFloat = fn($v) => floatval(str_replace(',', '.', $v ?? 0));
                $newUtipPeriodes[] = [
                    'label'    => $p['label'],
                    'planRp'   => $rows->sum(fn($r) => $toFloat($r->plan)),
                    'commitRp' => $rows->sum(fn($r) => $toFloat($r->commitment)),
                    'realRp'   => $rows->sum(fn($r) => $toFloat($r->real_ratio)),
                ];
            }
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
