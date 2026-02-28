@extends('layouts.app')

@section('title', ucfirst($roleNormalized) . ' - Scalling LOP ' . $lopTypeDisplay)

@section('content')
@php
    // Determine route prefix from current route name
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName() ?? '';
    $routePrefix = explode('.', $currentRouteName)[0] ?? ($roleNormalized === 'government' ? 'gov' : $roleNormalized);

    $headers  = ($latestData && is_array($latestData->data) && isset($latestData->data[0]))
                ? $latestData->data[0] : [];
    $dataRows = ($latestData && is_array($latestData->data) && count($latestData->data) > 1)
                ? array_slice($latestData->data, 1) : [];

    $colorMap = [
        'on-hand'   => ['from' => 'from-emerald-500', 'to' => 'to-teal-600',   'badge' => 'ON-HAND',   'text' => 'text-emerald-600', 'bg' => 'bg-emerald-50',  'border' => 'border-emerald-300'],
        'qualified' => ['from' => 'from-purple-500',  'to' => 'to-fuchsia-600','badge' => 'QUALIFIED', 'text' => 'text-purple-600',  'bg' => 'bg-purple-50',   'border' => 'border-purple-300'],
        'koreksi'   => ['from' => 'from-orange-500',  'to' => 'to-red-600',    'badge' => 'KOREKSI',   'text' => 'text-orange-600',  'bg' => 'bg-orange-50',   'border' => 'border-orange-300'],
        'initiate'  => ['from' => 'from-blue-500',    'to' => 'to-indigo-600', 'badge' => 'INITIATE',  'text' => 'text-blue-600',    'bg' => 'bg-blue-50',     'border' => 'border-blue-300'],
    ];
    $clr = $colorMap[$lopType] ?? $colorMap['on-hand'];

    // Total EST NILAI BC from data rows
    $totalEstNilai = 0;
    foreach ($dataRows as $r) {
        $rawNilai = trim($r[8] ?? '');
        if (strtoupper($rawNilai) !== 'TOTAL' && $rawNilai !== '') {
            $cleaned = preg_replace('/[^0-9]/', '', $rawNilai);
            $totalEstNilai += (int) $cleaned;
        }
    }

    // Total NILAI BILL COMP from TaskProgress today
    $totalBillComp = (float) \App\Models\TaskProgress::whereHas('task', fn($q) => $q->where('data_type', $dataType))
        ->where('user_id', auth()->id())
        ->whereDate('tanggal', today())
        ->where('delivery_billing_complete', true)
        ->whereNotNull('delivery_nilai_billcomp')
        ->sum('delivery_nilai_billcomp');
@endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-10">
    <div class="max-w-[99%] mx-auto px-4">

        {{-- HEADER --}}
        <div class="mb-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-4">
                    <a href="{{ route($routePrefix . '.scalling') }}"
                       class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>Scalling
                    </a>
                    <div class="h-5 w-px bg-gray-300"></div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-gray-900">LOP {{ $lopTypeDisplay }}</h1>
                        <span class="px-3 py-1 bg-gradient-to-r {{ $clr['from'] }} {{ $clr['to'] }} text-white text-xs font-bold rounded-full shadow-sm">{{ $clr['badge'] }}</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase">{{ strtoupper($roleNormalized) }}</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-2 bg-slate-800 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>Logout
                    </button>
                </form>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        @if(!$latestData)
        <div class="bg-white rounded-2xl border border-amber-200 shadow-sm p-14 text-center">
            <div class="w-16 h-16 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mb-2">Data Belum Tersedia</h3>
            <p class="text-sm text-gray-400">Admin belum mengupload data untuk LOP {{ $lopTypeDisplay }}.</p>
        </div>
        @else

        {{-- Upload info --}}
        <div class="flex items-center gap-4 mb-4 text-xs text-gray-400 font-semibold">
            <span>📅 Periode: {{ $latestData->periode ? \Carbon\Carbon::parse($latestData->periode)->format('M Y') : '-' }}</span>
            <span>📄 File: {{ $latestData->file_name }}</span>
            <span>🕐 Upload: {{ $latestData->created_at->format('d M Y, H:i') }}</span>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                        <!-- Row 1 -->
                        <tr>
                            <th rowspan="2" class="px-3 py-2 text-center font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NO</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">PROJECT</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-emerald-50">ID LOP</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">CC</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NIPNAS</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">AM</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-emerald-50">MITRA</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">PLAN BULAN<br>BILLCOMP</th>
                            <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">EST NILAI BC</th>
                            <!-- Funnel columns -->
                            <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border-r border-gray-300">F0</th>
                            <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-purple-600 to-purple-700 border-r border-gray-300">F1</th>
                            <th colspan="7" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-pink-600 to-pink-700 border-r border-gray-300">F2</th>
                            <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-orange-600 to-orange-700 border-r border-gray-300">F3</th>
                            <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-teal-600 to-teal-700 border-r border-gray-300">F4</th>
                            <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-green-600 to-emerald-700 border-r border-gray-300">F5</th>
                            <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 border-r border-gray-300">DELIVERY</th>
                            <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 border-r border-gray-300">BILLING<br>COMPLETE</th>
                            <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-violet-600 to-violet-700 min-w-[100px]">NILAI<br>BILL COMP</th>
                        </tr>
                        <!-- Row 2 sub-headers -->
                        <tr class="text-xs">
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-blue-50 border-r border-gray-200">Inisiasi</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-purple-50 border-r border-gray-200">Tech &amp; Budget</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P0/P1</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P2</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P3</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P4</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">Offering</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P5</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">Proposal</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r border-gray-200">P6</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r border-gray-200">P7</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r border-gray-200">Submit</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-teal-50 border-r border-gray-200">Negosiasi</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r border-gray-200">SK Mitra</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r border-gray-200">TTD Kontrak</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r border-gray-200">P8</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r border-gray-200">Kontrak</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r border-gray-200">BAUT/BAST</th>
                            <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r border-gray-200">BASO</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($dataRows as $i => $row)
                        @php
                            $rowIndex   = $i + 1;
                            $funnel     = $funnelByRow->get($rowIndex);
                            $tp         = $funnel?->todayProgress; // TaskProgress for today / this user
                            $mitraVal   = strtolower(trim($row[6] ?? ''));
                            $denganMitra = $mitraVal === 'dengan mitra';

                            // Skip if NO column says TOTAL
                            if (strtoupper(trim($row[0] ?? '')) === 'TOTAL') continue;
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- 9 data columns -->
                            <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 border-r text-center">{{ $row[0] ?? '' }}</td>
                            <td class="px-3 py-2 text-gray-700 border-r">{{ $row[1] ?? '' }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r bg-emerald-50 font-medium">{{ $row[2] ?? '' }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row[3] ?? '' }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row[4] ?? '' }}</td>
                            <td class="px-3 py-2 text-gray-700 border-r">{{ $row[5] ?? '' }}</td>
                            <td class="px-3 py-2 text-gray-700 border-r bg-emerald-50 font-semibold">{{ $row[6] ?? '' }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r text-center">{{ $row[7] ?? '' }}</td>
                            <td class="px-3 py-2 whitespace-nowrap font-semibold text-gray-900 border-r">{{ $row[8] ?? '' }}</td>

                            <!-- F0: Inisiasi -->
                            <td class="px-2 py-2 text-center border-r bg-blue-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-blue-600 cursor-pointer"
                                    data-field="f0_inisiasi_solusi"
                                    data-data-type="{{ $dataType }}"
                                    data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f0_inisiasi_solusi ? 'checked' : '' }}>
                            </td>

                            <!-- F1: Tech & Budget -->
                            <td class="px-2 py-2 text-center border-r bg-purple-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-purple-600 cursor-pointer"
                                    data-field="f1_tech_budget"
                                    data-data-type="{{ $dataType }}"
                                    data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f1_tech_budget ? 'checked' : '' }}>
                            </td>

                            <!-- F2: P0/P1 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer"
                                    data-field="f2_p0_p1" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p0_p1 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F2: P2 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer"
                                    data-field="f2_p2" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p2 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F2: P3 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer"
                                    data-field="f2_p3" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p3 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F2: P4 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer"
                                    data-field="f2_p4" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p4 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F2: Offering (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer"
                                    data-field="f2_offering" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_offering ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F2: P5 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer"
                                    data-field="f2_p5" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p5 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F2: Proposal (semua) -->
                            <td class="px-2 py-2 text-center border-r bg-pink-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer"
                                    data-field="f2_proposal" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_proposal ? 'checked' : '' }}>
                            </td>

                            <!-- F3: P6 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-orange-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer"
                                    data-field="f3_p6" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f3_p6 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F3: P7 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-orange-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer"
                                    data-field="f3_p7" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f3_p7 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F3: Submit (semua) -->
                            <td class="px-2 py-2 text-center border-r bg-orange-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer"
                                    data-field="f3_submit" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f3_submit ? 'checked' : '' }}>
                            </td>

                            <!-- F4: Negosiasi (semua) -->
                            <td class="px-2 py-2 text-center border-r bg-teal-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-teal-600 cursor-pointer"
                                    data-field="f4_negosiasi" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f4_negosiasi ? 'checked' : '' }}>
                            </td>

                            <!-- F5: SK Mitra (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-green-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer"
                                    data-field="f5_sk_mitra" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f5_sk_mitra ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- F5: TTD Kontrak (semua) -->
                            <td class="px-2 py-2 text-center border-r bg-green-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer"
                                    data-field="f5_ttd_kontrak" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f5_ttd_kontrak ? 'checked' : '' }}>
                            </td>

                            <!-- F5: P8 (dengan mitra only) -->
                            <td class="px-2 py-2 text-center border-r bg-green-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer"
                                    data-field="f5_p8" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f5_p8 ? 'checked' : '' }}>
                                @else<span class="text-gray-300">-</span>@endif
                            </td>

                            <!-- DELIVERY: Kontrak (semua) -->
                            <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-emerald-600 cursor-pointer"
                                    data-field="delivery_kontrak" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->delivery_kontrak ? 'checked' : '' }}>
                            </td>

                            <!-- DELIVERY: BAUT/BAST (text from FunnelTracking) -->
                            <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                <span class="text-xs {{ $funnel && $funnel->delivery_baut_bast ? 'text-emerald-700 font-semibold' : 'text-gray-300' }}">
                                    {{ $funnel && $funnel->delivery_baut_bast ? $funnel->delivery_baut_bast : '-' }}
                                </span>
                            </td>

                            <!-- DELIVERY: BASO (text from FunnelTracking) -->
                            <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                <span class="text-xs {{ $funnel && $funnel->delivery_baso ? 'text-emerald-700 font-semibold' : 'text-gray-300' }}">
                                    {{ $funnel && $funnel->delivery_baso ? $funnel->delivery_baso : '-' }}
                                </span>
                            </td>

                            <!-- BILLING COMPLETE (semua) -->
                            <td class="px-2 py-2 text-center border-r bg-indigo-50">
                                <input type="checkbox" class="billing-checkbox w-4 h-4 text-indigo-600 cursor-pointer"
                                    data-field="delivery_billing_complete"
                                    data-data-type="{{ $dataType }}"
                                    data-data-id="{{ $rowIndex }}"
                                    data-est-nilai="{{ preg_replace('/[^0-9]/', '', $row[8] ?? '0') }}"
                                    {{ $tp && $tp->delivery_billing_complete ? 'checked' : '' }}>
                            </td>

                            <!-- NILAI BILL COMP -->
                            <td class="px-2 py-2 text-center bg-violet-50 nilai-billcomp-cell" data-row-id="{{ $rowIndex }}">
                                <span class="font-semibold text-gray-900">
                                    @if($tp && $tp->delivery_billing_complete)
                                        {{ number_format((float)($tp->delivery_nilai_billcomp ?? 0), 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr class="border-t-2 border-emerald-500">
                            <td colspan="8" class="px-4 py-3 text-right font-bold text-gray-900 border-r">TOTAL:</td>
                            <td class="px-4 py-3 text-center font-bold text-emerald-700 border-r bg-emerald-50">
                                {{ number_format($totalEstNilai, 0, ',', '.') }}
                            </td>
                            <td colspan="20" class="border-r"></td>
                            <td class="px-4 py-3 text-center font-bold text-violet-700 border-r bg-violet-50" id="total-nilai-billcomp">
                                <span>{{ number_format($totalBillComp, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const CSRF  = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    const URL   = '{{ route($routePrefix . ".scalling.funnel.update") }}';

    function formatNum(n) {
        if (!n) return '-';
        return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function sendUpdate(payload, cellEl, onSuccess) {
        if (cellEl) cellEl.classList.add('bg-yellow-100');
        fetch(URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body:    JSON.stringify(payload)
        })
        .then(r => r.json())
        .then(data => {
            if (cellEl) {
                cellEl.classList.remove('bg-yellow-100');
                cellEl.classList.add('bg-green-50');
                setTimeout(() => cellEl.classList.remove('bg-green-50'), 1500);
            }
            if (data.success && typeof onSuccess === 'function') onSuccess(data);
        })
        .catch(err => {
            console.error(err);
            if (cellEl) {
                cellEl.classList.remove('bg-yellow-100');
                cellEl.classList.add('bg-red-50');
                setTimeout(() => cellEl.classList.remove('bg-red-50'), 1500);
            }
        });
    }

    // Regular funnel checkboxes
    document.querySelectorAll('.funnel-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            sendUpdate({
                data_type: this.dataset.dataType,
                data_id:   parseInt(this.dataset.dataId),
                field:     this.dataset.field,
                value:     this.checked,
            }, this.parentElement, null);
        });
    });

    // Billing complete checkboxes
    document.querySelectorAll('.billing-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            const estNilai = this.dataset.estNilai || '0';
            const rowId    = this.dataset.dataId;
            sendUpdate({
                data_type:    this.dataset.dataType,
                data_id:      parseInt(rowId),
                field:        this.dataset.field,
                value:        this.checked,
                est_nilai_bc: estNilai,
            }, this.parentElement, (data) => {
                // Update nilai billcomp cell
                const nilaicell = document.querySelector(`.nilai-billcomp-cell[data-row-id="${rowId}"] span`);
                if (nilaicell) {
                    nilaicell.textContent = this.checked ? formatNum(data.delivery_nilai_billcomp) : '-';
                }
                // Update footer total
                const totalEl = document.querySelector('#total-nilai-billcomp span');
                if (totalEl && data.total !== undefined) {
                    totalEl.textContent = data.total;
                }
            });
        });
    });
});
</script>
@endsection
