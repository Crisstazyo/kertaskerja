@extends('layouts.app')

@section('title', 'SME - Asodomoro >3 Bulan')

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
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">Aosodomoro <span class="text-red-600">&gt;3 Bulan</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input Realisasi Data Aosodomoro Periode Lebih dari 3 Bulan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('sme.dashboard') }}"
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

        {{-- ══ FLASH MESSAGES ══ --}}
        @if(session('success'))
        <div class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- ══ INFO BANNER ══ --}}
        <div class="flex items-start space-x-4 bg-amber-50 border border-amber-200 rounded-xl px-5 py-4 mb-8">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-black text-amber-800">Informasi</p>
                <p class="text-xs text-amber-700 mt-0.5">
                    Silakan input data realisasi Aosodomoro untuk periode lebih dari 3 bulan. Target komitmen adalah <strong>35%</strong>.
                </p>
            </div>
        </div>

        {{-- ══ FORM ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="px-8 py-5 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <div>
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Realisasi</h2>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Catat realisasi Aosodomoro periode lebih dari 3 bulan.</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('sme.asodomoro-above-3-bulan.store') }}">
                    @csrf
                    <div class="max-w-md mx-auto space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 text-center">Realisasi (%)</label>
                            <div class="relative">
                                <input type="number" name="realisasi" value="{{ old('realisasi') }}"
                                    placeholder="0.00" min="0" step="0.01" required
                                    class="w-full px-6 py-5 text-4xl font-black text-red-600 border-2 border-slate-200 rounded-xl bg-slate-50 text-center focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors @error('realisasi') border-red-400 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-black text-2xl">%</span>
                                </div>
                            </div>
                            @error('realisasi')
                            <p class="text-xs text-red-600 font-semibold mt-1.5 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-center space-x-3 pt-2">
                            <button type="submit"
                                class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Simpan Realisasi</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══ HISTORY TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">History Input Realisasi</h2>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-full px-4 py-1.5 shadow-sm">&gt;3 Bulan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Realisasi</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($history as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-400">{{ $history->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-black text-red-600">{{ number_format($item->realisasi ?? 0, 2) }}%</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                                {{ \Carbon\Carbon::create()->month($item->month)->format('F') }} {{ $item->year }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-400 font-medium">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center">
                                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm font-bold text-slate-400">Belum ada data realisasi yang diinput</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($history->count() > 0)
            <div class="px-8 py-4 border-t border-slate-100">
                {{ $history->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
