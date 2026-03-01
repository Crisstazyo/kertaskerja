@extends('layouts.app')

@section('title', 'SME - HSI Agency')

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
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            HSI <span class="text-red-600">Agency</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input Realisasi Bulan Ini</p>
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
        @if(session('error'))
        <div class="flex items-center space-x-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- ══ CURRENT PERIOD CARD ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <div>
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Periode {{ \Carbon\Carbon::now()->format('F Y') }}</h2>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Input realisasi HSI Agency bulan ini.</p>
                    </div>
                </div>
                <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">HSI Agency</span>
            </div>

            <div class="p-8">
                @if(!$record || is_null($record->commitment))
                {{-- No commitment yet --}}
                <div class="flex items-start space-x-4 bg-amber-50 border border-amber-200 rounded-xl px-5 py-4">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-black text-amber-800">Commitment Belum Diatur</p>
                        <p class="text-xs text-amber-700 mt-0.5">Admin belum mengatur commitment untuk bulan ini. Silakan hubungi admin.</p>
                    </div>
                </div>

                @else
                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-5 mb-8">
                    <div class="bg-red-50 border border-red-100 rounded-xl p-5">
                        <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-2">Commitment (SSL) — Diatur Admin</p>
                        <p class="text-3xl font-black text-red-700">
                            {{ number_format($record->commitment, 0, ',', '.') }}
                            <span class="text-base font-bold text-red-400">SSL</span>
                        </p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Realisasi Saat Ini</p>
                        @if(!is_null($record->real))
                            @php $pct = $record->commitment > 0 ? ($record->real / $record->commitment) * 100 : 0; @endphp
                            <p class="text-3xl font-black text-slate-800">
                                {{ number_format($record->real, 0, ',', '.') }}
                                <span class="text-base font-bold text-slate-400">SSL</span>
                            </p>
                            <p class="text-xs font-bold mt-1 {{ $pct >= 100 ? 'text-green-600' : ($pct >= 80 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ number_format($pct, 1) }}% dari target
                            </p>
                        @else
                            <p class="text-2xl font-black text-slate-300">Belum diisi</p>
                        @endif
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('sme.scalling.hsi-agency.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="periode" value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Input Realisasi (SSL)</label>
                            <input type="number" name="real"
                                value="{{ $record->real ?? '' }}"
                                placeholder="Masukkan jumlah realisasi"
                                min="0" required
                                class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                            @error('real')
                                <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200 whitespace-nowrap">
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

        {{-- ══ HISTORY TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Riwayat Data</h2>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-full px-4 py-1.5 shadow-sm">
                    {{ $history->count() }} Records
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Commitment</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Realisasi</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Achievement</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($history as $i => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-400">{{ $i + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2.5 py-1">
                                    {{ \Carbon\Carbon::parse($item->periode)->format('M Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-800">
                                {{ !is_null($item->commitment) ? number_format($item->commitment, 0, ',', '.') . ' SSL' : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-800">
                                @if(!is_null($item->real))
                                    {{ number_format($item->real, 0, ',', '.') }} SSL
                                @else
                                    <span class="text-slate-300 font-normal">Belum diisi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if(!is_null($item->real) && !is_null($item->commitment) && $item->commitment > 0)
                                    @php $pct = ($item->real / $item->commitment) * 100; @endphp
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1
                                        {{ $pct >= 100 ? 'text-green-700 bg-green-50 border border-green-200' : ($pct >= 80 ? 'text-yellow-700 bg-yellow-50 border border-yellow-200' : 'text-red-700 bg-red-50 border border-red-200') }}">
                                        {{ number_format($pct, 1) }}%
                                    </span>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm font-bold text-slate-400">Belum ada data</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
