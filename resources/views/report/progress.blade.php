@extends('layouts.app')

@section('title', 'Progress')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut — Admin</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            Progress <span class="text-red-600">{{ $typeLabel }}</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">{{ $segmentLabel }} — Scaling Management System</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    {{-- Back ke halaman upload admin --}}
                    <a href="{{ route('admin.scalling.' . $segment . '.' . str_replace('/', '-', $type === 'on-hand' ? 'on-hand' : $type)) }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-slate-900 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm uppercase tracking-wider group">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back</span>
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

        @if($import)

        @php $isReadOnly = false; @endphp

        {{-- ══ VIEW ONLY BANNER (kalau inactive) ══ --}}
        @if($isReadOnly)
        <div class="flex items-center space-x-3 bg-amber-50 border border-amber-200 text-amber-800 px-5 py-3.5 mb-6 rounded-xl">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <div>
                <p class="text-sm font-black uppercase tracking-wide">File Inactive — Mode View Only</p>
                <p class="text-xs font-medium mt-0.5">File ini sedang dinonaktifkan. Aktifkan kembali di halaman upload untuk mengizinkan pengeditan.</p>
            </div>
        </div>
        @endif

        {{-- ══ META INFO ══ --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Progress Data</h2>
            </div>
            <div class="flex items-center space-x-3">
                {{-- Periode selector --}}
                @if(count($periodOptions))
                <form method="GET" class="flex items-center">
                    <div class="relative">
                        <select name="periode" onchange="this.form.submit()"
                            class="appearance-none text-xs font-bold text-slate-700 bg-white border-2 border-slate-200 hover:border-red-400 rounded-lg pl-3 pr-8 py-1.5 shadow-sm focus:outline-none focus:border-red-400 cursor-pointer transition-colors">
                            @foreach($periodOptions as $p)
                                <option value="{{ $p }}" {{ $p === $currentPeriode ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->format('F Y') }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </form>
                @endif

                <span class="text-[12px] font-black tracking-widest text-red-700 bg-red-50 border border-red-200 rounded-md px-3 py-1 uppercase">
                    {{ strtoupper(str_replace('-', ' ', $type)) }}
                </span>
                <span class="text-[12px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 uppercase shadow-sm">
                    {{ strtoupper($segmentLabel) }}
                </span>
                @if($isReadOnly)
                <span class="text-[12px] font-black tracking-widest text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-3 py-1 uppercase">
                    🔒 Locked
                </span>
                @else
                <span class="text-[12px] font-black tracking-widest text-green-700 bg-green-50 border border-green-200 rounded-md px-3 py-1 uppercase">
                    ✏️ Editable
                </span>
                @endif

                @php
                    $lastUpdate = $dataRows
                        ->map(fn($row) => $funnelMap->get($row->id)?->updated_at)
                        ->filter()
                        ->max();
                @endphp
                @if($lastUpdate)
                <span class="text-[12px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 shadow-sm">
                    🕐 {{ \Carbon\Carbon::parse($lastUpdate)->format('d M Y, H:i') }}
                </span>
                @endif
            </div>
        </div>

        {{-- ══ TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead>
                        <tr>
                            <th rowspan="2" class="px-3 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-slate-50">NO</th>
                            <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-slate-50">PROJECT</th>
                            <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-emerald-50">ID LOP</th>
                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-slate-50">CC</th>
                            <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-slate-50">AM</th>
                            <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-emerald-50">Mitra</th>
                            <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-slate-50">Plan Bulan</th>
                            <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest border-r border-slate-100 bg-slate-50">Est Nilai BC</th>
                            <th class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-blue-600">F0</th>
                            <th class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-purple-600">F1</th>
                            <th colspan="7" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-pink-600">F2</th>
                            <th colspan="3" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-orange-500">F3</th>
                            <th class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-teal-600">F4</th>
                            <th colspan="3" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-green-600">F5</th>
                            <th colspan="3" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-emerald-700">DELIVERY</th>
                            <th rowspan="2" class="px-3 py-2 text-center text-[10px] font-black text-white border-r border-slate-100 bg-indigo-600">BILLING<br>COMPLETE</th>
                            <th rowspan="2" class="px-3 py-2 text-center text-[10px] font-black text-white bg-violet-600 min-w-[100px]">NILAI BILL COMP</th>
                        </tr>
                        <tr class="border-b border-slate-200">
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-blue-700 bg-blue-50 border-r border-slate-100">Inisiasi</th>
                            <th class="px-2 py-1.5 text-center text-[10px] font-black text-purple-700 bg-purple-50 border-r border-slate-100">Tech & Budget</th>
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
                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach($dataRows as $row)
                        @php
                            $funnel      = $funnelMap->get($row->id);
                            $denganMitra = strtolower(trim($row->mitra ?? '')) === 'dengan mitra';
                            $checked     = fn($field) => $funnel && ($funnel->{$field} ?? false);
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-3 py-2.5 whitespace-nowrap font-bold text-slate-700 border-r border-slate-100 text-center">{{ $row->no }}</td>
                            <td class="px-4 py-2.5 text-slate-600 border-r border-slate-100 font-medium">{{ $row->project }}</td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-slate-700 border-r border-slate-100 bg-emerald-50 font-bold">{{ $row->id_lop }}</td>
                            <td class="px-3 py-2.5 whitespace-nowrap text-slate-600 border-r border-slate-100">{{ $row->cc }}</td>
                            <td class="px-4 py-2.5 text-slate-600 border-r border-slate-100">{{ $row->am }}</td>
                            <td class="px-4 py-2.5 text-slate-700 border-r border-slate-100 bg-emerald-50 font-semibold">{{ $row->mitra }}</td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-slate-600 border-r border-slate-100 text-center">{{ $row->plan_bulan_billcom_p_2025 }}</td>
                            <td class="px-4 py-2.5 whitespace-nowrap font-black text-slate-800 border-r border-slate-100">{{ $row->est_nilai_bc }}</td>

                            {{-- F0 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-blue-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-blue-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f0_inisiasi_solusi" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f0_inisiasi_solusi') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- F1 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-purple-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-purple-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f1_tech_budget" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f1_tech_budget') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- F2 P0/P1 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f2_p0_p1" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f2_p0_p1') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F2 P2 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f2_p2" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f2_p2') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F2 P3 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f2_p3" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f2_p3') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F2 P4 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f2_p4" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f2_p4') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F2 Offering --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f2_offering" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f2_offering') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F2 P5 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f2_p5" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f2_p5') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F2 Proposal --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-pink-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f2_proposal" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f2_proposal') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- F3 P6 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f3_p6" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f3_p6') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F3 P7 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f3_p7" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f3_p7') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F3 Submit --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-orange-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f3_submit" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f3_submit') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- F4 Negosiasi --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-teal-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-teal-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f4_negosiasi" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f4_negosiasi') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- F5 SK Mitra --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f5_sk_mitra" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f5_sk_mitra') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- F5 TTD Kontrak --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f5_ttd_kontrak" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f5_ttd_kontrak') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- F5 P8 --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-green-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="f5_p8" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('f5_p8') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- DELIVERY Kontrak --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-emerald-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="delivery_kontrak" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    {{ $checked('delivery_kontrak') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- DELIVERY BAUT/BAST --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-emerald-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="delivery_baut_bast" data-data-type="koreksi" data-data-id="{{ $row->id }}"
                                    {{ $checked('delivery_baut_bast') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- DELIVERY BASO --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                @if($denganMitra)
                                <input type="checkbox" class="funnel-checkbox w-4 h-4 text-emerald-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="delivery_baso" data-data-type="koreksi" data-data-id="{{ $row->id }}"
                                    {{ $checked('delivery_baso') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                                @else<span class="text-slate-300 font-bold">—</span>@endif
                            </td>
                            {{-- BILLING COMPLETE --}}
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-indigo-50">
                                <input type="checkbox" class="billing-checkbox w-4 h-4 text-indigo-600 rounded {{ $isReadOnly ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                                    data-field="delivery_billing_complete" data-data-type="on_hand" data-data-id="{{ $row->id }}"
                                    data-est-nilai="{{ $row->est_nilai_bc }}"
                                    {{ $checked('delivery_billing_complete') ? 'checked' : '' }}
                                    {{ $isReadOnly ? 'disabled' : '' }}>
                            </td>
                            {{-- NILAI BILL COMP --}}
                            <td class="px-2 py-2.5 text-center bg-violet-50 nilai-billcomp-cell" data-row-id="{{ $row->id }}">
                                <span class="font-black text-slate-800">
                                    @php
                                        $masterChecked = $funnel && $funnel->delivery_billing_complete;
                                        if ($masterChecked) {
                                            $nilaiToShow = $funnel->delivery_nilai_billcomp;
                                            if (!$nilaiToShow) {
                                                $cleanValue = str_replace(['.', ','], '', $row->est_nilai_bc ?? '0');
                                                $nilaiToShow = (int) $cleanValue;
                                            }
                                            echo number_format($nilaiToShow, 0, ',', '.');
                                        } else {
                                            echo '<span class="text-slate-300">—</span>';
                                        }
                                    @endphp
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-red-200 bg-slate-50">
                            <td colspan="7" class="px-4 py-3 text-right text-xs font-black text-slate-700 uppercase tracking-widest border-r border-slate-100">TOTAL:</td>
                            <td class="px-4 py-3 text-center font-black text-emerald-700 border-r border-slate-100 bg-emerald-50">
                                {{ number_format($dataRows->sum(fn($r) => floatval($r->est_nilai_bc ?? 0)), 0, ',', '.') }}
                            </td>
                            <td colspan="20" class="border-r border-slate-100"></td>
                            <td class="px-4 py-3 text-center font-black text-violet-700 bg-violet-50" id="total-nilai-billcomp">
                                @php
                                    $totalBillComp = $funnelMap->filter(fn($f) => $f && $f->delivery_billing_complete)
                                        ->sum(function($f) use ($dataRows) {
                                            $nilai = $f->delivery_nilai_billcomp;
                                            if (!$nilai) {
                                                $row = $dataRows->firstWhere('id', $f->data_id);
                                                $clean = str_replace(['.', ','], '', $row->est_nilai_bc ?? '0');
                                                $nilai = (float) $clean;
                                            }
                                            return (float) $nilai;
                                        });
                                @endphp
                                <span>{{ number_format($totalBillComp, 0, ',', '.') }}</span>
                            </td>
                            <td class="border-r border-slate-100"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @else
        {{-- ══ EMPTY STATE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5"
                style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border: 2px solid #fecdd3;">
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-black text-slate-700 mb-2 uppercase tracking-tight">Data Belum Tersedia</h3>
            <p class="text-sm font-medium text-slate-400">Belum ada data untuk periode ini.</p>
        </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const isReadOnly = false;
    if (isReadOnly) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) return;

    function formatNumber(num) {
        if (!num) return '-';
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.querySelectorAll('.funnel-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            this.parentElement.classList.add('bg-yellow-100');
            saveChange(this.dataset.dataId, this.dataset.dataType, this.dataset.field, this.checked, null, this.parentElement);
        });
    });

    document.querySelectorAll('.billing-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            this.parentElement.classList.add('bg-yellow-100');
            saveChange(this.dataset.dataId, this.dataset.dataType, this.dataset.field, this.checked, this.dataset.estNilai || '0', this.parentElement);
        });
    });

    function saveChange(rowId, dataType, field, value, estNilaiBc, container) {
        const payload = { data_type: dataType, data_id: rowId, field: field, value: value };
        if (field === 'delivery_billing_complete') payload.est_nilai_bc = estNilaiBc || '0';

        // Gunakan route funnel update sesuai segment
        const updateUrl = '{{ route("admin.progress.funnel.update", ["segment" => $segment, "type" => $type]) }}';

        fetch(updateUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(r => { if (!r.ok) throw new Error(r.status); return r.json(); })
        .then(data => {
            if (data.success) {
                container.classList.remove('bg-yellow-100');
                container.classList.add('bg-green-50');
                setTimeout(() => container.classList.remove('bg-green-50'), 1500);

                if (field === 'delivery_billing_complete') {
                    const row = container.closest('tr');
                    const nilaiCell = row?.querySelector('.nilai-billcomp-cell');
                    if (nilaiCell) {
                        nilaiCell.innerHTML = value && data.nilai_billcomp
                            ? '<span class="font-black text-slate-800">' + formatNumber(data.nilai_billcomp) + '</span>'
                            : '<span class="text-slate-300">—</span>';
                    }
                }
                if (data.total) {
                    const totalCell = document.getElementById('total-nilai-billcomp');
                    if (totalCell) totalCell.querySelector('span').textContent = data.total;
                }
            } else {
                container.classList.remove('bg-yellow-100');
                container.classList.add('bg-red-50');
                setTimeout(() => container.classList.remove('bg-red-50'), 1500);
                const cb = container.querySelector('input[type="checkbox"]');
                if (cb) cb.checked = !value;
                alert('Gagal menyimpan: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(err => {
            container.classList.remove('bg-yellow-100');
            container.classList.add('bg-red-50');
            setTimeout(() => container.classList.remove('bg-red-50'), 1500);
            const cb = container.querySelector('input[type="checkbox"]');
            if (cb) cb.checked = !value;
            alert('Error: ' + err.message);
        });
    }
});
</script>
@endsection
