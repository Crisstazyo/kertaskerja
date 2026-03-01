@extends('layouts.app')

@section('title', 'CR Gov')

@section('content')
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
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">CR <span class="text-red-600">Gov</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Collection Ratio — Government Segment</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('collection.collection-ratio') }}"
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
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                </div>
            </div>
        </div>

        {{-- ══ TAB FORM ══ --}}
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
                                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Komitmen Bulanan — Government</h2>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Tentukan target collection ratio Government untuk bulan ini.</p>
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
                                    Anda telah menginput target ratio CR Government untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong>. Input baru hanya tersedia di bulan depan.
                                </p>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('cr-gov.storeKomitmen') }}" method="POST" class="max-w-md mx-auto space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 text-center">Target Ratio (%)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="target_ratio" required
                                        class="w-full px-6 py-5 text-4xl font-black text-red-600 border-2 border-slate-200 rounded-xl bg-slate-50 text-center focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-black text-2xl">%</span>
                                    </div>
                                </div>
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
                                    Anda harus menginput <strong>Komitmen Bulanan</strong> terlebih dahulu sebelum dapat mencatat realisasi.
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                                <div>
                                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Realisasi CR Government</h2>
                                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Catat realisasi collection ratio harian.</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-black tracking-widest text-green-700 bg-green-50 border border-green-200 rounded-md px-3 py-1 uppercase">Harian</span>
                        </div>

                        <form action="{{ route('cr-gov.storeRealisasi') }}" method="POST" class="max-w-lg mx-auto space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Realisasi CR (%)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="ratio_aktual" required
                                        class="w-full px-6 py-4 text-2xl font-black text-slate-800 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-black text-xl">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Simpan Realisasi</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>

        {{-- ══ HISTORY TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Riwayat Aktivitas CR Government</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                            <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Ratio (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                                {{ $item->entry_date->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->type == 'komitmen')
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1 text-red-700 bg-red-50 border border-red-200">Komitmen</span>
                                @else
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1 text-green-700 bg-green-50 border border-green-200">Realisasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-black {{ $item->type == 'komitmen' ? 'text-red-600' : 'text-green-600' }}">
                                {{ number_format($item->type == 'komitmen' ? $item->target_ratio : $item->ratio_aktual, 2) }}%
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-16 text-center">
                                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm font-bold text-slate-400">Belum ada data aktivitas</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tab) {
        const kTab     = document.getElementById('tab-komitmen');
        const rTab     = document.getElementById('tab-realisasi');
        const kContent = document.getElementById('content-komitmen');
        const rContent = document.getElementById('content-realisasi');

        if (tab === 'realisasi' && rTab.hasAttribute('disabled')) return;

        if (tab === 'komitmen') {
            kTab.classList.add('text-red-600', 'border-red-600');
            kTab.classList.remove('text-slate-400', 'border-transparent');
            rTab.classList.add('text-slate-400', 'border-transparent');
            rTab.classList.remove('text-red-600', 'border-red-600');
            kContent.classList.remove('hidden');
            rContent.classList.add('hidden');
        } else {
            rTab.classList.add('text-red-600', 'border-red-600');
            rTab.classList.remove('text-slate-400', 'border-transparent');
            kTab.classList.add('text-slate-400', 'border-transparent');
            kTab.classList.remove('text-red-600', 'border-red-600');
            rContent.classList.remove('hidden');
            kContent.classList.add('hidden');
        }
    }
</script>
@endsection
