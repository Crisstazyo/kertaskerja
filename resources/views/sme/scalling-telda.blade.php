@extends('layouts.app')

@section('title', 'SME - Scalling Telda')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-6xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-cyan-500 to-blue-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-cyan-600 uppercase mb-1">SME · Scalling</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            Scalling <span class="text-cyan-600">Telda</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">9 Telekomunikasi Daerah · Input Realisasi</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('sme.scalling') }}"
                        class="flex items-center space-x-2 bg-white border-2 border-slate-900 hover:bg-slate-900 text-slate-900 hover:text-white px-5 py-2.5 rounded-xl font-black text-xs transition-all duration-300 uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back</span>
                    </a>
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

        {{-- ══ INPUT FORM ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-cyan-500 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">
                        Input Realisasi — {{ \Carbon\Carbon::now()->format('F Y') }}
                    </h2>
                </div>
                @if(!$record)
                <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-3 py-1.5">
                    ⚠ Admin belum mengatur commitment bulan ini
                </span>
                @endif
            </div>

            @if(!$record)
            <div class="flex items-center space-x-3 bg-amber-50 border border-amber-200 rounded-xl p-5">
                <svg class="w-6 h-6 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-bold text-amber-800">Commitment belum diatur oleh Admin</p>
                    <p class="text-xs text-amber-600 mt-0.5">Silakan hubungi admin untuk mengatur commitment bulan ini terlebih dahulu.</p>
                </div>
            </div>

            @else
            <form action="{{ route('sme.scalling.telda.store') }}" method="POST">
                @csrf
                <input type="hidden" name="periode" value="{{ \Carbon\Carbon::now()->format('Y-m') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-6">
                    @foreach($teldas as $key => $label)
                    @php
                        $commitment = $record->{$key . '_commitment'};
                        $real       = $record->{$key . '_real'};
                        $hasCommitment = !is_null($commitment);
                        $pct = ($hasCommitment && !is_null($real) && $commitment > 0)
                            ? ($real / $commitment) * 100
                            : null;
                    @endphp
                    <div class="border rounded-xl p-5 transition-all duration-200
                        {{ $hasCommitment ? 'border-slate-200 hover:border-cyan-200 hover:shadow-sm' : 'border-slate-100 bg-slate-50 opacity-60' }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 rounded-full {{ $hasCommitment ? 'bg-cyan-500' : 'bg-slate-300' }}"></div>
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide">{{ $label }}</h3>
                            </div>
                            @if(!is_null($pct))
                            <span class="text-[10px] font-bold rounded px-1.5 py-0.5
                                {{ $pct >= 100 ? 'text-green-700 bg-green-50' : ($pct >= 80 ? 'text-yellow-700 bg-yellow-50' : 'text-red-700 bg-red-50') }}">
                                {{ number_format($pct, 0) }}%
                            </span>
                            @endif
                        </div>

                        {{-- Commitment (read-only) --}}
                        <div class="mb-3">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Commitment (Admin)</p>
                            @if($hasCommitment)
                            <p class="text-base font-bold text-slate-700">{{ number_format($commitment, 0, ',', '.') }}</p>
                            @else
                            <p class="text-sm text-slate-300 italic">Belum diatur</p>
                            @endif
                        </div>

                        {{-- Realisasi input --}}
                        <div>
                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Realisasi</label>
                            <input type="number"
                                name="{{ $key }}_real"
                                value="{{ $real ?? '' }}"
                                placeholder="{{ $hasCommitment ? 'Masukkan realisasi' : 'Tunggu commitment' }}"
                                min="0"
                                {{ !$hasCommitment ? 'disabled' : '' }}
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-100 transition-colors disabled:bg-slate-50 disabled:text-slate-300 disabled:cursor-not-allowed">
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="flex items-center space-x-2 bg-slate-900 hover:bg-cyan-600 text-white font-bold text-xs px-6 py-2.5 rounded-lg transition-all duration-200 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Semua Realisasi</span>
                    </button>
                </div>
            </form>
            @endif
        </div>

        {{-- ══ HISTORY TABLE ══ --}}
        @if($history->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-cyan-500 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Riwayat Data Telda</h2>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 border border-slate-200 rounded-full px-3 py-1">
                    {{ $history->count() }} records
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Periode</th>
                            @foreach($teldas as $key => $label)
                            <th class="px-4 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap" colspan="2">{{ $label }}</th>
                            @endforeach
                        </tr>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-2"></th>
                            @foreach($teldas as $key => $label)
                            <th class="px-2 py-2 text-center text-[9px] font-black text-blue-400 uppercase">COM</th>
                            <th class="px-2 py-2 text-center text-[9px] font-black text-green-400 uppercase">REAL</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($history as $row)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-xs font-bold text-cyan-600 bg-cyan-50 border border-cyan-100 rounded-md px-2 py-0.5">
                                    {{ \Carbon\Carbon::parse($row->periode)->format('M Y') }}
                                </span>
                            </td>
                            @foreach($teldas as $key => $label)
                            @php
                                $com  = $row->{$key . '_commitment'};
                                $real = $row->{$key . '_real'};
                            @endphp
                            <td class="px-2 py-3 text-center font-bold text-slate-700 whitespace-nowrap text-xs">
                                {!! !is_null($com) ? number_format($com, 0, ',', '.') : '<span class="text-slate-300">—</span>' !!}
                            </td>
                            <td class="px-2 py-3 text-center whitespace-nowrap">
                                @if(!is_null($real))
                                    @php $pct = (!is_null($com) && $com > 0) ? ($real / $com) * 100 : null; @endphp
                                    <span class="text-xs font-bold {{ $pct !== null ? ($pct >= 100 ? 'text-green-600' : ($pct >= 80 ? 'text-yellow-600' : 'text-red-600')) : 'text-slate-600' }}">
                                        {{ number_format($real, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
