@extends('layouts.app')

@section('title', 'Admin - C3MR Management')

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
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            Collection <span class="text-red-600">C3MR</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input komitmen dan realisasi C3MR</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>
                    <button onclick="openProgressModal()"
                        class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Lihat Progress</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ══ FLASH MESSAGE ══ --}}
        @if(session('success'))
        <div class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center space-x-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- ══ TAB NAVIGATION ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="flex border-b border-slate-100">
                <button onclick="switchTab('komitmen')" id="tab-komitmen"
                    class="flex-1 flex items-center justify-center space-x-2 py-4 text-sm font-black uppercase tracking-wider text-red-600 border-b-2 border-red-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Form Komitmen (Bulanan)</span>
                </button>
                <button onclick="switchTab('realisasi')" id="tab-realisasi"
                    class="flex-1 flex items-center justify-center space-x-2 py-4 text-sm font-black uppercase tracking-wider {{ $hasMonthlyCommitment ? 'text-slate-400 hover:text-slate-600' : 'text-slate-300 cursor-not-allowed' }} border-b-2 border-transparent transition-all"
                    {{ !$hasMonthlyCommitment ? 'disabled' : '' }}>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Form Realisasi (Harian)</span>
                </button>
            </div>

            <div class="p-8">

                {{-- ── Komitmen ── --}}
                <div id="content-komitmen" class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                            <div>
                                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Komitmen Bulanan</h2>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Tentukan target ratio C3MR untuk bulan ini.</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">
                            Periode: {{ now()->translatedFormat('F Y') }}
                        </span>
                    </div>

                    @if($hasMonthlyCommitment)
                        <div class="flex items-start space-x-4 bg-amber-50 border border-amber-200 rounded-xl px-5 py-4">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-black text-amber-800">Target Sudah Terkunci</p>
                                <p class="text-xs text-amber-700 mt-0.5">
                                    Anda telah menginput target ratio untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong>. Input baru hanya tersedia di bulan depan.
                                </p>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('admin.collection.c3mr.store') }}" method="POST" class="max-w-md mx-auto space-y-5">
                            @csrf
                            <input type="hidden" name="form_type" value="komitmen">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 text-center">Target Ratio C3MR (%)</label>
                                <div class="relative">
                                    <input type="number" name="ratio" min="0" max="100" step="0.01" value="98" required
                                        class="w-full px-6 py-5 text-4xl font-black text-red-600 border-2 border-slate-200 rounded-xl bg-slate-50 text-center focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                        placeholder="98">
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-black text-2xl">%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-center text-slate-400 font-semibold mt-2">Masukkan target ratio untuk periode ini (default: 98%)</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Keterangan (Opsional)</label>
                                <input type="text" name="keterangan"
                                    class="w-full px-4 py-3 text-sm border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                    placeholder="Catatan tambahan...">
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Simpan Target Bulanan</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                {{-- ── Realisasi ── --}}
                <div id="content-realisasi" class="hidden space-y-6">
                    @if(!$hasMonthlyCommitment)
                        <div class="flex items-start space-x-4 bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H9m3-10a3 3 0 00-3 3v1H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-3V8a3 3 0 00-3-3z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-black text-red-800">Input Realisasi Belum Tersedia</p>
                                <p class="text-xs text-red-700 mt-0.5">
                                    Anda harus menginput <strong>Komitmen Bulanan</strong> terlebih dahulu sebelum dapat menginput realisasi harian.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                                <div>
                                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Realisasi Harian</h2>
                                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Input pencapaian ratio C3MR hari ini.</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-black tracking-widest text-green-700 bg-green-50 border border-green-200 rounded-md px-3 py-1 uppercase">Harian</span>
                        </div>

                        <form action="{{ route('admin.collection.c3mr.store') }}" method="POST" class="max-w-md mx-auto space-y-5">
                            @csrf
                            <input type="hidden" name="form_type" value="realisasi">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 text-center">Realisasi Ratio C3MR (%)</label>
                                <div class="relative">
                                    <input type="number" name="ratio" min="0" max="100" step="0.01" required
                                        class="w-full px-6 py-5 text-4xl font-black text-slate-800 border-2 border-slate-200 rounded-xl bg-slate-50 text-center focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                        placeholder="95.50">
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-black text-2xl">%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-center text-slate-400 font-semibold mt-2">Masukkan realisasi ratio hari ini</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Keterangan (Opsional)</label>
                                <input type="text" name="keterangan"
                                    class="w-full px-4 py-3 text-sm border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                    placeholder="Catatan tambahan...">
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Simpan Realisasi Harian</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>

        {{-- ══ DATA TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">Data C3MR Saya</h3>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total: {{ $data->count() }} data</span>
            </div>

            @if($data->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                            <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Ratio (%)</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan</th>
                            <th class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($data as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                @if($item->type === 'komitmen')
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1 text-red-700 bg-red-50 border border-red-200">Komitmen</span>
                                @else
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1 text-green-700 bg-green-50 border border-green-200">Realisasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-black text-slate-800">{{ number_format($item->ratio, 2) }}%</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $item->keterangan ?? '—' }}</td>
                            <td class="px-6 py-4 text-center text-xs font-semibold text-slate-600">
                                {{ \Carbon\Carbon::create()->month($item->month)->format('F') }} {{ $item->year }}
                            </td>
                            <td class="px-6 py-4 text-center text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-16 text-center">
                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-bold text-slate-400">Belum ada data C3MR</p>
                <p class="text-xs text-slate-300 mt-1">Mulai dengan menginput komitmen bulanan</p>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ══ PROGRESS MODAL ══ --}}
<div id="progressModal" class="hidden fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0,0,0,0.6);">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl max-w-7xl w-full max-h-[90vh] overflow-hidden flex flex-col border border-slate-200">

            {{-- Modal Header --}}
            <div class="px-8 py-6 border-b border-slate-100 relative overflow-hidden flex items-center justify-between">
                <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
                <div class="flex items-center space-x-4">
                    <div class="rounded-xl flex items-center justify-center border-2 flex-shrink-0"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:48px; height:48px;">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight">Progress Data C3MR — Semua User</h2>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5 uppercase tracking-wide">Total: <strong class="text-slate-600">{{ $allData->count() }}</strong> data submission</p>
                    </div>
                </div>
                <button onclick="closeProgressModal()" class="text-slate-300 hover:text-red-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto p-8">
                @if($allData->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                                <th class="px-4 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Ratio (%)</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan</th>
                                <th class="px-4 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                                <th class="px-4 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($allData as $index => $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-xs font-bold text-slate-600">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0"
                                            style="background:#fff1f2; border:1px solid #fecdd3;">
                                            <span class="text-[10px] font-black text-red-600">{{ substr($item->user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-700">{{ $item->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->type === 'komitmen')
                                        <span class="text-xs font-bold rounded-md px-2 py-0.5 text-red-700 bg-red-50 border border-red-200">K</span>
                                    @else
                                        <span class="text-xs font-bold rounded-md px-2 py-0.5 text-green-700 bg-green-50 border border-green-200">R</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-black text-slate-800">{{ number_format($item->ratio, 2) }}%</td>
                                <td class="px-4 py-3 text-xs text-slate-500">{{ $item->keterangan ?? '—' }}</td>
                                <td class="px-4 py-3 text-center text-xs font-semibold text-slate-600">
                                    {{ \Carbon\Carbon::create()->month($item->month)->format('M') }} {{ $item->year }}
                                </td>
                                <td class="px-4 py-3 text-center text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($item->entry_date)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="py-16 text-center">
                    <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-sm font-bold text-slate-400">Belum ada data progress</p>
                    <p class="text-xs text-slate-300 mt-1">Menunggu user mulai menginput data C3MR</p>
                </div>
                @endif
            </div>

            {{-- Modal Footer --}}
            <div class="px-8 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button onclick="closeProgressModal()"
                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    document.getElementById('content-komitmen').classList.add('hidden');
    document.getElementById('content-realisasi').classList.add('hidden');

    document.getElementById('tab-komitmen').classList.remove('text-red-600', 'border-red-600');
    document.getElementById('tab-komitmen').classList.add('text-slate-400', 'border-transparent');
    document.getElementById('tab-realisasi').classList.remove('text-red-600', 'border-red-600');
    document.getElementById('tab-realisasi').classList.add('text-slate-400', 'border-transparent');

    if (tabName === 'komitmen') {
        document.getElementById('content-komitmen').classList.remove('hidden');
        document.getElementById('tab-komitmen').classList.remove('text-slate-400', 'border-transparent');
        document.getElementById('tab-komitmen').classList.add('text-red-600', 'border-red-600');
    } else if (tabName === 'realisasi') {
        const hasCommitment = {{ $hasMonthlyCommitment ? 'true' : 'false' }};
        if (hasCommitment) {
            document.getElementById('content-realisasi').classList.remove('hidden');
            document.getElementById('tab-realisasi').classList.remove('text-slate-400', 'border-transparent');
            document.getElementById('tab-realisasi').classList.add('text-red-600', 'border-red-600');
        }
    }
}

function openProgressModal() {
    document.getElementById('progressModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeProgressModal() {
    document.getElementById('progressModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('progressModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeProgressModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeProgressModal();
});
</script>
@endsection
