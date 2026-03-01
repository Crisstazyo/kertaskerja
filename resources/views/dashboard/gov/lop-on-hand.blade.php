@extends('layouts.app')

@section('title', 'Government - LOP On Hand')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-12">
    <div class="max-w-[98%] mx-auto px-6">
        <!-- Professional Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-6">
                    <a href="{{ route('dashboard.gov') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Scalling
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">LOP On Hand</h1>
                            <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-xs font-semibold rounded-full shadow-sm">GOVERNMENT</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Data Display -->
        {{-- periode selector --}}
        @if(isset($periodOptions) && count($periodOptions))
            <form method="GET" class="mb-4 inline-block">
                <label for="periode" class="mr-2 text-sm font-medium text-gray-700">Periode:</label>
                <select id="periode" name="periode" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm text-sm">
                    @foreach($periodOptions as $p)
                        <option value="{{ $p }}" {{ $p === $currentPeriode ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->format('F Y') }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="hidden">Go</button>
            </form>
        @endif

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
                <div class="mb-6 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-emerald-500 rounded-full p-2">
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
                                <!-- Original Columns with rowspan -->
                                <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NO</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">PROJECT</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-emerald-50">ID LOP</th>
                                <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">CC</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">AM</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-emerald-50">Mitra</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Plan Bulan</th>
                                <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Est Nilai BC</th>
                                
                                <!-- Funnel Tracking Columns -->
                                <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border-r border-gray-300">F0</th>
                                <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-purple-600 to-purple-700 border-r border-gray-300">F1</th>
                                <th colspan="7" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-pink-600 to-pink-700 border-r border-gray-300">F2</th>
                                <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-orange-600 to-orange-700 border-r border-gray-300">F3</th>
                                <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-teal-600 to-teal-700 border-r border-gray-300">F4</th>
                                <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-green-600 to-emerald-700 border-r border-gray-300">F5</th>
                                <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 border-r border-gray-300">DELIVERY</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 border-r border-gray-300">BILLING<br>COMPLETE</th>
                                <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-violet-600 to-violet-700">NILAI BILL COMP</th>
                            </tr>
                            <tr class="text-xs">
                                <!-- Data columns handled by rowspan above -->
                                <!-- F0 Sub-header -->
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-blue-50 border-r border-gray-200">Inisiasi</th>
                                <!-- F1 Sub-headers -->
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-purple-50 border-r border-gray-200">Tech & Budget</th>
                                <!-- F2 Sub-headers -->
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P0/P1</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P2</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P3</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P4</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">Offering</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">P5</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r border-gray-200">Proposal</th>
                                <!-- F3 Sub-headers -->
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r border-gray-200">P6</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r border-gray-200">P7</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r border-gray-200">Submit</th>
                                <!-- F4 Sub-header -->
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-teal-50 border-r border-gray-200">Negosiasi</th>
                                <!-- F5 Sub-headers -->
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r border-gray-200">SK Mitra</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r border-gray-200">TTD Kontrak</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r border-gray-200">P8</th>
                                <!-- DELIVERY Sub-headers -->
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r border-gray-200">Kontrak</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r border-gray-200">BAUT/BAST</th>
                                <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r border-gray-200">BASO</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestImport->data as $row)
                            @php
                                $funnel = $row->funnel;
                                $denganMitra = strtolower(trim($row->mitra ?? '')) === 'dengan mitra';
                                // helper values for checkbox state
                                $master = $funnel;                     // master record
                                $today  = $funnel?->todayProgress;     // today's progress
                                $checked = fn($field) =>
                                    ($master && ($master->{$field} ?? false)) ||
                                    ($today  && ($today->{$field} ?? false));

                                // Skip row TOTAL di body (akan ditampilkan di footer)
                                if (strtoupper(trim($row->no ?? '')) === 'TOTAL') {
                                    continue;
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Original Data -->
                                <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 border-r">{{ $row->no }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->project }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r bg-emerald-50 font-medium">{{ $row->id_lop }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->cc }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->am }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r bg-emerald-50 font-semibold">{{ $row->mitra }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r text-center">{{ $row->plan_bulan_billcom_p_2025 }}</td>
                                <td class="px-4 py-2 whitespace-nowrap font-semibold text-gray-900 border-r">{{ $row->est_nilai_bc }}</td>
                                
                                <!-- F0: Inisiasi only -->
                                <td class="px-2 py-2 text-center border-r bg-blue-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-blue-600 cursor-pointer" 
                                           data-field="f0_inisiasi_solusi"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f0_inisiasi_solusi') ? 'checked' : '' }}>
                                </td>
                                <!-- F1: Technical & Budget Discussion -->
                                <td class="px-2 py-2 text-center border-r bg-purple-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-purple-600 cursor-pointer" 
                                           data-field="f1_tech_budget"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f1_tech_budget') ? 'checked' : '' }}>
                                </td>
                                <!-- F2: P0/P1, P2, P3, P4, Offering, P5, Proposal -->
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_p0_p1"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f2_p0_p1') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-pink-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_p2"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f2_p2') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-pink-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_p3"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f2_p3') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-pink-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_p4"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f2_p4') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-pink-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_offering"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f2_offering') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-pink-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_p5"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f2_p5') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-pink-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                <!-- F2: Proposal - Ditampilkan untuk semua -->
                                <td class="px-2 py-2 text-center border-r bg-pink-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-pink-600 cursor-pointer" 
                                           data-field="f2_proposal"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f2_proposal') ? 'checked' : '' }}>
                                </td>
                                <!-- F3: P6, P7, Submit -->
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_p6"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f3_p6') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-orange-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_p7"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f3_p7') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-orange-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                <!-- F3: Submit - Ditampilkan untuk semua -->
                                <td class="px-2 py-2 text-center border-r bg-orange-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-orange-600 cursor-pointer" 
                                           data-field="f3_submit"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f3_submit') ? 'checked' : '' }}>
                                </td>
                                <!-- F4: Negosiasi - Ditampilkan untuk semua -->
                                <td class="px-2 py-2 text-center border-r bg-teal-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-teal-600 cursor-pointer" 
                                           data-field="f4_negosiasi"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f4_negosiasi') ? 'checked' : '' }}>
                                </td>
                                
                                <!-- F5: SK Mitra, TTD Kontrak, P8 -->
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f5_sk_mitra"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f5_sk_mitra') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-green-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                <!-- F5: TTD Kontrak - Ditampilkan untuk semua -->
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f5_ttd_kontrak"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f5_ttd_kontrak') ? 'checked' : '' }}>
                                </td>
                                
                                @if($denganMitra)
                                <td class="px-2 py-2 text-center border-r bg-green-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-green-600 cursor-pointer" 
                                           data-field="f5_p8"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('f5_p8') ? 'checked' : '' }}>
                                </td>
                                @else
                                <td class="px-2 py-2 text-center border-r bg-green-50"><span class="text-gray-300">-</span></td>
                                @endif
                                
                                <!-- DELIVERY: Kontrak, BAUT/BAST (text), BASO (text) -->
                                <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                    <input type="checkbox" 
                                           class="funnel-checkbox w-4 h-4 text-emerald-600 cursor-pointer" 
                                           data-field="delivery_kontrak"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           {{ $checked('delivery_kontrak') ? 'checked' : '' }}>
                                </td>
                                
                                <!-- BAUT/BAST - Display text value -->
                                <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                    <span class="text-xs {{ $funnel && $funnel->delivery_baut_bast ? 'text-emerald-700 font-semibold' : 'text-gray-400' }}">
                                        {{ $funnel && $funnel->delivery_baut_bast ? $funnel->delivery_baut_bast : '-' }}
                                    </span>
                                </td>
                                
                                <!-- BASO - Display text value -->
                                <td class="px-2 py-2 text-center border-r bg-emerald-50">
                                    <span class="text-xs {{ $funnel && $funnel->delivery_baso ? 'text-emerald-700 font-semibold' : 'text-gray-400' }}">
                                        {{ $funnel && $funnel->delivery_baso ? $funnel->delivery_baso : '-' }}
                                    </span>
                                </td>
                                
                                <!-- BILLING COMPLETE - Ditampilkan untuk semua -->
                                <td class="px-2 py-2 text-center border-r bg-indigo-50">
                                    <input type="checkbox" 
                                           class="billing-checkbox w-4 h-4 text-indigo-600 cursor-pointer" 
                                           data-field="delivery_billing_complete"
                                           data-data-type="on_hand"
                                           data-data-id="{{ $row->id }}"
                                           data-est-nilai="{{ $row->est_nilai_bc }}"
                                           {{ $checked('delivery_billing_complete') ? 'checked' : '' }}>
                                </td>
                                
                                <!-- NILAI BILL COMP -->
                                
                                <td class="px-2 py-2 text-center border-r bg-violet-50 nilai-billcomp-cell" data-row-id="{{ $row->id }}">
                                    <span class="font-semibold text-gray-900">
                                        @php
                                            $todayProgress = $funnel ? $funnel->todayProgress : null;
                                            $masterChecked  = $master && $master->delivery_billing_complete;

                                            if (($todayProgress && $todayProgress->delivery_billing_complete) || $masterChecked) {
                                                // prefer todayProgress value, fallback to master
                                                $nilaiToShow = $todayProgress->delivery_nilai_billcomp ?? ($masterChecked ? $master->delivery_nilai_billcomp : null);
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
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr class="border-t-2 border-emerald-500">
                                <td colspan="7" class="px-4 py-4 text-right font-bold text-gray-900 border-r">TOTAL:</td>
                                <td class="px-4 py-4 text-center font-bold text-emerald-700 text-lg border-r bg-emerald-50">
                                    @php
                                        // Cari row dengan no = "TOTAL"
                                        $totalRow = $latestImport->data->first(function($item) {
                                            return strtoupper(trim($item->no ?? '')) === 'TOTAL';
                                        });
                                        
                                        if ($totalRow) {
                                            // Ambil dari row TOTAL (sudah numeric)
                                            $totalEstNilai = floatval($totalRow->est_nilai_bc ?? 0);
                                        } else {
                                            // Fallback: jumlahkan semua est_nilai_bc kecuali TOTAL
                                            $totalEstNilai = $latestImport->data->reduce(function($carry, $item) {
                                                if (strtoupper(trim($item->no ?? '')) === 'TOTAL') return $carry;
                                                return $carry + floatval($item->est_nilai_bc ?? 0);
                                            }, 0);
                                        }
                                    @endphp
                                    {{ number_format($totalEstNilai, 0, ',', '.') }}
                                </td>
                                <td colspan="20" class="border-r"></td>
                                <td class="px-4 py-4 text-center font-bold text-violet-700 text-lg border-r bg-violet-50" id="total-nilai-billcomp">
                                    @php
                                        // Calculate total from task_progress table (today's progress for current user)
                                        $totalBillComp = \App\Models\TaskProgress::whereHas('task', function($query) {
                                                $query->where('data_type', 'on_hand');
                                            })
                                            ->where('user_id', auth()->id())
                                            ->whereDate('tanggal', today())
                                            ->where('delivery_billing_complete', true)
                                            ->whereNotNull('delivery_nilai_billcomp')
                                            ->sum('delivery_nilai_billcomp');
                                        $totalBillComp = (float) $totalBillComp;
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
                                    <div class="font-semibold text-blue-700 mb-1">F0</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Inisiasi</div>
                                    </div>
                                </div>
                                
                                <!-- F1 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-purple-200">
                                    <div class="font-semibold text-purple-700 mb-1">F1</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Technical & Budget Discussion</div>
                                    </div>
                                </div>
                                
                                <!-- F2 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-pink-200">
                                    <div class="font-semibold text-pink-700 mb-1">F2</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
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
                                    <div class="font-semibold text-orange-700 mb-1">F3</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• P6. Klarifikasi & Negosiasi</div>
                                        <div>• P7. Penetapan Calon Mitra</div>
                                        <div>• Submit proposal penawaran / SPH ke plgn</div>
                                    </div>
                                </div>
                                
                                <!-- F4 -->
                                <div class="bg-white/70 p-3 rounded-lg border border-teal-200">
                                    <div class="font-semibold text-teal-700 mb-1">F4</div>
                                    <div class="ml-3 space-y-0.5 text-gray-600">
                                        <div>• Negosiasi</div>
                                    </div>
                                </div>
                                
                                <!-- F5 (Delivery) -->
                                <div class="bg-white/70 p-3 rounded-lg border border-green-200">
                                    <div class="font-semibold text-green-700 mb-1">F5</div>
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
            <p class="text-gray-500">LOP On Hand data has not been uploaded yet</p>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfTokenMeta) {
        console.error('❌ CSRF token meta tag not found! AJAX requests will fail.');
        console.error('Please add this to your layout <head>: <meta name="csrf-token" content="{{ csrf_token() }}">');
        return;
    }
    
    const csrfToken = csrfTokenMeta.getAttribute('content');
    console.log('✅ CSRF token loaded:', csrfToken ? 'YES' : 'NO');
    
    // Number formatting function
    function formatNumber(num) {
        if (!num) return '-';
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    
    // Check if checkboxes are found
    const funnelCheckboxes = document.querySelectorAll('.funnel-checkbox');
    const billingCheckboxes = document.querySelectorAll('.billing-checkbox');
    console.log(`✅ Found ${funnelCheckboxes.length} funnel checkboxes`);
    console.log(`✅ Found ${billingCheckboxes.length} billing checkboxes`);
    
    // Handle regular funnel checkboxes - save immediately
    funnelCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const rowId = this.dataset.dataId;
            const dataType = this.dataset.dataType;
            const field = this.dataset.field;
            const value = this.checked;
            
            console.log('🔵 Funnel checkbox changed:', { rowId, dataType, field, value });
            
            // Visual feedback - yellow background for saving
            this.parentElement.classList.add('bg-yellow-100');
            
            // Save immediately
            saveCheckboxChange(rowId, dataType, field, value, null, this.parentElement);
        });
    });
    
    // Handle billing complete checkbox - save immediately and update NILAI BILL COMP
    billingCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const rowId = this.dataset.dataId;
            const dataType = this.dataset.dataType;
            const field = this.dataset.field;
            const value = this.checked;
            // the attribute already contains a plain numeric value (no thousands separators)
            let estNilai = this.dataset.estNilai || '0';
            console.log('🟣 Billing checkbox changed:', { rowId, dataType, field, value, estNilai });
            
            // Visual feedback - yellow background for saving
            this.parentElement.classList.add('bg-yellow-100');
            
            // Save immediately - UI will be updated from server response
            saveCheckboxChange(rowId, dataType, field, value, estNilai, this.parentElement);
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
                fetch('{{ route("funnel.update") }}', {
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
        
        fetch('{{ route("funnel.update") }}', {
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
        
        // no further cleaning required; pass the raw number string through
        estNilai = estNilai ? estNilai : '0';
        
        fetch('{{ route("funnel.update") }}', {
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

                // automatically mirror sibling fields according to server instructions
                if (data.auto_fields && data.auto_fields.length) {
                    const fields = Array.isArray(data.auto_fields) ? data.auto_fields : [data.auto_fields];
                    const targetVal = data.auto_value === true || data.auto_value === 'true';
                    fields.forEach(fld => {
                        const sibling = document.querySelector(
                            `.funnel-checkbox[data-field="${fld}"][data-data-id="${dataId}"][data-data-type="${dataType}"]`
                        );
                        if (sibling && sibling.checked !== targetVal) {
                            sibling.checked = targetVal;
                            saveCheckboxChange(dataId, dataType, fld, targetVal, null, sibling.parentElement);
                        }
                    });
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
        
        // Add est_nilai_bc if this is billing_complete (always send, even if unchecked)
        if (field === 'delivery_billing_complete') {
            payload.est_nilai_bc = estNilaiBc || '0';
        }
        
        console.log('📤 Sending request:', payload);
        
        fetch('{{ route("funnel.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            console.log('📥 Response status:', response.status, response.statusText);
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('📥 Response data:', data);
            
            if (data.success) {
                console.log('✅ Save successful!');
                
                // Success - flash green
                checkboxContainer.classList.remove('bg-yellow-100');
                checkboxContainer.classList.add('bg-green-50');
                setTimeout(() => {
                    checkboxContainer.classList.remove('bg-green-50');
                }, 1500);
                
                // Note: User info is saved to database but not displayed to users
                // Only admin can see who updated what in admin dashboard
                
                // Update NILAI BILL COMP cell if this was a billing complete checkbox
                if (field === 'delivery_billing_complete') {
                    const row = checkboxContainer.closest('tr');
                    const nilaiBillCompCell = row.querySelector('.nilai-billcomp-cell');
                    
                    if (nilaiBillCompCell) {
                        if (value && data.nilai_billcomp) {
                            // Checked - show nilai from server
                            const formattedValue = formatNumber(data.nilai_billcomp);
                            console.log('💰 Updating Nilai Bill Comp:', formattedValue);
                            nilaiBillCompCell.innerHTML = '<span class="font-semibold text-gray-900">' + 
                                formattedValue + '</span>';
                        } else {
                            // Unchecked - hide value
                            console.log('💰 Hiding Nilai Bill Comp');
                            nilaiBillCompCell.innerHTML = '<span class="text-gray-400">-</span>';
                        }
                    }
                }

                // auto-toggle siblings according to server instruction
                if (data.auto_fields && data.auto_fields.length) {
                    const fields = Array.isArray(data.auto_fields) ? data.auto_fields : [data.auto_fields];
                    const targetVal = data.auto_value === true || data.auto_value === 'true';
                    const rowId = checkboxContainer.closest('tr').querySelector('input').dataset.dataId;
                    const rowType = checkboxContainer.closest('tr').querySelector('input').dataset.dataType;
                    fields.forEach(fld => {
                        const sibling = document.querySelector(
                            `.funnel-checkbox[data-field="${fld}"][data-data-id="${rowId}"][data-data-type="${rowType}"]`
                        );
                        if (sibling && sibling.checked !== targetVal) {
                            sibling.checked = targetVal;
                            saveCheckboxChange(rowId, rowType, fld, targetVal, null, sibling.parentElement);
                        }
                    });
                }
                
                // Update totals if billing was changed
                if (data.total) {
                    const totalCell = document.getElementById('total-nilai-billcomp');
                    if (totalCell) {
                        console.log('💵 Updating total:', data.total);
                        totalCell.querySelector('span').textContent = data.total;
                    }
                }
            } else {
                console.error('❌ Save failed:', data);
                // Failed - flash red and revert checkbox
                checkboxContainer.classList.remove('bg-yellow-100');
                checkboxContainer.classList.add('bg-red-50');
                setTimeout(() => {
                    checkboxContainer.classList.remove('bg-red-50');
                }, 1500);
                
                const checkbox = checkboxContainer.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !value;
                }
                alert('Gagal menyimpan perubahan: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('❌ Network/Parse error:', error);
            // Revert checkbox and flash red
            checkboxContainer.classList.remove('bg-yellow-100');
            checkboxContainer.classList.add('bg-red-50');
            setTimeout(() => {
                checkboxContainer.classList.remove('bg-red-50');
            }, 1500);
            
            const checkbox = checkboxContainer.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.checked = !value;
            }
            alert('Gagal menyimpan perubahan. Silakan coba lagi. Error: ' + error.message);
        });
    }
});
</script>

@endsection
