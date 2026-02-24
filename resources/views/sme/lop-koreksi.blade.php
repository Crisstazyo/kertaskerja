@extends('layouts.app')

@section('title', 'SME - LOP Koreksi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-12">
    <div class="max-w-[98%] mx-auto px-6">
        <!-- Professional Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-6">
                    <a href="{{ route('sme.scalling') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Scalling
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">LOP Koreksi</h1>
                            <span class="px-3 py-1 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-xs font-semibold rounded-full shadow-sm">SME</span>
                        </div>
                        <p class="text-sm text-gray-500">Correction & Adjustment Pipeline</p>
                    </div>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Data Display -->
        @if($latestImport)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="p-8">
                <!-- Last Update Info -->
                @php
                    $lastUpdate = $latestImport->data
                        ->map(fn($row) => $row->funnel?->updated_at)
                        ->filter()
                        ->max();
                @endphp
                @if($lastUpdate)
                <div class="mb-6 bg-gradient-to-r from-pink-50 to-rose-50 border border-pink-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-pink-500 rounded-full p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Terakhir Diupdate</p>
                            <p class="text-xs text-gray-600">{{ $lastUpdate->format('d M Y, H:i:s') }} WIB</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                            <tr>
                                <!-- Original Columns -->
                                <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NO</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">PROJECT</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-pink-50">ID LOP</th>
                                <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">CC</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NIPNAS</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">AM</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-pink-50">Mitra</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Plan Bulan</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Est Nilai BC</th>
                                
                                <!-- Funnel Tracking Columns -->
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border-r border-gray-300">F0</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-purple-600 to-purple-700 border-r border-gray-300">F1</th>
                                <th colspan="7" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-pink-600 to-pink-700 border-r border-gray-300">F2</th>
                                <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-orange-600 to-orange-700 border-r border-gray-300">F3</th>
                                <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-teal-600 to-teal-700 border-r border-gray-300">F4</th>
                                <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-green-600 to-emerald-700 border-r border-gray-300">F5</th>
                                <th colspan="4" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 border-r border-gray-300">DELIVERY</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 border-r border-gray-300">BILLING<br>COMPLETE</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-violet-600 to-violet-700 border-r border-gray-300">NILAI BILL COMP</th>
                                
                                <!-- Update Column -->
                                <th rowspan="2" class="px-4 py-2 text-center font-bold text-gray-700 uppercase tracking-wider bg-amber-50">Update</th>
                            </tr>
                            <tr class="text-xs">
                                <!-- Data columns handled by rowspan above -->
                                <!-- F0 Sub-header (Inisiasi only, no Lead) is handled by rowspan above -->
                                <!-- F1 Sub-header (Tech & Budget) is handled by rowspan above -->
                                <!-- F2 Sub-headers -->
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P0/P1</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P2</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P3</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P4</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">Offering</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P5</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">Proposal</th>
                                <!-- F3 Sub-headers -->
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-orange-50 border-r border-gray-200">P6</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-orange-50 border-r border-gray-200">P7</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-orange-50 border-r border-gray-200">Submit</th>
                                <!-- F4 Sub-header -->
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-teal-50 border-r border-gray-200">Negosiasi</th>
                                <!-- F5 Sub-headers -->
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-green-50 border-r border-gray-200">SK Mitra</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-green-50 border-r border-gray-200">TTD Kontrak</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-green-50 border-r border-gray-200">P8</th>
                                <!-- DELIVERY Sub-headers -->
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-emerald-50 border-r border-gray-200">Kontrak</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-emerald-50 border-r border-gray-200">BAUT/BAST</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-emerald-50 border-r border-gray-200">BASO</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r border-gray-200">Billing</th>
                                <!-- BILLING COMPLETE and NILAI BILL COMP columns handled by rowspan above -->
                                <!-- Action column handled by rowspan above -->
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestImport->data as $row)
                            @php
                                $funnel = $row->funnel;
                                $denganMitra = strtolower(trim($row->mitra ?? '')) === 'dengan mitra';
                                // Skip row TOTAL di body (akan ditampilkan di footer)
                                if (strtoupper(trim($row->no ?? '')) === 'TOTAL') {
                                    continue;
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Original Data -->
                                <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 border-r">{{ $row->no }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->project }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r bg-pink-50 font-medium">{{ $row->id_lop }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->cc }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->nipnas }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->am }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r bg-pink-50 font-semibold">{{ $row->mitra }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r text-center">{{ $row->plan_bulan_billcom_p_2025 }}</td>
                                <td class="px-4 py-2 whitespace-nowrap font-semibold text-gray-900 border-r">{{ $row->est_nilai_bc }}</td>
                                
                                <!-- Funnel Data -->
                                <!-- F0: Inisiasi only (no Lead) -->
                                <td class="px-2 py-2 text-center border-r bg-blue-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-blue-600 cursor-pointer" 
                                           data-field="f0_inisiasi_solusi"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f0_inisiasi_solusi ? 'checked' : '' }}>
                                </td>
                                <!-- F1: Technical & Budget Discussion -->
                                <td class="px-2 py-2 text-center border-r bg-purple-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-purple-600 cursor-pointer" 
                                           data-field="f1_p0_p1"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f1_p0_p1 ? 'checked' : '' }}>
                                </td>
                                <!-- F2: P0/P1, P2, P3, P4, Offering, P5, Proposal -->
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f1_juskeb"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f1_juskeb ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_p2"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_p2 ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f1_bod_dm"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f1_bod_dm ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_evaluasi"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_evaluasi ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_taf"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_taf ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_juskeb"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_juskeb ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_bod_dm"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_bod_dm ? 'checked' : '' }}>
                                </td>
                                <!-- F3: P6, P7, Submit -->
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_p3_1"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f3_p3_1 ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_sph"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f3_sph ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_juskeb"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f3_juskeb ? 'checked' : '' }}>
                                </td>
                                <!-- F4: Negosiasi -->
                                <td class="px-2 py-2 text-center border-r bg-teal-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-teal-600 cursor-pointer" 
                                           data-field="f4_p3_2"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f4_p3_2 ? 'checked' : '' }}>
                                </td>
                                <!-- F5: SK Mitra, TTD Kontrak, P8 -->
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f4_pks"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f4_pks ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f4_bast"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f4_bast ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f5_p4"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f5_p4 ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <!-- DELIVERY: Kontrak, BAUT/BAST, BASO, Billing -->
                                <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-emerald-600 cursor-pointer" 
                                           data-field="f5_p5"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f5_p5 ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <!-- BASO - Ditampilkan untuk semua -->
                                <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-emerald-600 cursor-pointer" 
                                           data-field="delivery_baso"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->delivery_baso ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-emerald-600 cursor-pointer" 
                                           data-field="f5_kontrak_layanan"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f5_kontrak_layanan ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                    @if($denganMitra)
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-emerald-600 cursor-pointer" 
                                           data-field="delivery_billing"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->delivery_billing ? 'checked' : '' }}>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                
                                <!-- BILLING COMPLETE - Ditampilkan untuk semua -->
                                <td class="px-2 py-2 text-center border-r bg-indigo-50">
                                    <input type="checkbox" 
                                           class="billing-checkbox w-4 h-4 text-indigo-600 cursor-pointer" 
                                           data-field="delivery_billing_complete"
                                           data-data-type="koreksi"
                                           data-data-id="{{ $row->id }}"
                                           data-est-nilai="{{ $row->est_nilai_bc }}"
                                           {{ $funnel && $funnel->delivery_billing_complete ? 'checked' : '' }}>
                                </td>
                                
                                <!-- NILAI BILL COMP -->
                                <td class="px-2 py-2 text-center border-r bg-violet-50 nilai-billcomp-cell" data-row-id="{{ $row->id }}">
                                    @if($denganMitra)
                                    <span class="font-semibold text-gray-900">
                                        @php
                                            if ($funnel && $funnel->delivery_billing_complete) {
                                                $nilaiToShow = $funnel->delivery_nilai_billcomp;
                                                if (!$nilaiToShow) {
                                                    // Clean est_nilai_bc from string format
                                                    $cleanValue = str_replace(['.', ','], '', $row->est_nilai_bc ?? '0');
                                                    $nilaiToShow = (int) $cleanValue;
                                                }
                                                echo number_format($nilaiToShow, 0, ',', '.');
                                            } else {
                                                echo '-';
                                            }
                                        @endphp
                                    </span>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                
                                <!-- Update Button -->
                                <td class="px-4 py-2 text-center border-r">
                                    @if($denganMitra)
                                    <button type="button" 
                                            class="update-progress-btn inline-flex items-center gap-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                                            data-row-id="{{ $row->id }}"
                                            data-data-type="koreksi">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Update
                                    </button>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr class="border-t-2 border-pink-500">
                                <td colspan="8" class="px-4 py-4 text-right font-bold text-gray-900 border-r">TOTAL:</td>
                                <td class="px-4 py-4 text-center font-bold text-pink-700 text-lg border-r bg-pink-50">
                                    @php
                                        // Cari row dengan no = "TOTAL"
                                        $totalRow = $latestImport->data->first(function($item) {
                                            return strtoupper(trim($item->no ?? '')) === 'TOTAL';
                                        });
                                        
                                        if ($totalRow) {
                                            // Ambil dari row TOTAL
                                            $totalEstNilai = str_replace(['.', ','], '', $totalRow->est_nilai_bc ?? '0');
                                            $totalEstNilai = (int) $totalEstNilai;
                                        } else {
                                            // Fallback: hitung manual jika tidak ada row TOTAL
                                            $totalEstNilai = $latestImport->data->sum(function($item) {
                                                if (strtoupper(trim($item->no ?? '')) === 'TOTAL') return 0;
                                                $value = str_replace(['.', ','], '', $item->est_nilai_bc ?? '0');
                                                return (int) $value;
                                            });
                                        }
                                    @endphp
                                    {{ number_format($totalEstNilai, 0, ',', '.') }}
                                </td>
                                <td colspan="21" class="border-r"></td>
                                <td class="px-4 py-4 text-center font-bold text-violet-700 text-lg border-r bg-violet-50" id="total-nilai-billcomp">
                                    @php
                                        $totalBillComp = \App\Models\FunnelTracking::where('data_type', 'koreksi')
                                            ->where('delivery_billing_complete', true)
                                            ->whereNotNull('delivery_nilai_billcomp')
                                            ->sum('delivery_nilai_billcomp');
                                    @endphp
                                    <span>{{ number_format($totalBillComp, 0, ',', '.') }}</span>
                                </td>
                                <td class="border-r"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Catatan Funnel Stages -->
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-400 rounded-xl p-6 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-4 text-sm">Catatan Tahapan Funnel</h4>
                            <div class="text-gray-700 text-xs space-y-3 leading-relaxed">
                                <!-- F0 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-blue-200">
                                    <div class="font-semibold text-blue-700 mb-1">F0 - Funnel 0</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Lead</div>
                                        <div>• Inisiasi</div>
                                    </div>
                                </div>
                                
                                <!-- F1 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-purple-200">
                                    <div class="font-semibold text-purple-700 mb-1">F1 - Funnel 1</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Opportunity</div>
                                        <div>• Technical & Budget Discussion</div>
                                    </div>
                                </div>
                                
                                <!-- F2 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-pink-200">
                                    <div class="font-semibold text-pink-700 mb-1">F2 - Funnel 2</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Self Assessment & Management Solution</div>
                                        <div>• P0/P1. Juskeb barang / jasa</div>
                                        <div>• P2. Evaluasi bakal calon mitra</div>
                                        <div>• P3. Permintaan Penawaran Harga</div>
                                        <div>• P4. Rapat Penjelasan</div>
                                        <div>• Offering Harga Mitra</div>
                                        <div>• P5. Evaluasi SPH Mitra</div>
                                        <div>• Proposal Solusi</div>
                                    </div>
                                </div>
                                
                                <!-- F3 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-orange-200">
                                    <div class="font-semibold text-orange-700 mb-1">F3 - Funnel 3</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• P6. Klarifikasi & Negosiasi</div>
                                        <div>• P7. Penetapan Calon Mitra</div>
                                        <div>• Submit proposal penawaran / SPH ke plgn</div>
                                    </div>
                                </div>
                                
                                <!-- F4 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-teal-200">
                                    <div class="font-semibold text-teal-700 mb-1">F4 - Funnel 4</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Negosiasi</div>
                                    </div>
                                </div>
                                
                                <!-- F5 (Delivery) -->
                                <div class="bg-white/70 p-3 rounded-lg border border-green-200">
                                    <div class="font-semibold text-green-700 mb-1">F5 - Delivery</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Surat Kesanggupan Mitra</div>
                                        <div>• Tanda Tangan Kontrak</div>
                                        <div>• P8. Surat Penetapan Mitra</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Admin Notes Section -->
                @if($adminNote)
                <div class="mt-8 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-400 rounded-xl p-6 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-2 text-sm">Administrator Notes</h4>
                            <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $adminNote->note }}</div>
                            <p class="text-xs text-gray-500 mt-3 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Updated {{ $adminNote->updated_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl p-16 text-center border border-gray-200">
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Data Available</h3>
            <p class="text-gray-500">LOP Koreksi data has not been uploaded yet</p>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Number formatting function
    function formatNumber(num) {
        if (!num) return '-';
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    
    // Track pending changes per row
    const pendingChanges = {};
    
    // Handle regular funnel checkboxes - save immediately
    document.querySelectorAll('.funnel-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const rowId = this.dataset.dataId;
            const dataType = this.dataset.dataType;
            const field = this.dataset.field;
            const value = this.checked;
            
            // Visual feedback - yellow background for saving
            this.parentElement.classList.add('bg-yellow-100');
            
            // Save immediately
            saveCheckboxChange(rowId, dataType, field, value, null, this.parentElement);
        });
    });
    
    // Handle billing complete checkbox - save immediately and update NILAI BILL COMP
    document.querySelectorAll('.billing-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const rowId = this.dataset.dataId;
            const dataType = this.dataset.dataType;
            const field = this.dataset.field;
            const value = this.checked;
            let estNilai = this.dataset.estNilai;
            
            // Clean the est_nilai_bc value
            estNilai = estNilai ? estNilai.replace(/[.,]/g, '') : '0';
            
            // Visual feedback - yellow background for saving
            this.parentElement.classList.add('bg-yellow-100');
            
            // Find NILAI BILL COMP cell in the same row
            const row = this.closest('tr');
            const nilaiBillCompCell = row.querySelector('.nilai-billcomp-cell');
            
            if (nilaiBillCompCell) {
                if (value) {
                    // Checked - show EST NILAI BC
                    nilaiBillCompCell.innerHTML = '<span class="text-gray-900 font-medium">' + formatNumber(estNilai) + '</span>';
                } else {
                    // Unchecked - hide value
                    nilaiBillCompCell.innerHTML = '<span class="text-gray-400">-</span>';
                }
            }
            
            // Save immediately
            saveCheckboxChange(rowId, dataType, field, value, estNilai, this.parentElement);
        });
    });
    
    // Handle Update button click
    document.querySelectorAll('.update-progress-btn').forEach(button => {
        button.addEventListener('click', function() {
            const rowId = this.dataset.rowId;
            const dataType = this.dataset.dataType;
            
            // Check if there are pending changes for this row
            if (!pendingChanges[rowId] || Object.keys(pendingChanges[rowId].changes).length === 0) {
                alert('Tidak ada perubahan untuk disimpan');
                return;
            }
            
            // Disable button and show loading
            this.disabled = true;
            this.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
            
            // Save all changes for this row
            saveRowChanges(rowId, dataType, pendingChanges[rowId], this);
        });
    });
    
    // Funnel stage definitions for cascade auto-checking
    const funnelStages = {
        'f0': ['f0_inisiasi_solusi'],
        'f1': ['f1_p0_p1'],
        'f2': ['f1_juskeb', 'f2_p2', 'f1_bod_dm', 'f2_evaluasi', 'f2_taf', 'f2_juskeb', 'f2_bod_dm'],
        'f3': ['f3_p3_1', 'f3_sph', 'f3_juskeb', 'f3_bod_dm'],
        'f4': ['f4_p3_2', 'f4_pks', 'f4_bast'],
        'f5': ['f5_p4', 'f5_p5', 'delivery_baso', 'f5_kontrak_layanan']
    };
    
    // Get stage name from field
    function getStageFromField(field) {
        for (const [stage, fields] of Object.entries(funnelStages)) {
            if (fields.includes(field)) {
                return stage;
            }
        }
        return null;
    }
    
    // Get all fields in stages before the given stage
    function getPreviousStageFields(currentStage) {
        const stageOrder = ['f0', 'f1', 'f2', 'f3', 'f4', 'f5'];
        const currentIndex = stageOrder.indexOf(currentStage);
        
        if (currentIndex <= 0) return [];
        
        let previousFields = [];
        for (let i = 0; i < currentIndex; i++) {
            previousFields = previousFields.concat(funnelStages[stageOrder[i]]);
        }
        return previousFields;
    }
    
    // Auto-check previous stages
    function autoCheckPreviousStages(dataType, dataId, clickedField) {
        const currentStage = getStageFromField(clickedField);
        if (!currentStage) return;
        
        const previousFields = getPreviousStageFields(currentStage);
        
        previousFields.forEach(field => {
            // Find the checkbox for this field in the same row
            const checkbox = document.querySelector(
                `.funnel-checkbox[data-field="${field}"][data-data-id="${dataId}"][data-data-type="${dataType}"]`
            );
            
            if (checkbox && !checkbox.checked) {
                // Check the checkbox visually
                checkbox.checked = true;
                
                // Send AJAX to update in database
                fetch('{{ route("sme.funnel.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        data_type: dataType,
                        data_id: dataId,
                        field: field,
                        value: true
                    })
                })
                .catch(error => console.error('Auto-check error:', error));
            }
        });
    }
    
    function updateFunnelCheckbox(checkbox) {
        const dataType = checkbox.dataset.dataType;
        const dataId = checkbox.dataset.dataId;
        const field = checkbox.dataset.field;
        const value = checkbox.checked;
        
        fetch('{{ route("sme.funnel.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                data_type: dataType,
                data_id: dataId,
                field: field,
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            // Re-enable checkbox
            checkbox.style.opacity = '1';
            checkbox.style.pointerEvents = 'auto';
            
            if (data.success) {
                console.log('✓ Checkbox updated successfully');
                // If checkbox was checked, auto-check all previous stages
                if (value) {
                    autoCheckPreviousStages(dataType, dataId, field);
                }
            } else {
                console.error('Update failed');
                checkbox.checked = !value; // Revert
            }
        })
        .catch(error => {
            // Re-enable checkbox
            checkbox.style.opacity = '1';
            checkbox.style.pointerEvents = 'auto';
            console.error('Error:', error);
            checkbox.checked = !value; // Revert on error
        });
    }
    
    function updateBillingComplete(checkbox) {
        const dataType = checkbox.dataset.dataType;
        const dataId = checkbox.dataset.dataId;
        const field = checkbox.dataset.field;
        const value = checkbox.checked;
        let estNilai = checkbox.dataset.estNilai;
        
        // Clean the est_nilai_bc value - remove dots and commas
        estNilai = estNilai ? estNilai.replace(/[.,]/g, '') : '0';
        
        fetch('{{ route("sme.funnel.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                data_type: dataType,
                data_id: dataId,
                field: field,
                value: value,
                est_nilai_bc: estNilai
            })
        })
        .then(response => response.json())
        .then(data => {
            // Re-enable checkbox
            checkbox.style.opacity = '1';
            checkbox.style.pointerEvents = 'auto';
            
            if (data.success) {
                console.log('✓ Billing complete updated successfully');
                // Update the nilai billcomp cell
                const nilaiCell = document.querySelector(`.nilai-billcomp-cell[data-row-id="${dataId}"] span`);
                if (nilaiCell) {
                    nilaiCell.textContent = value ? formatNumber(data.nilai_billcomp) : '-';
                }
                
                // Update total
                const totalCell = document.getElementById('total-nilai-billcomp');
                if (totalCell) {
                    totalCell.querySelector('span').textContent = data.total;
                }
            } else {
                console.error('Update failed');
                checkbox.checked = !value; // Revert
            }
        })
        .catch(error => {
            // Re-enable checkbox
            checkbox.style.opacity = '1';
            checkbox.style.pointerEvents = 'auto';
            console.error('Error:', error);
            checkbox.checked = !value; // Revert on error
        });
    }
    
    // Save a single checkbox change immediately
    function saveCheckboxChange(rowId, dataType, field, value, estNilaiBc, checkboxContainer) {
        const payload = {
            data_type: dataType,
            data_id: rowId,
            field: field,
            value: value
        };
        
        // Add est_nilai_bc if this is billing_complete
        if (field === 'delivery_billing_complete' && estNilaiBc) {
            payload.est_nilai_bc = estNilaiBc;
        }
        
        fetch('{{ route("sme.funnel.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success - flash green
                checkboxContainer.classList.remove('bg-yellow-100');
                checkboxContainer.classList.add('bg-green-50');
                setTimeout(() => {
                    checkboxContainer.classList.remove('bg-green-50');
                }, 1500);
                
                // Update totals if billing was changed
                if (data.total) {
                    const totalCell = document.getElementById('total-nilai-billcomp');
                    if (totalCell) {
                        totalCell.querySelector('span').textContent = data.total;
                    }
                }
            } else {
                // Failed - revert checkbox and remove yellow
                checkboxContainer.classList.remove('bg-yellow-100');
                const checkbox = checkboxContainer.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !value;
                }
                alert('Gagal menyimpan perubahan. Silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert checkbox and remove yellow
            checkboxContainer.classList.remove('bg-yellow-100');
            const checkbox = checkboxContainer.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.checked = !value;
            }
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }
    
    // Save all changes for a row
    function saveRowChanges(rowId, dataType, rowData, button) {
        const changes = rowData.changes;
        const promises = [];
        
        // Process each change
        for (const [field, value] of Object.entries(changes)) {
            const payload = {
                data_type: dataType,
                data_id: rowId,
                field: field,
                value: value
            };
            
            // Add est_nilai_bc if this is billing_complete
            if (field === 'delivery_billing_complete' && rowData.est_nilai_bc) {
                payload.est_nilai_bc = rowData.est_nilai_bc;
            }
            
            const promise = fetch('{{ route("sme.funnel.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            }).then(response => response.json());
            
            promises.push(promise);
        }
        
        // Wait for all updates to complete
        Promise.all(promises)
            .then(results => {
                // Check if all successful
                const allSuccess = results.every(data => data.success);
                
                if (allSuccess) {
                    // Remove yellow backgrounds
                    document.querySelectorAll(`[data-data-id="${rowId}"]`).forEach(el => {
                        el.parentElement.classList.remove('bg-yellow-100');
                        el.parentElement.classList.add('bg-green-50');
                        setTimeout(() => {
                            el.parentElement.classList.remove('bg-green-50');
                        }, 2000);
                    });
                    
                    // Update totals if billing was changed
                    const billingResult = results.find(r => r.total);
                    if (billingResult) {
                        const totalCell = document.getElementById('total-nilai-billcomp');
                        if (totalCell) {
                            totalCell.querySelector('span').textContent = billingResult.total;
                        }
                        
                        // Update nilai billcomp cell
                        const nilaiCell = document.querySelector(`.nilai-billcomp-cell[data-row-id="${rowId}"] span`);
                        if (nilaiCell && billingResult.nilai_billcomp) {
                            nilaiCell.textContent = formatNumber(billingResult.nilai_billcomp);
                        }
                    }
                    
                    // Clear pending changes
                    delete pendingChanges[rowId];
                    
                    // Show success message
                    button.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Saved!';
                    setTimeout(() => {
                        button.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Update';
                        button.disabled = false;
                    }, 2000);
                    
                    // Refresh page to update timestamp
                    setTimeout(() => {
                        location.reload();
                    }, 2500);
                } else {
                    throw new Error('Some updates failed');
                }
            })
            .catch(error => {
                console.error('Error saving changes:', error);
                alert('Gagal menyimpan perubahan. Silakan coba lagi.');
                button.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Update';
                button.disabled = false;
            });
    }
});
</script>

@endsection
