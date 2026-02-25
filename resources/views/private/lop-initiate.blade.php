@extends('layouts.app')

@section('title', 'Private - LOP Initiate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-12">
    <div class="max-w-[98%] mx-auto px-6">
        <!-- Professional Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-6">
                    <a href="{{ route('private.dashboard') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Dashboard
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">LOP Initiate</h1>
                            <span class="px-3 py-1 bg-gradient-to-r from-orange-500 to-amber-600 text-white text-xs font-semibold rounded-full shadow-sm">Private</span>
                        </div>
                        <p class="text-sm text-gray-500">Initiated Lead Opportunity Pipeline</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Data Display -->
        @if($data && $data->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="p-8">

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                            <tr>
                                <!-- Original Columns -->
                                <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NO</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">PROJECT</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-orange-50">ID LOP</th>
                                <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">CC</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NIPNAS</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">AM</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-orange-50">Mitra</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Plan Bulan</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Est Nilai BC</th>
                                
                                <!-- Funnel Tracking Columns -->
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border-r border-gray-300">F0</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-purple-600 to-purple-700 border-r border-gray-300">F1</th>
                                <th colspan="7" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-pink-600 to-pink-700 border-r border-gray-300">F2</th>
                                <th colspan="4" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-orange-600 to-orange-700 border-r border-gray-300">F3</th>
                                <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-teal-600 to-teal-700 border-r border-gray-300">F4</th>
                                <th colspan="4" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-green-600 to-emerald-700 border-r border-gray-300">DELIVERY</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 border-r border-gray-300">BILLING<br>COMPLETE</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-violet-600 to-violet-700 border-r border-gray-300">NILAI BILL COMP</th>
                                
                                <!-- Action Column -->
                                <th rowspan="2" class="px-4 py-2 text-center font-bold text-gray-700 uppercase tracking-wider bg-amber-50">Action</th>
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
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-orange-50 border-r border-gray-200">Negosiasi</th>
                                <!-- F4 Sub-headers -->
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-teal-50 border-r border-gray-200">SK Mitra</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-teal-50 border-r border-gray-200">TTD Kontrak</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-teal-50 border-r border-gray-200">P8</th>
                                <!-- DELIVERY Sub-headers -->
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-green-50 border-r border-gray-200">Kontrak</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-green-50 border-r border-gray-200">BAUT/BAST</th>
                                <th class="px-2 py-1 text-center text-xs font-semibold text-gray-700 bg-green-50 border-r border-gray-200">BASO</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r border-gray-200">Billing</th>
                                <!-- BILLING COMPLETE and NILAI BILL COMP columns handled by rowspan above -->
                                <!-- Action column handled by rowspan above -->
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $row)
                            @php
                                $funnel = $row->funnel;
                                $denganMitra = strtolower(trim($row->mitra ?? '')) === 'dengan mitra';
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Original Data -->
                                <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 border-r">{{ $row->no }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->project }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r bg-orange-50 font-medium">{{ $row->id_lop }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->cc }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->nipnas }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->am }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r bg-orange-50 font-semibold">{{ $row->mitra }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r text-center">{{ $row->plan_bulan_billcom_p_2025 }}</td>
                                <td class="px-4 py-2 whitespace-nowrap font-semibold text-gray-900 border-r">{{ $row->est_nilai_bc }}</td>
                                
                                <!-- Funnel Data -->
                                <!-- F0: Inisiasi only (no Lead) -->
                                <td class="px-2 py-2 text-center border-r bg-blue-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-blue-600 cursor-pointer" 
                                           data-field="f0_inisiasi_solusi"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f0_inisiasi_solusi ? 'checked' : '' }}>
                                </td>
                                <!-- F1: Technical & Budget Discussion -->
                                <td class="px-2 py-2 text-center border-r bg-purple-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-purple-600 cursor-pointer" 
                                           data-field="f1_p0_p1"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f1_p0_p1 ? 'checked' : '' }}>
                                </td>
                                <!-- F2: P0/P1, P2, P3, P4, Offering, P5, Proposal -->
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f1_juskeb"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f1_juskeb ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_p2"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_p2 ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f1_bod_dm"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f1_bod_dm ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_evaluasi"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_evaluasi ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_taf"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_taf ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_juskeb"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_juskeb ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_bod_dm"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f2_bod_dm ? 'checked' : '' }}>
                                </td>
                                <!-- F3: P6, P7, Submit, Negosiasi -->
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_p3_1"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f3_p3_1 ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_sph"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f3_sph ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_juskeb"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f3_juskeb ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_bod_dm"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f3_bod_dm ? 'checked' : '' }}>
                                </td>
                                <!-- F4: SK Mitra, TTD Kontrak, P8 -->
                                <td class="px-2 py-2 text-center border-r bg-teal-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-teal-600 cursor-pointer" 
                                           data-field="f4_p3_2"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f4_p3_2 ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-teal-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-teal-600 cursor-pointer" 
                                           data-field="f4_pks"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f4_pks ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-teal-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-teal-600 cursor-pointer" 
                                           data-field="f4_bast"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f4_bast ? 'checked' : '' }}>
                                </td>
                                <!-- DELIVERY: Kontrak, BAUT/BAST, BASO, Billing -->
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f5_p4"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f5_p4 ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f5_p5"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f5_p5 ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="delivery_baso"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->delivery_baso ? 'checked' : '' }}>
                                </td>
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f5_kontrak_layanan"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           {{ $funnel && $funnel->f5_kontrak_layanan ? 'checked' : '' }}>
                                </td>
                                
                                <!-- BILLING COMPLETE -->
                                <td class="px-2 py-2 text-center border-r bg-indigo-50">
                                    <input type="checkbox" 
                                           class="billing-checkbox w-4 h-4 text-indigo-600 cursor-pointer" 
                                           data-field="delivery_billing_complete"
                                           data-data-type="initiate"
                                           data-data-id="{{ $row->id }}"
                                           data-est-nilai="{{ $row->est_nilai_bc }}"
                                           {{ $funnel && $funnel->delivery_billing_complete ? 'checked' : '' }}>
                                </td>
                                
                                <!-- NILAI BILL COMP -->
                                <td class="px-2 py-2 text-center border-r bg-violet-50 nilai-billcomp-cell" data-row-id="{{ $row->id }}">
                                    <span class="font-semibold text-gray-900">
                                        {{ $funnel && $funnel->delivery_billing_complete ? number_format($funnel->delivery_nilai_billcomp ?? $row->est_nilai_bc, 0, ',', '.') : '-' }}
                                    </span>
                                </td>
                                
                                <!-- Action -->
                                <td class="px-4 py-2 text-center border-r">
                                    <a href="{{ route('admin.lop.funnel.show', ['initiate', $row->id]) }}" 
                                       class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all shadow-sm hover:shadow-md">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Update
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr class="border-t-2 border-orange-500">
                                <td colspan="8" class="px-4 py-4 text-right font-bold text-gray-900 border-r">TOTAL:</td>
                                <td class="px-4 py-4 text-center font-bold text-orange-700 text-lg border-r bg-orange-50">
                                    @php
                                        $totalEstNilai = $latestImport->data->sum('est_nilai_bc');
                                    @endphp
                                    {{ number_format($totalEstNilai, 0, ',', '.') }}
                                </td>
                                <td colspan="21" class="border-r"></td>
                                <td class="px-4 py-4 text-center font-bold text-violet-700 text-lg border-r bg-violet-50" id="total-nilai-billcomp">
                                    @php
                                        $totalBillComp = \App\Models\FunnelTracking::where('data_type', 'initiate')
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
            <p class="text-gray-500">LOP Initiate data has not been uploaded yet</p>
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
    
    // Handle regular funnel checkboxes
    document.querySelectorAll('.funnel-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateFunnelCheckbox(this);
        });
    });
    
    // Handle billing complete checkbox
    document.querySelectorAll('.billing-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBillingComplete(this);
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
                fetch('{{ route("private.funnel.update") }}', {
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
        
        fetch('{{ route("private.funnel.update") }}', {
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
            if (data.success) {
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
            console.error('Error:', error);
            checkbox.checked = !value; // Revert on error
        });
    }
    
    function updateBillingComplete(checkbox) {
        const dataType = checkbox.dataset.dataType;
        const dataId = checkbox.dataset.dataId;
        const field = checkbox.dataset.field;
        const value = checkbox.checked;
        const estNilai = checkbox.dataset.estNilai;
        
        fetch('{{ route("private.funnel.update") }}', {
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
            if (data.success) {
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
            console.error('Error:', error);
            checkbox.checked = !value; // Revert on error
        });
    }
});
</script>

@endsection
