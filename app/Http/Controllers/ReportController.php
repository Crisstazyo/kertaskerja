<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\C3mr;
use App\Models\BillingPerdanan;
use App\Models\CollectionRatioData;
use App\Models\UtipData;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filtered    = $request->has('filter');
        $filterBulan = $request->input('bulan');
        $filterTahun = $request->input('tahun');

        $c3mrKomitmen = C3mr::where('type', 'komitmen')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->avg('ratio') ?? 0;

        $c3mrRealisasi = C3mr::where('type', 'realisasi')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->avg('ratio') ?? 0;

        $bilperKomitmen = BillingPerdanan::where('type', 'komitmen')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->avg('ratio') ?? 0;

        $bilperRealisasi = BillingPerdanan::where('type', 'realisasi')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->avg('ratio') ?? 0;

        $crData = [];
        foreach (['GOV', 'PRIVATE', 'SME', 'SOE'] as $seg) {
            $crData[$seg] = [
            'komitmen'  => CollectionRatioData::where('type', 'komitmen')
            ->where('segment', $seg)
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->avg('target_ratio') ?? 0,

            'realisasi' => CollectionRatioData::where('type', 'realisasi')
            ->where('segment', $seg)
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->avg('ratio_aktual') ?? 0,
            ];
        }

        $utipCorrectivePlan = UtipData::where('type', 'Corrective UTIP')
            ->where('category', 'plan')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->sum('value') ?? 0;

        $utipCorrectiveCommit = UtipData::where('type', 'Corrective UTIP')
            ->where('category', 'komitmen')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->sum('value') ?? 0;

        $utipCorrectiveReal = UtipData::where('type', 'Corrective UTIP')
            ->where('category', 'realisasi')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->sum('value') ?? 0;

        $utipCorrective = [
            'label'    => 'UTIP Corrective',
            'planRp'   => $utipCorrectivePlan,
            'commitRp' => $utipCorrectiveCommit,
            'realRp'   => $utipCorrectiveReal,
        ];

        $newUtipAll = UtipData::where('type', 'New UTIP')
            ->when($filtered && $filterBulan, fn($q) => $q->where('month', $filterBulan))
            ->when($filtered && $filterTahun, fn($q) => $q->where('year', $filterTahun))
            ->get();

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

        $newUtipPeriodes = [];
            foreach ($periodes as $p) {
                if ($filtered && $filterBulan && $filterBulan != $p['bulan']) continue;
                if ($filtered && $filterTahun && $filterTahun != $p['tahun']) continue;
        $plan   = $newUtipAll->where('category', 'plan')     ->where('month', $p['bulan'])->where('year', $p['tahun'])->sum('value');
        $commit = $newUtipAll->where('category', 'komitmen') ->where('month', $p['bulan'])->where('year', $p['tahun'])->sum('value');
        $real   = $newUtipAll->where('category', 'realisasi')->where('month', $p['bulan'])->where('year', $p['tahun'])->sum('value');

        $newUtipPeriodes[] = [
            'label'    => $p['label'],
            'planRp'   => $plan,
            'commitRp' => $commit,
            'realRp'   => $real,
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
