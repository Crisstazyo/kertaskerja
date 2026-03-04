@extends('layouts.app')

@section('title', 'Detail — ' . $typeLabel . ' ' . $segmentLabel)

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
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
                            Detail <span class="text-red-600">Scalling</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">
                            {{ $segmentLabel }} — {{ $typeLabel }} — {{ $periodeLabel }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ url()->previous() }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Data Funnel</h2>
            </div>
            <div class="flex items-center space-x-3 flex-wrap gap-2">
                <span class="text-[11px] font-black tracking-widest uppercase px-3 py-1 rounded-md border
                    @if($segment === 'gov')     bg-blue-50   border-blue-200   text-blue-700
                    @elseif($segment === 'private') bg-purple-50 border-purple-200 text-purple-700
                    @elseif($segment === 'soe')    bg-orange-50 border-orange-200 text-orange-700
                    @else                          bg-green-50  border-green-200  text-green-700
                    @endif">
                    {{ $segmentLabel }}
                </span>
                <span class="text-[11px] font-black tracking-widest uppercase px-3 py-1 rounded-md border bg-slate-50 border-slate-200 text-slate-600">
                    {{ $typeLabel }}
                </span>
                <span class="text-[11px] font-black tracking-widest uppercase px-3 py-1 rounded-md border bg-red-50 border-red-200 text-red-700">
                    {{ $periodeLabel }}
                </span>

                <!-- @if(count($periodOptions) > 1)
                <form method="GET" action="{{ route('report.detail', ['segment' => $segment, 'type' => $type]) }}" class="flex items-center">
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
                @endif -->

                <span class="text-[11px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 shadow-sm">
                    {{ $dataRows->count() }} LOP
                </span>
            </div>
        </div>

        @if($import && $dataRows->count())

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">
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
                            $funnel = $funnelMap[$row->id] ?? null;
                            $denganMitra = strtolower(trim($row->mitra ?? '')) === 'dengan mitra';
                            $val = fn($field) => $funnel && $funnel->{$field};
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

                            @php
                                $check = function($checked, $bg = 'bg-slate-50') use ($val) {
                                    return $checked
                                        ? '<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500"><svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></span>'
                                        : '<span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-100"><span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span></span>';
                                };
                                $dash = '<span class="text-slate-300 font-bold text-sm">—</span>';
                            @endphp

                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-blue-50">
                                {!! $check($val('f0_inisiasi_solusi')) !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-purple-50">
                                {!! $check($val('f1_tech_budget')) !!}
                            </td>

                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                {!! $denganMitra ? $check($val('f2_p0_p1')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                {!! $denganMitra ? $check($val('f2_p2')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                {!! $denganMitra ? $check($val('f2_p3')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                {!! $denganMitra ? $check($val('f2_p4')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                {!! $denganMitra ? $check($val('f2_offering')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                {!! $denganMitra ? $check($val('f2_p5')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-pink-50">
                                {!! $check($val('f2_proposal')) !!}
                            </td>

                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                {!! $denganMitra ? $check($val('f3_p6')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                {!! $denganMitra ? $check($val('f3_p7')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-orange-50">
                                {!! $check($val('f3_submit')) !!}
                            </td>

                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-teal-50">
                                {!! $check($val('f4_negosiasi')) !!}
                            </td>

                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                {!! $denganMitra ? $check($val('f5_sk_mitra')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                {!! $check($val('f5_ttd_kontrak')) !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-green-50">
                                {!! $denganMitra ? $check($val('f5_p8')) : $dash !!}
                            </td>

                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                {!! $check($val('delivery_kontrak')) !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                {!! $denganMitra ? $check($val('delivery_baut_bast')) : $dash !!}
                            </td>
                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-emerald-50">
                                {!! $denganMitra ? $check($val('delivery_baso')) : $dash !!}
                            </td>

                            <td class="px-2 py-2.5 text-center border-r border-slate-100 bg-indigo-50">
                                {!! $check($val('delivery_billing_complete')) !!}
                            </td>

                            <td class="px-2 py-2.5 text-center bg-violet-50">
                                @if($funnel && $funnel->delivery_billing_complete)
                                    @php
                                        $nilaiToShow = $funnel->delivery_nilai_billcomp;
                                        if (!$nilaiToShow) {
                                            $cleanValue = str_replace(['.', ','], '', $row->est_nilai_bc ?? '0');
                                            $nilaiToShow = (int) $cleanValue;
                                        }
                                    @endphp
                                    <span class="font-black text-slate-800">{{ number_format($nilaiToShow, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-red-200 bg-slate-50">
                            <td colspan="7" class="px-4 py-3 text-right text-xs font-black text-slate-700 uppercase tracking-widest border-r border-slate-100">TOTAL:</td>
                            <td class="px-4 py-3 text-center font-black text-emerald-700 border-r border-slate-100 bg-emerald-50">
                                {{ number_format(
                                    $dataRows->sum(function ($r) {
                                        $value = $r->est_nilai_bc ?? '0';

                                        // Jika format Indonesia (ada koma sebagai desimal)
                                        if (str_contains($value, ',')) {
                                            $value = str_replace('.', '', $value); // hapus ribuan
                                            $value = str_replace(',', '.', $value); // ubah desimal
                                        }

                                        return floatval($value);
                                    }),
                                0, ',', '.') }}
                            </td>
                            <td colspan="20" class="border-r border-slate-100"></td>
                            <td class="px-4 py-3 text-center font-black text-violet-700 bg-violet-50">
                                {{ number_format(
                                    $funnelMap
                                        ->where('delivery_billing_complete', true)
                                        ->sum('delivery_nilai_billcomp'),
                                0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @php
                $totalLop      = $dataRows->count();
                $totalBillComp = $funnelMap->filter(fn($f) => $f && $f->delivery_billing_complete)->count();
                $totalDelivery = $funnelMap->filter(fn($f) => $f && $f->delivery_kontrak)->count();
                $totalF5       = $funnelMap->filter(fn($f) => $f && $f->f5_ttd_kontrak)->count();
                $pctBillComp   = $totalLop > 0 ? round(($totalBillComp / $totalLop) * 100) : 0;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-5">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total LOP</p>
                <p class="text-3xl font-black text-slate-900">{{ $totalLop }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-5">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">TTD Kontrak (F5)</p>
                <p class="text-3xl font-black text-green-600">{{ $totalF5 }}</p>
                <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $totalLop > 0 ? round(($totalF5/$totalLop)*100) : 0 }}% dari total LOP</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-5">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Delivery Kontrak</p>
                <p class="text-3xl font-black text-emerald-600">{{ $totalDelivery }}</p>
                <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $totalLop > 0 ? round(($totalDelivery/$totalLop)*100) : 0 }}% dari total LOP</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-5">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Billing Complete</p>
                <p class="text-3xl font-black text-indigo-600">{{ $totalBillComp }}</p>
                <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $pctBillComp }}% dari total LOP</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h4 class="font-black text-slate-900 text-sm uppercase tracking-wide">Catatan Tahapan Funnel</h4>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 text-xs">
                <div class="bg-blue-50 border border-blue-200 p-3 rounded-xl">
                    <div class="font-black text-blue-700 mb-1.5">F0</div>
                    <div class="text-slate-600 space-y-0.5"><div>• Inisiasi</div></div>
                </div>
                <div class="bg-purple-50 border border-purple-200 p-3 rounded-xl">
                    <div class="font-black text-purple-700 mb-1.5">F1</div>
                    <div class="text-slate-600 space-y-0.5"><div>• Technical & Budget Discussion</div></div>
                </div>
                <div class="bg-pink-50 border border-pink-200 p-3 rounded-xl">
                    <div class="font-black text-pink-700 mb-1.5">F2</div>
                    <div class="text-slate-600 space-y-0.5">
                        <div>• P0/P1. Juskeb barang / jasa</div>
                        <div>• P2. Evaluasi bakal calon mitra</div>
                        <div>• P3. Permintaan Penawaran Harga</div>
                        <div>• P4. Rapat Penjelasan</div>
                        <div>• Offering Harga Mitra</div>
                        <div>• P5. Evaluasi SPH Mitra</div>
                        <div>• Proposal Solusi</div>
                    </div>
                </div>
                <div class="bg-orange-50 border border-orange-200 p-3 rounded-xl">
                    <div class="font-black text-orange-700 mb-1.5">F3</div>
                    <div class="text-slate-600 space-y-0.5">
                        <div>• P6. Klarifikasi & Negosiasi</div>
                        <div>• P7. Penetapan Calon Mitra</div>
                        <div>• Submit proposal penawaran</div>
                    </div>
                </div>
                <div class="bg-teal-50 border border-teal-200 p-3 rounded-xl">
                    <div class="font-black text-teal-700 mb-1.5">F4</div>
                    <div class="text-slate-600 space-y-0.5"><div>• Negosiasi</div></div>
                </div>
                <div class="bg-green-50 border border-green-200 p-3 rounded-xl">
                    <div class="font-black text-green-700 mb-1.5">F5</div>
                    <div class="text-slate-600 space-y-0.5">
                        <div>• Surat Kesanggupan Mitra</div>
                        <div>• Tanda Tangan Kontrak</div>
                        <div>• P8. Surat Penetapan Mitra</div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5"
                style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border: 2px solid #fecdd3;">
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-black text-slate-700 mb-2 uppercase tracking-tight">Data Belum Tersedia</h3>
            <p class="text-sm font-medium text-slate-400">Tidak ada data untuk periode ini</p>
        </div>
        @endif

    </div>
</div>
@endsection
