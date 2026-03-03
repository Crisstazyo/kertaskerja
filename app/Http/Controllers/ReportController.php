<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Ct0;
use App\Models\Ctc;
use App\Models\RisingStar;
use App\Models\Psak;
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

        // ══ C3MR ══
        $c3mrKomitmen  = $avgCol('C3MR', 'commitment');
        $c3mrRealisasi = $avgCol('C3MR', 'real_ratio');

        // ══ BILLING PERDANAN ══
        $bilperKomitmen  = $avgCol('Billing Perdana', 'commitment');
        $bilperRealisasi = $avgCol('Billing Perdana', 'real_ratio');

        // ══ COLLECTION RATIO (per segment) ══
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

        // ══ UTIP CORRECTIVE ══
        $utipCorrective = [
            'label'    => 'UTIP Corrective',
            'planRp'   => $sumCol('UTIP Corrective', 'plan'),
            'commitRp' => $sumCol('UTIP Corrective', 'commitment'),
            'realRp'   => $sumCol('UTIP Corrective', 'real_ratio'),
        ];

        // ══ NEW UTIP (per periode) ══
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

        $toFloat = fn($v) => floatval(str_replace(',', '.', $v ?? 0));

        $filterPeriodeCt0 = function ($q) use ($filtered, $filterBulan, $filterTahun) {
            if ($filtered && $filterBulan) $q->whereMonth('periode', $filterBulan);
            if ($filtered && $filterTahun) $q->whereYear('periode', $filterTahun);
        };

        $ct0Regions = [
            'Inner Sumut', 'Telda Lubuk Pakam', 'Telda Binjai', 'Telda Kisaran',
            'Telda Siantar', 'Telda Kabanjahe', 'Telda Rantauprapat',
            'Telda Toba', 'Telda Sibolga', 'Telda Padang Sidempuan',
        ];
        $ct0RegionLabels = [
            'Inner Sumut'            => 'Inner Sumut',
            'Telda Lubuk Pakam'      => 'Lubuk Pakam',
            'Telda Binjai'           => 'Binjai',
            'Telda Kisaran'          => 'Kisaran',
            'Telda Siantar'          => 'Siantar',
            'Telda Kabanjahe'        => 'Kabanjahe',
            'Telda Rantauprapat'     => 'Rantau Prapat',
            'Telda Toba'             => 'Toba',
            'Telda Sibolga'          => 'Sibolga',
            'Telda Padang Sidempuan' => 'Padang Sidempuan',
        ];

        $ct0Data = [];
        foreach ($ct0Regions as $region) {
            $rows = Ct0::where('region', $region)->tap($filterPeriodeCt0)->get();
            $commit = $rows->sum(fn($r) => $toFloat($r->commitment));
            $real   = $rows->sum(fn($r) => $toFloat($r->real_ratio));
            $ct0Data[] = [
                'label'  => $ct0RegionLabels[$region] ?? $region,
                'commit' => $commit,
                'real'   => $real,
                'ach'    => $commit == 0 ? '-' : number_format(($real / $commit) * 100, 1) . '%',
            ];
        }

        $ct0TotalCommit = array_sum(array_column($ct0Data, 'commit'));
        $ct0TotalReal   = array_sum(array_column($ct0Data, 'real'));
        $ct0Score       = $ct0TotalCommit == 0 ? '-' : number_format(($ct0TotalReal / $ct0TotalCommit) * 100, 1) . '%';

        $ctcCt0Real   = Ctc::where('segment', 'CT0')->tap($filterPeriodeCt0)
            ->get()->sum(fn($r) => $toFloat($r->commitment));

        $ctcSegments = ['Sales HSI (all)', 'Churn', 'Winback'];
        $ctcData = [];
        foreach ($ctcSegments as $seg) {
            $rows   = Ctc::where('segment', $seg)->tap($filterPeriodeCt0)->get();
            $commit = $rows->sum(fn($r) => $toFloat($r->commitment));
            $real   = $rows->sum(fn($r) => $toFloat($r->real_ratio));
            if ($seg === 'Churn') {
                $ach = $real == 0 ? '-' : number_format(($commit / $real) * 100, 1) . '%';
            } else {
                $ach = $commit == 0 ? '-' : number_format(($real / $commit) * 100, 1) . '%';
            }
            $ctcData[$seg] = ['commit' => $commit, 'real' => $real, 'ach' => $ach];
        }

        $lossRateDenom = $ctcData['Sales HSI (all)']['real'] + $ctcData['Winback']['real'];
        $lossRateReal  = $lossRateDenom == 0 ? '-'
            : number_format((($ctcCt0Real + $ctcData['Churn']['real']) / $lossRateDenom) * 100, 1) . '%';
        $lossRateAch   = $lossRateReal;

        $filterPeriodeRs = function ($q) use ($filtered, $filterBulan, $filterTahun) {
            if ($filtered && $filterBulan) $q->whereMonth('periode', $filterBulan);
            if ($filtered && $filterTahun) $q->whereYear('periode', $filterTahun);
        };

        $rsRows = function (int $typeId) use ($filterPeriodeRs) {
            return RisingStar::where('type_id', $typeId)
                ->tap($filterPeriodeRs)
                ->get();
        };

        $b1TypeIds = [2, 1, 3];
        $b1Labels  = [1 => 'Visiting AM', 2 => 'Visiting GM', 3 => 'Visiting HOTD'];
        $b1Data = [];
        $b1AchSum = 0; $b1AchCount = 0;
        foreach ($b1TypeIds as $tid) {
            $rows   = $rsRows($tid);
            $commit = $rows->sum(fn($r) => $toFloat($r->commitment));
            $real   = $rows->sum(fn($r) => $toFloat($r->real_ratio));
            $ratio  = $commit > 0 ? ($real / $commit) * 100 : 0;
            if ($commit > 0) { $b1AchSum += $ratio; $b1AchCount++; }
            $b1Data[$tid] = [
                'label'  => $b1Labels[$tid],
                'commit' => $commit,
                'real'   => $real,
                'ratio'  => $ratio,
            ];
        }
        $b1Score = $b1AchCount == 0 ? '-' : number_format($b1AchSum / $b1AchCount, 1) . '%';

        $b2TypeIds = [4, 5];
        $b2Labels  = [4 => 'Profiling MAPS AM', 5 => 'Profiling Overall HOTD'];
        $b2Data = [];
        $b2AchSum = 0; $b2AchCount = 0;
        foreach ($b2TypeIds as $tid) {
            $rows   = $rsRows($tid);
            $commit = $rows->sum(fn($r) => $toFloat($r->commitment));
            $real   = $rows->sum(fn($r) => $toFloat($r->real_ratio));
            $ratio  = $commit > 0 ? ($real / $commit) * 100 : 0;
            if ($commit > 0) { $b2AchSum += $ratio; $b2AchCount++; }
            $b2Data[$tid] = [
                'label'  => $b2Labels[$tid],
                'commit' => $commit,
                'real'   => $real,
                'ratio'  => $ratio,
            ];
        }
        $b2Score = $b2AchCount == 0 ? '-' : number_format($b2AchSum / $b2AchCount, 1) . '%';

        $b3Rows   = $rsRows(6);
        $b3Commit = $b3Rows->sum(fn($r) => $toFloat($r->commitment));
        $b3Real   = $b3Rows->sum(fn($r) => $toFloat($r->real_ratio));
        $b3Score  = $b3Commit > 0 ? number_format($b3Real, 1) . '%' : '-';

        $b4Rows7  = $rsRows(7);
        $b4Rows8  = $rsRows(8);
        $b4Commit7 = $b4Rows7->sum(fn($r) => $toFloat($r->commitment));
        $b4Real7   = $b4Rows7->sum(fn($r) => $toFloat($r->real_ratio));
        $b4Commit8 = $b4Rows8->sum(fn($r) => $toFloat($r->commitment));
        $b4Real8   = $b4Rows8->sum(fn($r) => $toFloat($r->real_ratio));

        $b4RpMillion = (0.30 * $b4Real7) + (0.70 * $b4Real8);

        $b4Score = number_format($b4RpMillion, 1) . '%';

        $filterPeriodePsak = function ($q) use ($filtered, $filterBulan, $filterTahun) {
            if ($filtered && $filterBulan) $q->whereMonth('periode', $filterBulan);
            if ($filtered && $filterTahun)  $q->whereYear('periode', $filterTahun);
        };

        $psakSegments = [
            'Government' => 'PSAK Gov',
            'Private'    => 'PSAK Private',
            'SOE'        => 'PSAK SOE',
            'SME'        => 'PSAK SME',
        ];

        $psakIndicators = [
            'nc_step14'    => 'Not Close Step 1-4',
            'nc_step5'     => 'Not Close Step 5',
            'nc_konfirmasi'=> 'Not Close Konfirmasi',
            'nc_splitbill' => 'Not Close Splitt Bill',
            'nc_crvariable'=> 'Not Close CR Variable',
            'nc_unidentified'=> 'Not Close Unidentified KB',
        ];

        $psakData = [];
        foreach ($psakSegments as $typeKey => $typeLabel) {
            $rows = Psak::where('type', $typeKey)
                ->tap($filterPeriodePsak)
                ->get();

            $indicators = [];
            $totalCommRp = 0;
            $totalRealRp = 0;

            foreach ($psakIndicators as $segKey => $segLabel) {
                $filtered_rows = $rows->where('segment', $segKey);
                $commSsl = $filtered_rows->sum(fn($r) => $toFloat($r->comm_ssl));
                $commRp  = $filtered_rows->sum(fn($r) => $toFloat($r->comm_rp));
                $realSsl = $filtered_rows->sum(fn($r) => $toFloat($r->real_ssl));
                $realRp  = $filtered_rows->sum(fn($r) => $toFloat($r->real_rp));

                $ach = $commRp == 0 ? '-' : number_format(($realRp / $commRp) * 100, 1) . '%';

                $totalCommRp += $commRp;
                $totalRealRp += $realRp;

                $indicators[$segKey] = [
                    'label'   => $segLabel,
                    'commSsl' => $commSsl,
                    'commRp'  => $commRp,
                    'realSsl' => $realSsl,
                    'realRp'  => $realRp,
                    'ach'     => $ach,
                ];
            }

            $score = $totalCommRp == 0 ? '-' : number_format(($totalRealRp / $totalCommRp) * 100, 1) . '%';

            $psakData[$typeKey] = [
                'label'      => $typeLabel,
                'indicators' => $indicators,
                'score'      => $score,
            ];
        }

        return view('report.report', compact(
            'filtered', 'filterBulan', 'filterTahun',
            'c3mrKomitmen', 'c3mrRealisasi',
            'bilperKomitmen', 'bilperRealisasi',
            'crData',
            'utipCorrective',
            'newUtipPeriodes',
            'ct0Data', 'ct0Score', 'ct0TotalCommit', 'ct0TotalReal',
            'ctcCt0Real', 'ctcData', 'lossRateReal', 'lossRateAch',
            'b1Data', 'b1Score',
            'b2Data', 'b2Score',
            'b3Commit', 'b3Real', 'b3Score',
            'b4Commit7', 'b4Real7', 'b4Commit8', 'b4Real8', 'b4RpMillion', 'b4Score',
            'psakData'
        ));
    }
}
