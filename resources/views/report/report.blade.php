@extends('layouts.app')

@section('title', 'Report')

@section('content')

    @php
        function getColorClass($value, $fairness)
        {
            if ($value == '-' || $value === null) return '';
            $v = floatval(str_replace('%', '', $value));
            switch ($fairness) {
                case '96-100':
                    if ($v < 98)    return 'bg-black text-white';
                    if ($v < 99.2)  return 'bg-red-500 text-white';
                    if ($v < 100)   return 'bg-yellow-300';
                    return 'bg-green-500 text-white';
                case '99-100':
                    if ($v < 99.5)  return 'bg-black text-white';
                    if ($v < 99.8)  return 'bg-red-500 text-white';
                    if ($v < 100)   return 'bg-yellow-300';
                    return 'bg-green-500 text-white';
                case '90-100':
                    if ($v < 95)    return 'bg-black text-white';
                    if ($v < 98)    return 'bg-red-500 text-white';
                    if ($v < 100)   return 'bg-yellow-300';
                    return 'bg-green-500 text-white';
                case '0-100':
                    if ($v < 50)    return 'bg-black text-white';
                    if ($v < 80)    return 'bg-red-500 text-white';
                    if ($v < 100)   return 'bg-yellow-300';
                    return 'bg-green-500 text-white';
                case '0-70':
                    if ($v < 35)    return 'bg-black text-white';
                    if ($v < 56)    return 'bg-red-500 text-white';
                    if ($v < 70)    return 'bg-yellow-300';
                    return 'bg-green-500 text-white';
                case '0-45':
                    if ($v < 22.5)  return 'bg-black text-white';
                    if ($v < 36)    return 'bg-red-500 text-white';
                    if ($v < 45)    return 'bg-yellow-300';
                    return 'bg-green-500 text-white';
                case '100-30':
                    if ($v > 70)    return 'bg-black text-white';
                    if ($v > 50)    return 'bg-red-500 text-white';
                    if ($v > 30)    return 'bg-yellow-300';
                    return 'bg-green-500 text-white';
                default:
                    return '';
            }
        }

        $bulanNames = ['','Januari','Februari','Maret','April','Mei','Juni',
                       'Juli','Agustus','September','Oktober','November','Desember'];

        $periodeLabel = 'Semua Data';
        if ($filtered) {
            if ($filterBulan && $filterTahun)
                $periodeLabel = $bulanNames[$filterBulan] . ' ' . $filterTahun;
            elseif ($filterTahun)
                $periodeLabel = 'Tahun ' . $filterTahun;
            elseif ($filterBulan)
                $periodeLabel = $bulanNames[$filterBulan] . ' Semua Tahun';
        }

        $fairnessC3mr   = '96-100';
        $scoreC3mr      = $c3mrKomitmen == 0 ? '-' : number_format(($c3mrRealisasi / $c3mrKomitmen) * 100, 1) . '%';
        $colorC3mr      = getColorClass($scoreC3mr, $fairnessC3mr);

        $fairnessBilper = '99-100';
        $scoreBilper    = $bilperKomitmen == 0 ? '-' : number_format(($bilperRealisasi / $bilperKomitmen) * 100, 1) . '%';
        $colorBilper    = getColorClass($scoreBilper, $fairnessBilper);

        $fairnessCR     = '90-100';
        $crScores = []; $crVals = [];
        foreach ($crData as $seg => $val) {
            $pct = $val['komitmen'] == 0 ? '-' : number_format(($val['realisasi'] / $val['komitmen']) * 100, 1) . '%';
            $crScores[$seg] = ['text' => $pct, 'color' => getColorClass($pct, $fairnessCR)];
            $crVals[$seg]   = $val['komitmen'] == 0 ? 0 : ($val['realisasi'] / $val['komitmen']) * 100;
        }
        $crTotalPct   = number_format(($crVals['GOV']*0.4)+($crVals['SME']*0.2)+($crVals['PRIVATE']*0.2)+($crVals['SOE']*0.2),1).'%';
        $colorCRTotal = getColorClass($crTotalPct, $fairnessCR);

        $fairnessUTIP        = '0-100';
        $achCorrective       = $utipCorrective['commitRp'] == 0 ? '-' : number_format(($utipCorrective['realRp'] / $utipCorrective['commitRp']) * 100, 1) . '%';
        $colorAchCorrective  = getColorClass($achCorrective, $fairnessUTIP);

        $allUtipRows      = array_merge([$utipCorrective], $newUtipPeriodes);
        $totalCommitUTIP  = array_sum(array_column($allUtipRows, 'commitRp'));
        $totalRealUTIP    = array_sum(array_column($allUtipRows, 'realRp'));
        $scoreUTIP        = $totalCommitUTIP == 0 ? '-' : number_format(($totalRealUTIP / $totalCommitUTIP) * 100, 1) . '%';
        $colorScoreUTIP   = getColorClass($scoreUTIP, $fairnessUTIP);
        $utipRowspan      = 1 + count($newUtipPeriodes);

        $fairnessCt0     = '0-100';
        $fairnessCtc     = '0-100';
        $fairnessLoss    = '100-30';
        $ct0RowCount     = count($ct0Data);
        $ctcRowCount     = 5;
        $ctcSectionRows  = $ct0RowCount + $ctcRowCount;

        foreach ($ct0Data as &$row) {
            $row['achColor'] = getColorClass($row['ach'], $fairnessCt0);
        }
        unset($row);
        $ct0ScoreColor = getColorClass($ct0Score, $fairnessCt0);

        foreach (['Sales HSI (all)', 'Churn', 'Winback'] as $seg) {
            $ctcData[$seg]['achColor'] = getColorClass($ctcData[$seg]['ach'], $fairnessCtc);
        }
        $lossRateColor = getColorClass($lossRateReal, $fairnessLoss);

        $fairnessRs   = '0-100';
        $fairnessB4   = '0-70';

        foreach ($b1Data as &$row) {
            $rowPct = $row['commit'] > 0 ? number_format($row['ratio'], 1) . '%' : '-';
            $row['realPct']   = $rowPct;
            $row['achColor']  = getColorClass($rowPct, $fairnessRs);
        }
        unset($row);
        $b1ScoreColor = getColorClass($b1Score, $fairnessRs);

        foreach ($b2Data as &$row) {
            $rowPct = $row['commit'] > 0 ? number_format($row['ratio'], 1) . '%' : '-';
            $row['realPct']   = $rowPct;
            $row['achColor']  = getColorClass($rowPct, $fairnessRs);
        }
        unset($row);
        $b2ScoreColor = getColorClass($b2Score, $fairnessRs);

        $b3ScoreColor   = getColorClass($b3Score, $fairnessRs);
        $b4ScoreColor   = getColorClass($b4Score, $fairnessB4);
        $b4RpMillionFmt = number_format($b4RpMillion, 1);
    @endphp

    <div class="min-h-screen" style="background:#f1f5f9;">
        <div class="max-w-7xl mx-auto px-8 py-10">

            {{-- ══ HEADER ══ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden no-print">
                <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
                <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div>
                            <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                            <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                                Report <span class="text-red-600">Data</span>
                            </h1>
                            <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Periode: {{ $periodeLabel }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @php
                            $dashboardRoute = match(Auth::user()->role) {
                                'admin'      => route('admin.index'),
                                'gov'        => route('dashboard.gov'),
                                'soe'        => route('dashboard.soe'),
                                'sme'        => route('dashboard.sme'),
                                'private'    => route('dashboard.private'),
                                'collection' => route('dashboard.collection'),
                                'ctc'        => route('dashboard.ctc'),
                                'risingStar' => route('dashboard.rising-star'),
                                default      => '/',
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}"
                            class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-slate-900 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ══ FILTER ══ --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-8 py-5 mb-8 no-print">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Filter Periode</h2>
                </div>
                <form method="GET" action="{{ route('report.index') }}">
                    <input type="hidden" name="filter" value="1">
                    <div class="flex items-end justify-between gap-4">
                        <div class="flex items-end gap-4 flex-1">
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Bulan</label>
                                <select name="bulan" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 bg-white">
                                    <option value="">— Semua Bulan —</option>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $filterBulan == $m ? 'selected' : '' }}>{{ $bulanNames[$m] }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Tahun</label>
                                <select name="tahun" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 bg-white">
                                    <option value="">— Semua Tahun —</option>
                                    @for($y = 2025; $y <= 2026; $y++)
                                        <option value="{{ $y }}" {{ $filterTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex items-center space-x-1.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-4 py-2 rounded-lg transition-all uppercase tracking-wider whitespace-nowrap">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                                </svg>
                                <span>Tampilkan</span>
                            </button>
                            <a href="{{ route('report.index') }}" class="flex items-center space-x-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-lg transition-all uppercase tracking-wider whitespace-nowrap">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span>Reset</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ══ TABLE ══ --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between no-print">
                    <div class="flex items-center space-x-3">
                        <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Report Data — {{ $periodeLabel }}</h2>
                    </div>
                    <button onclick="window.print()" class="flex items-center space-x-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-4 py-2 rounded-lg transition-colors uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        <span>Print</span>
                    </button>
                </div>

                <div class="p-6 overflow-x-auto">
                    <div class="print-header">
                        <p style="font-size:10px;font-weight:900;letter-spacing:0.2em;color:#dc2626;text-transform:uppercase;margin-bottom:2px;">Witel Sumut</p>
                        <h1 style="font-size:16px;font-weight:900;text-transform:uppercase;margin:0;">Report Data</h1>
                        <p style="font-size:9px;color:#555;margin-top:2px;">Periode: {{ $periodeLabel }}</p>
                        <hr style="margin:6px 0;border-color:#ccc;">
                    </div>

                    <table class="min-w-full border-collapse border border-gray-400 text-[11px] font-sans">
                        <thead class="bg-[#4a7795] text-white">
                            <tr>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-8 text-center">Nbr</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 text-center">Unit / Scope</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 text-center">Indicator</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-10 text-center">Denom</th>
                                <th colspan="2" class="border border-gray-300 px-2 py-1 text-center">Commitment</th>
                                <th colspan="2" class="border border-gray-300 px-2 py-1 text-center">Real</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-14 text-center">Fairness</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-14 text-center">Ach</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-14 text-center">Score</th>
                            </tr>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2 py-1">Amount</th>
                                <th class="border border-gray-300 px-2 py-1">Rp Million</th>
                                <th class="border border-gray-300 px-2 py-1">Amount</th>
                                <th class="border border-gray-300 px-2 py-1">Rp Million</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">

                            <tr class="border-b-2 border-black font-bold">
                                <td class="border border-gray-400 text-center">2</td>
                                <td colspan="10" class="border border-gray-400 px-2 py-1 uppercase bg-gray-50">Collection</td>
                            </tr>

                            @php $sectionRowspan = 1 + 1 + 4 + $utipRowspan; @endphp

                            <tr>
                                <td rowspan="{{ $sectionRowspan }}" class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 py-1 font-semibold">a&nbsp;&nbsp;C3MR</td>
                                <td class="border border-gray-400 px-2 py-1"></td>
                                <td class="border border-gray-400 text-center">%</td>
                                <td class="border border-gray-400 px-2 text-right">{{ $c3mrKomitmen > 0 ? number_format($c3mrKomitmen, 1) : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $c3mrRealisasi > 0 ? number_format($c3mrRealisasi, 1) : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">{{ $fairnessC3mr }}</td>
                                <td colspan="2" class="border border-gray-400 text-right font-bold {{ $colorC3mr }}">{{ $scoreC3mr }}</td>
                            </tr>

                            <tr>
                                <td class="border border-gray-400 px-2 py-1 font-semibold">b&nbsp;&nbsp;Bilper</td>
                                <td class="border border-gray-400 px-2 py-1"></td>
                                <td class="border border-gray-400 text-center">%</td>
                                <td class="border border-gray-400 px-2 text-right">{{ $bilperKomitmen > 0 ? number_format($bilperKomitmen, 1) : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $bilperRealisasi > 0 ? number_format($bilperRealisasi, 1) : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">{{ $fairnessBilper }}</td>
                                <td colspan="2" class="border border-gray-400 text-right font-bold {{ $colorBilper }}">{{ $scoreBilper }}</td>
                            </tr>

                            @foreach(['GOV', 'SME', 'PRIVATE', 'SOE'] as $si => $seg)
                                <tr>
                                    @if($si === 0)
                                        <td rowspan="4" class="border border-gray-400 px-2 py-1 align-top font-semibold">c&nbsp;&nbsp;CR</td>
                                    @endif
                                    <td class="border border-gray-400 px-2 py-1">CR {{ $seg }}</td>
                                    <td class="border border-gray-400 text-center">%</td>
                                    <td class="border border-gray-400 px-2 text-right">{{ $crData[$seg]['komitmen'] > 0 ? number_format($crData[$seg]['komitmen'], 1) : '' }}</td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 px-2 text-right">{{ $crData[$seg]['realisasi'] > 0 ? number_format($crData[$seg]['realisasi'], 1) : '' }}</td>
                                    <td class="border border-gray-400"></td>
                                    @if($si === 0)
                                        <td rowspan="4" class="border border-gray-400 text-center align-middle">{{ $fairnessCR }}</td>
                                    @endif
                                    <td class="border border-gray-400 text-right font-bold {{ $crScores[$seg]['color'] }}">{{ $crScores[$seg]['text'] }}</td>
                                    @if($si === 0)
                                        <td rowspan="4" class="border border-gray-400 text-right font-bold align-middle {{ $colorCRTotal }}">{{ $crTotalPct }}</td>
                                    @endif
                                </tr>
                            @endforeach

                            <tr>
                                <td rowspan="{{ $utipRowspan }}" class="border border-gray-400 px-2 py-1 align-top font-semibold">d&nbsp;&nbsp;UTIP</td>
                                <td class="border border-gray-400 px-2 py-1">{{ $utipCorrective['label'] }}</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400 px-2 text-right">{{ $utipCorrective['planRp'] > 0 ? number_format($utipCorrective['planRp'], 0, ',', '.') : '' }}</td>
                                <td class="border border-gray-400 px-2 text-right">{{ $utipCorrective['commitRp'] > 0 ? number_format($utipCorrective['commitRp'], 0, ',', '.') : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $utipCorrective['realRp'] > 0 ? number_format($utipCorrective['realRp'], 0, ',', '.') : '' }}</td>
                                <td rowspan="{{ $utipRowspan }}" class="border border-gray-400 text-center align-middle">{{ $fairnessUTIP }}</td>
                                <td class="border border-gray-400 text-right font-bold {{ $colorAchCorrective }}">{{ $achCorrective }}</td>
                                <td rowspan="{{ $utipRowspan }}" class="border border-gray-400 text-right font-bold align-middle {{ $colorScoreUTIP }}">{{ $scoreUTIP }}</td>
                            </tr>

                            @foreach($newUtipPeriodes as $utip)
                                @php
                                    $achU      = $utip['commitRp'] == 0 ? '-' : number_format(($utip['realRp'] / $utip['commitRp']) * 100, 1) . '%';
                                    $colorAchU = getColorClass($achU, $fairnessUTIP);
                                @endphp
                                <tr>
                                    <td class="border border-gray-400 px-2 py-1">{{ $utip['label'] }}</td>
                                    <td class="border border-gray-400 text-center">Rp</td>
                                    <td class="border border-gray-400 px-2 text-right">{{ $utip['planRp'] > 0 ? number_format($utip['planRp'], 0, ',', '.') : '' }}</td>
                                    <td class="border border-gray-400 px-2 text-right">{{ $utip['commitRp'] > 0 ? number_format($utip['commitRp'], 0, ',', '.') : '' }}</td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 px-2 text-right">{{ $utip['realRp'] > 0 ? number_format($utip['realRp'], 0, ',', '.') : '' }}</td>
                                    <td class="border border-gray-400 text-right font-bold {{ $colorAchU }}">{{ $achU }}</td>
                                </tr>
                            @endforeach

                            <tr class="border-b-2 border-black font-bold">
                                <td class="border border-gray-400 text-center">3</td>
                                <td colspan="10" class="border border-gray-400 px-2 py-1 uppercase bg-gray-50">Combat The Churn</td>
                            </tr>

                            @foreach($ct0Data as $ri => $region)
                                <tr>
                                    @if($ri === 0)
                                        <td rowspan="{{ $ctcSectionRows }}" class="border border-gray-400"></td>
                                    @endif

                                    @if($ri === 0)
                                        <td rowspan="{{ $ct0RowCount }}" class="border border-gray-400 px-2 py-1 align-top font-semibold">
                                            a&nbsp;&nbsp;Paid Pra CT0
                                        </td>
                                    @endif

                                    <td class="border border-gray-400 px-2 py-1">{{ $region['label'] }}</td>
                                    <td class="border border-gray-400 text-center">Rp</td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 px-2 text-right">
                                        {{ $region['commit'] > 0 ? number_format($region['commit'], 1) : '' }}
                                    </td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 px-2 text-right">
                                        {{ $region['real'] > 0 ? number_format($region['real'], 1) : '' }}
                                    </td>

                                    @if($ri === 0)
                                        <td rowspan="{{ $ct0RowCount }}" class="border border-gray-400 text-center align-middle">{{ $fairnessCt0 }}</td>
                                    @endif

                                    <td class="border border-gray-400 text-right font-bold {{ $region['achColor'] }}">
                                        {{ $region['ach'] }}
                                    </td>

                                    @if($ri === 0)
                                        <td rowspan="{{ $ct0RowCount }}" class="border border-gray-400 text-right font-bold align-middle {{ $ct0ScoreColor }}">
                                            {{ $ct0Score }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                            <tr>
                                <td rowspan="{{ $ctcRowCount }}" class="border border-gray-400 px-2 py-1 align-top font-semibold">
                                    b&nbsp;&nbsp;CTC
                                </td>
                                <td class="border border-gray-400 px-2 py-1">CT0</td>
                                <td class="border border-gray-400 text-center">ssl</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right font-semibold">
                                    {{ $ctcCt0Real > 0 ? number_format($ctcCt0Real, 0) : '' }}
                                </td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td colspan="2" class="border border-gray-400"></td>
                            </tr>

                            @foreach(['Sales HSI (all)', 'Churn', 'Winback'] as $seg)
                                <tr>
                                    <td class="border border-gray-400 px-2 py-1">{{ $seg }}</td>
                                    <td class="border border-gray-400 text-center">ssl</td>
                                    <td class="border border-gray-400 px-2 text-right">
                                        {{ $ctcData[$seg]['commit'] > 0 ? number_format($ctcData[$seg]['commit'], 0) : '' }}
                                    </td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 px-2 text-right font-semibold">
                                        {{ $ctcData[$seg]['real'] > 0 ? number_format($ctcData[$seg]['real'], 0) : '' }}
                                    </td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 text-center">{{ $fairnessCtc }}</td>
                                    <td colspan="2" class="border border-gray-400 text-right font-bold {{ $ctcData[$seg]['achColor'] }}">
                                        {{ $ctcData[$seg]['ach'] }}
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="border border-gray-400 px-2 py-1">Loss Rate</td>
                                <td class="border border-gray-400 text-center">%</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right font-semibold">{{ $lossRateReal }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">{{ $fairnessLoss }}</td>
                                <td colspan="2" class="border border-gray-400 text-right font-bold {{ $lossRateColor }}">
                                    {{ $lossRateAch }}
                                </td>
                            </tr>

                            @php
                                $fairnessRs  = '0-100';
                                $fairnessB4  = '0-70';

                                $b1ScoreColor = getColorClass($b1Score, $fairnessRs);
                                $b2ScoreColor = getColorClass($b2Score, $fairnessRs);
                                $b3ScoreColor = getColorClass($b3Score, $fairnessRs);
                                $b4ScoreColor = getColorClass($b4Score, $fairnessB4);

                                foreach ($b1Data as $tid => $row) {
                                    $pct = $row['commit'] > 0 ? number_format($row['ratio'], 1) . '%' : '-';
                                    $b1Data[$tid]['realPct']   = $pct;
                                    $b1Data[$tid]['realColor'] = getColorClass($pct, $fairnessRs);
                                }
                                foreach ($b2Data as $tid => $row) {
                                    $pct = $row['commit'] > 0 ? number_format($row['ratio'], 1) . '%' : '-';
                                    $b2Data[$tid]['realPct']   = $pct;
                                    $b2Data[$tid]['realColor'] = getColorClass($pct, $fairnessRs);
                                }

                                $rsSectionRows = count($b1Data) + count($b2Data) + 1 + 2;
                            @endphp

                            <tr class="border-b-2 border-black font-bold">
                                <td class="border border-gray-400 text-center">4</td>
                                <td colspan="10" class="border border-gray-400 px-2 py-1 uppercase bg-gray-50">Rising Star</td>
                            </tr>

                            @foreach($b1Data as $ti => $row)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $rsSectionRows }}" class="border border-gray-400"></td>
                                        <td rowspan="{{ count($b1Data) }}" class="border border-gray-400 px-2 py-1 align-top font-semibold">a&nbsp;&nbsp;Bintang 1</td>
                                    @endif
                                    <td class="border border-gray-400 px-2 py-1">{{ $row['label'] }}</td>
                                    <td class="border border-gray-400 text-center">%</td>
                                    <td class="border border-gray-400 px-2 text-right">{{ $row['commit'] > 0 ? number_format($row['commit'], 0) : '' }}</td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 px-2 text-right font-bold {{ $row['realColor'] }}">
                                        {{ $row['real'] > 0 ? number_format($row['real'], 1) : '' }}
                                    </td>
                                    <td class="border border-gray-400"></td>
                                    @if($loop->first)
                                        <td rowspan="{{ count($b1Data) }}" class="border border-gray-400 text-center align-middle">{{ $fairnessRs }}</td>
                                        <td rowspan="{{ count($b1Data) }}" colspan="2" class="border border-gray-400 text-center font-bold align-middle {{ $b1ScoreColor }}">{{ $b1Score }}</td>
                                    @endif
                                </tr>
                            @endforeach

                            @foreach($b2Data as $ti => $row)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ count($b2Data) }}" class="border border-gray-400 px-2 py-1 align-top font-semibold">b&nbsp;&nbsp;Bintang 2</td>
                                    @endif
                                    <td class="border border-gray-400 px-2 py-1">{{ $row['label'] }}</td>
                                    <td class="border border-gray-400 text-center">%</td>
                                    <td class="border border-gray-400 px-2 text-right">{{ $row['commit'] > 0 ? number_format($row['commit'], 0) : '' }}</td>
                                    <td class="border border-gray-400"></td>
                                    <td class="border border-gray-400 px-2 text-right font-bold {{ $row['realColor'] }}">
                                        {{ $row['real'] > 0 ? number_format($row['real'], 1) : '' }}
                                    </td>
                                    <td class="border border-gray-400"></td>
                                    @if($loop->first)
                                        <td rowspan="{{ count($b2Data) }}" class="border border-gray-400 text-center align-middle">{{ $fairnessRs }}</td>
                                        <td rowspan="{{ count($b2Data) }}" colspan="2" class="border border-gray-400 text-center font-bold align-middle {{ $b2ScoreColor }}">{{ $b2Score }}</td>
                                    @endif
                                </tr>
                            @endforeach

                            <tr>
                                <td class="border border-gray-400 px-2 py-1 font-semibold">c&nbsp;&nbsp;Bintang 3</td>
                                <td class="border border-gray-400 px-2 py-1">Kecukupan LOP</td>
                                <td class="border border-gray-400 text-center">%</td>
                                <td class="border border-gray-400 px-2 text-right">{{ $b3Commit > 0 ? number_format($b3Commit, 0) : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right font-bold {{ $b3ScoreColor }}">
                                    {{ $b3Real > 0 ? number_format($b3Real, 1) : '' }}
                                </td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">{{ $fairnessRs }}</td>
                                <td colspan="2" class="border border-gray-400 text-center font-bold {{ $b3ScoreColor }}">{{ $b3Score }}</td>
                            </tr>

                            <tr>
                                <td rowspan="2" class="border border-gray-400 px-2 py-1 align-top font-semibold">d&nbsp;&nbsp;Bintang 4</td>
                                <td class="border border-gray-400 px-2 py-1">AOSODOMORO 0-3 Bulan</td>
                                <td rowspan="2" class="border border-gray-400 text-center align-middle">%</td>
                                <td class="border border-gray-400 px-2 text-right">{{ $b4Commit7 > 0 ? number_format($b4Commit7, 0) : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $b4Real7 > 0 ? number_format($b4Real7, 1) : '' }}</td>
                                <td rowspan="2" class="border border-gray-400 px-2 text-right align-middle">
                                    {{ $b4RpMillion > 0 ? number_format($b4RpMillion, 1) : '' }}
                                </td>
                                <td rowspan="2" class="border border-gray-400 text-center align-middle">{{ $fairnessB4 }}</td>
                                <td rowspan="2" colspan="2" class="border border-gray-400 text-center font-bold align-middle {{ $b4ScoreColor }}">{{ $b4Score }}</td>
                            </tr>

                            <tr>
                                <td class="border border-gray-400 px-2 py-1">AOSODOMORO &gt;3 Bulan</td>
                                <td class="border border-gray-400 px-2 text-right">{{ $b4Commit8 > 0 ? number_format($b4Commit8, 0) : '' }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $b4Real8 > 0 ? number_format($b4Real8, 1) : '' }}</td>
                            </tr>

                            @php
                                $fairnessPsak = '0-100';
                                $psakSubLabels = ['a','b','c','d'];
                                $psakIndCount  = 6;
                                $psakTotal     = count($psakData);
                                $psakAllRows   = $psakTotal * $psakIndCount;
                            @endphp

                            <tr class="border-b-2 border-black font-bold">
                                <td class="border border-gray-400 text-center">5</td>
                                <td colspan="10" class="border border-gray-400 px-2 py-1 uppercase bg-gray-50">PSAK</td>
                            </tr>

                            @foreach($psakData as $typeKey => $typeData)
                                @php
                                    $subLabel    = $psakSubLabels[array_search($typeKey, array_keys($psakData))];
                                    $scoreColor  = getColorClass($typeData['score'], $fairnessPsak);
                                    $indicators  = array_values($typeData['indicators']);
                                    $indCount    = count($indicators);
                                @endphp

                                @foreach($indicators as $idx => $ind)
                                    @php
                                        $achColor = getColorClass($ind['ach'], $fairnessPsak);
                                        $hasData  = $ind['commSsl'] > 0 || $ind['commRp'] > 0 || $ind['realSsl'] > 0 || $ind['realRp'] > 0;
                                    @endphp
                                    <tr>
                                        @if($loop->parent->first && $idx === 0)
                                            <td rowspan="{{ $psakAllRows }}" class="border border-gray-400"></td>
                                        @endif

                                        @if($idx === 0)
                                            <td rowspan="{{ $indCount }}" class="border border-gray-400 px-2 py-1 align-top font-semibold">
                                                {{ $subLabel }}&nbsp;&nbsp;{{ $typeData['label'] }}
                                            </td>
                                        @endif

                                        <td class="border border-gray-400 px-2 py-1">{{ $ind['label'] }}</td>

                                        <td class="border border-gray-400 text-center text-xs">TIBS</td>

                                        <td class="border border-gray-400 px-2 text-right">
                                            {{ $hasData && $ind['commSsl'] > 0 ? number_format($ind['commSsl'], 0) : ($hasData ? '-' : '') }}
                                        </td>

                                        <td class="border border-gray-400 px-2 text-right">
                                            {{ $ind['commRp'] > 0 ? number_format($ind['commRp'], 0) : ($hasData ? '-' : '') }}
                                        </td>

                                        <td class="border border-gray-400 px-2 text-right">
                                            {{ $hasData && $ind['realSsl'] > 0 ? number_format($ind['realSsl'], 0) : ($hasData ? '-' : '') }}
                                        </td>

                                        <td class="border border-gray-400 px-2 text-right">
                                            {{ $ind['realRp'] > 0 ? number_format($ind['realRp'], 0) : ($hasData ? '-' : '') }}
                                        </td>

                                        @if($loop->parent->first && $idx === 0)
                                            <td rowspan="{{ $psakAllRows }}" class="border border-gray-400 text-center align-middle">{{ $fairnessPsak }}</td>
                                        @endif

                                        <td class="border border-gray-400 px-2 text-right font-bold {{ $achColor }}">
                                            {{ $ind['ach'] }}
                                        </td>

                                        @if($idx === 0)
                                            <td rowspan="{{ $indCount }}" class="border border-gray-400 text-right font-bold align-middle {{ $scoreColor }}">
                                                {{ $typeData['score'] }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ══ KETERANGAN WARNA ══ --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-8 py-5 mt-6 no-print">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Keterangan Warna</h2>
                </div>
                <div class="flex flex-wrap gap-5 text-xs font-semibold">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded bg-green-500"></div>
                        <span class="text-slate-600">≥ 100% — Tercapai</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded bg-yellow-300 border border-slate-200"></div>
                        <span class="text-slate-600">Mendekati target</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded bg-red-500"></div>
                        <span class="text-slate-600">Di bawah target</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 rounded bg-black"></div>
                        <span class="text-slate-600">Jauh di bawah target</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

<style>
    @media print {
        .no-print { display: none !important; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        body, .min-h-screen { background: white !important; margin: 0 !important; padding: 0 !important; }
        .rounded-2xl { border-radius: 0 !important; box-shadow: none !important; border: none !important; }
        .max-w-7xl { max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
        .print-header { display: block !important; text-align: center; margin-bottom: 12px; }
        table { width: 100% !important; font-size: 9px !important; border-collapse: collapse !important; page-break-inside: auto; }
        th, td { padding: 3px 5px !important; border: 1px solid #555 !important; }
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
        .bg-green-500  { background-color: #22c55e !important; color: white !important; }
        .bg-yellow-300 { background-color: #fde047 !important; }
        .bg-red-500    { background-color: #ef4444 !important; color: white !important; }
        .bg-black      { background-color: #000000 !important; color: white !important; }
        .bg-\[#4a7795\] { background-color: #4a7795 !important; color: white !important; }
        .bg-gray-50    { background-color: #f9fafb !important; }
        @page { size: A4 landscape; margin: 10mm 12mm; }
    }
    .print-header { display: none; }
</style>
@endsection
