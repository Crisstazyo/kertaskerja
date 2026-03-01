@extends('layouts.app')

@section('title', ucfirst($roleNormalized) . ' - Scalling LOP ' . $lopTypeDisplay)

@section('content')
@php
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName() ?? '';
    $routePrefix = explode('.', $currentRouteName)[0] ?? ($roleNormalized === 'government' ? 'gov' : $roleNormalized);

    $headers  = ($latestData && is_array($latestData->data) && isset($latestData->data[0]))
                ? $latestData->data[0] : [];
    $dataRows = ($latestData && is_array($latestData->data) && count($latestData->data) > 1)
                ? array_slice($latestData->data, 1) : [];

    $colorMap = [
        'on-hand'   => ['badge' => 'ON-HAND',   'text' => 'text-emerald-700', 'bg' => 'bg-emerald-50',  'border' => 'border-emerald-200'],
        'qualified' => ['badge' => 'QUALIFIED',  'text' => 'text-purple-700',  'bg' => 'bg-purple-50',   'border' => 'border-purple-200'],
        'koreksi'   => ['badge' => 'KOREKSI',    'text' => 'text-orange-700',  'bg' => 'bg-orange-50',   'border' => 'border-orange-200'],
        'initiate'  => ['badge' => 'INITIATE',   'text' => 'text-blue-700',    'bg' => 'bg-blue-50',     'border' => 'border-blue-200'],
    ];
    $clr = $colorMap[$lopType] ?? $colorMap['on-hand'];

    $totalEstNilai = 0;
    foreach ($dataRows as $r) {
        $rawNilai = trim($r[8] ?? '');
        if (strtoupper($rawNilai) !== 'TOTAL' && $rawNilai !== '') {
            $cleaned = preg_replace('/[^0-9]/', '', $rawNilai);
            $totalEstNilai += (int) $cleaned;
        }
    }

    $totalBillComp = (float) \App\Models\TaskProgress::whereHas('task', fn($q) => $q->where('data_type', $dataType))
        ->where('user_id', auth()->id())
        ->whereDate('tanggal', today())
        ->where('delivery_billing_complete', true)
        ->whereNotNull('delivery_nilai_billcomp')
        ->sum('delivery_nilai_billcomp');
@endphp

<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5"
                style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            LOP <span class="text-red-600">{{ $lopTypeDisplay }}</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Scalling {{ strtoupper($roleNormalized) }} Management</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-red-200">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(!$latestData)
        {{-- ══ EMPTY STATE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5"
                style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border: 2px solid #fecdd3;">
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-black text-slate-700 mb-2 uppercase tracking-tight">Data Belum Tersedia</h3>
            <p class="text-sm font-medium text-slate-400">Admin belum mengupload data untuk LOP {{ $lopTypeDisplay }}.</p>
        </div>
        @else

        {{-- ══ META INFO ══ --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Data LOP {{ $lopTypeDisplay }}</h2>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-[10px] font-black tracking-widest {{ $clr['text'] }} {{ $clr['bg'] }} {{ $clr['border'] }} border rounded-md px-3 py-1 uppercase">
                    {{ $clr['badge'] }}
                </span>
                <span class="text-[10px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 uppercase shadow-sm">
                    {{ strtoupper($roleNormalized) }}
                </span>
                @if($latestData->periode)
                <span class="text-[10px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 uppercase shadow-sm">
                    📅 {{ \Carbon\Carbon::parse($latestData->periode)->format('M Y') }}
                </span>
                @endif
                <span class="text-[10px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 shadow-sm">
                    🕐 {{ $latestData->created_at->format('d M Y, H:i') }}
                </span>
            </div>
        </div>

        {{-- ══ TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                        <!-- Row 1 -->
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th rowspan="2" class="px-3 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100">NO</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100">PROJECT</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-emerald-50">ID LOP</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100">CC</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100">NIPNAS</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100">AM</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-emerald-50">MITRA</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100">PLAN BULAN<br>BILLCOMP</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100">EST NILAI BC</th>
                            <!-- Funnel headers -->
                            <th class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-blue-600">F0</th>
                            <th class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-purple-600">F1</th>
                            <th colspan="7" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-pink-600">F2</th>
                            <th colspan="3" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-orange-500">F3</th>
                            <th class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-teal-600">F4</th>
                            <th colspan="3" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-green-600">F5</th>
                            <th colspan="3" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-emerald-700">DELIVERY</th>
                            <th rowspan="2" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-indigo-600">BILLING<br>COMPLETE</th>
                            <th rowspan="2" class="px-3 py-2 text-center text-[10px] font-black text-white bg-violet-600 min-w-[100px]">NILAI<br>BILL COMP</th>
                        </tr>
                        <!-- Row 2 sub-headers -->
                        <tr class="border-b border-slate-200">
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-blue-700 bg-blue-50 border-r border-slate-100">Inisiasi</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-purple-700 bg-purple-50 border-r border-slate-100">Tech &amp; Budget</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-pink-700 bg-pink-50 border-r border-slate-100">P0/P1</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-pink-700 bg-pink-50 border-r border-slate-100">P2</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-pink-700 bg-pink-50 border-r border-slate-100">P3</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-pink-700 bg-pink-50 border-r border-slate-100">P4</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-pink-700 bg-pink-50 border-r border-slate-100">Offering</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-pink-700 bg-pink-50 border-r border-slate-100">P5</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-pink-700 bg-pink-50 border-r border-slate-100">Proposal</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-orange-700 bg-orange-50 border-r border-slate-100">P6</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-orange-700 bg-orange-50 border-r border-slate-100">P7</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-orange-700 bg-orange-50 border-r border-slate-100">Submit</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-teal-700 bg-teal-50 border-r border-slate-100">Negosiasi</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-green-700 bg-green-50 border-r border-slate-100">SK Mitra</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-green-700 bg-green-50 border-r border-slate-100">TTD Kontrak</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-green-700 bg-green-50 border-r border-slate-100">P8</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-emerald-700 bg-emerald-50 border-r border-slate-100">Kontrak</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-emerald-700 bg-emerald-50 border-r border-slate-100">BAUT/BAST</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-emerald-700 bg-emerald-50 border-r border-slate-100">BASO</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($dataRows as $i => $row)
                        @php
                            $rowIndex    = $i + 1;
                            $funnel      = $funnelByRow->get($rowIndex);
                            $tp          = $funnel?->todayProgress;
                            $mitraVal    = strtolower(trim($row[6] ?? ''));
                            $denganMitra = $mitraVal === 'dengan mitra';
                            if (strtoupper(trim($row[0] ?? '')) === 'TOTAL') continue;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-3 py-2.5 whitespace-nowrap font-bold text-slate-700 border-r border-slate-100 text-center">{{ $row[0] ?? '' }}</td>
                            <td class="px-3 py-2.5 text-slate-600 border-r border-slate-100 font-medium">{{ $row[1] ?? '' }}</td>
                            <td class="px-3 py-2.5 whitespace-nowrap text-slate-700 border-r border-slate-100 bg-emerald-50 font-bold">{{ $row[2] ?? '' }}</td>
                            <td class="px-3 py-2.5 whitespace-nowrap text-slate-600 border-r border-slate-100">{{ $row[3] ?? '' }}</td>
                            <td class="px-3 py-2.5 whitespace-nowrap text-slate-600 border-r border-slate-100">{{ $row[4] ?? '' }}</td>
                            <td class="px-3 py-2.5 text-slate-600 border-r border-slate-100">{{ $row[5] ?? '' }}</td>
                            <td class="px-3 py-2.5 text-slate-700 border-r border-slate-100 bg-emerald-50 font-semibold">{{ $row[6] ?? '' }}</td>
                            <td class="px-3 py-2.5 whitespace-nowrap text-slate-600 border-r border-slate-100 text-center">{{ $row[7] ?? '' }}</td>
                            <td class="px-3 py-2.5 whitespace-nowrap font-black text-slate-800 border-r border-slate-100">{{ $row[8] ?? '' }}</td>

                            <!-- F0 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-blue-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-blue-600 cursor-pointer rounded"
                                    data-field="f0_inisiasi_solusi" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f0_inisiasi_solusi ? 'checked' : '' }}>
                            </td>
                            <!-- F1 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-purple-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-purple-600 cursor-pointer rounded"
                                    data-field="f1_tech_budget" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f1_tech_budget ? 'checked' : '' }}>
                            </td>
                            <!-- F2: P0/P1 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer rounded"
                                    data-field="f2_p0_p1" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p0_p1 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F2: P2 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer rounded"
                                    data-field="f2_p2" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p2 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F2: P3 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer rounded"
                                    data-field="f2_p3" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p3 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F2: P4 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer rounded"
                                    data-field="f2_p4" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p4 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F2: Offering -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer rounded"
                                    data-field="f2_offering" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_offering ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F2: P5 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer rounded"
                                    data-field="f2_p5" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_p5 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F2: Proposal -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer rounded"
                                    data-field="f2_proposal" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f2_proposal ? 'checked' : '' }}>
                            </td>
                            <!-- F3: P6 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer rounded"
                                    data-field="f3_p6" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f3_p6 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F3: P7 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer rounded"
                                    data-field="f3_p7" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f3_p7 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F3: Submit -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer rounded"
                                    data-field="f3_submit" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f3_submit ? 'checked' : '' }}>
                            </td>
                            <!-- F4: Negosiasi -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-teal-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-teal-600 cursor-pointer rounded"
                                    data-field="f4_negosiasi" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f4_negosiasi ? 'checked' : '' }}>
                            </td>
                            <!-- F5: SK Mitra -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer rounded"
                                    data-field="f5_sk_mitra" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f5_sk_mitra ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- F5: TTD Kontrak -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer rounded"
                                    data-field="f5_ttd_kontrak" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f5_ttd_kontrak ? 'checked' : '' }}>
                            </td>
                            <!-- F5: P8 -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer rounded"
                                    data-field="f5_p8" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->f5_p8 ? 'checked' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            <!-- DELIVERY: Kontrak -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-emerald-600 cursor-pointer rounded"
                                    data-field="delivery_kontrak" data-data-type="{{ $dataType }}" data-data-id="{{ $rowIndex }}"
                                    {{ $tp && $tp->delivery_kontrak ? 'checked' : '' }}>
                            </td>
                            <!-- DELIVERY: BAUT/BAST -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                <span class="text-xs font-bold {{ $funnel && $funnel->delivery_baut_bast ? 'text-emerald-700' : 'text-slate-300' }}">
                                    {{ $funnel && $funnel->delivery_baut_bast ? $funnel->delivery_baut_bast : '—' }}
                                </span>
                            </td>
                            <!-- DELIVERY: BASO -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                <span class="text-xs font-bold {{ $funnel && $funnel->delivery_baso ? 'text-emerald-700' : 'text-slate-300' }}">
                                    {{ $funnel && $funnel->delivery_baso ? $funnel->delivery_baso : '—' }}
                                </span>
                            </td>
                            <!-- BILLING COMPLETE -->
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-indigo-50">
                                <input type="checkbox" class="billing-checkbox w-4 h-4 text-indigo-600 cursor-pointer rounded"
                                    data-field="delivery_billing_complete"
                                    data-data-type="{{ $dataType }}"
                                    data-data-id="{{ $rowIndex }}"
                                    data-est-nilai="{{ preg_replace('/[^0-9]/', '', $row[8] ?? '0') }}"
                                    {{ $tp && $tp->delivery_billing_complete ? 'checked' : '' }}>
                            </td>
                            <!-- NILAI BILL COMP -->
                            <td class="px-2 py-2.5 text-center bg-violet-50 nilai-billcomp-cell" data-row-id="{{ $rowIndex }}">
                                <span class="font-black text-slate-800">
                                    @if($tp && $tp->delivery_billing_complete)
                                        {{ number_format((float)($tp->delivery_nilai_billcomp ?? 0), 0, ',', '.') }}
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-red-200 bg-slate-50">
                            <td colspan="8" class="px-4 py-3 text-right text-xs font-black text-slate-700 uppercase tracking-widest border-r border-slate-100">TOTAL</td>
                            <td class="px-4 py-3 text-center font-black text-emerald-700 border-r border-slate-100 bg-emerald-50">
                                {{ number_format($totalEstNilai, 0, ',', '.') }}
                            </td>
                            <td colspan="20" class="border-r border-slate-100"></td>
                            <td class="px-4 py-3 text-center font-black text-violet-700 bg-violet-50" id="total-nilai-billcomp">
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
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    const URL  = '{{ route($routePrefix . ".scalling.funnel.update") }}';

    function formatNum(n) {
        if (!n) return '—';
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
                const nilaicell = document.querySelector(`.nilai-billcomp-cell[data-row-id="${rowId}"] span`);
                if (nilaicell) {
                    nilaicell.textContent = this.checked ? formatNum(data.delivery_nilai_billcomp) : '—';
                }
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
