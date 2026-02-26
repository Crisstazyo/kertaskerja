@extends('layouts.app')

@section('title', 'Admin - Rising Star Management')

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
                            Rising Star <span class="text-red-600">Management</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">
                            Bintang {{ $star }} —
                            @if($star == 1) Visiting
                            @elseif($star == 2) Profiling
                            @elseif($star == 3) Kecukupan LOP
                            @elseif($star == 4) Asodomoro Terpadu
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-slate-900 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
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

        {{-- ══ SECTION HEADER + BINTANG SELECTOR ══ --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    @if($star == 1) Visiting Management
                    @elseif($star == 2) Profiling Management
                    @elseif($star == 3) Kecukupan LOP
                    @elseif($star == 4) Asodomoro Terpadu
                    @endif
                </h2>
            </div>
        </div>

        {{-- ══ DEFINE CARDS PER BINTANG ══ --}}
        @php
            if ($star == 1) {
                $cols = 3;
                $cards = [
                    [
                        'label' => 'Visiting GM',
                        'sub'   => 'Kelola data visiting General Manager',
                        'badge' => 'GM',
                        'route' => route('admin.rising-star.feature', 'visiting-gm'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                    ],
                    [
                        'label' => 'Visiting AM',
                        'sub'   => 'Kelola data visiting Area Manager',
                        'badge' => 'AM',
                        'route' => route('admin.rising-star.feature', 'visiting-am'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    ],
                    [
                        'label' => 'Visiting HOTD',
                        'sub'   => 'Kelola data visiting Head of TD',
                        'badge' => 'HOTD',
                        'route' => route('admin.rising-star.feature', 'visiting-hotd'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
                    ],
                ];
            } elseif ($star == 2) {
                $cols = 2;
                $cards = [
                    [
                        'label' => 'Profiling Maps AM',
                        'sub'   => 'Kelola data profiling maps area manager',
                        'badge' => 'Maps AM',
                        'route' => route('admin.rising-star.feature', 'profiling-maps-am'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>',
                    ],
                    [
                        'label' => 'Profiling Overall HOTD',
                        'sub'   => 'Kelola data profiling overall head of TD',
                        'badge' => 'HOTD',
                        'route' => route('admin.rising-star.feature', 'profiling-overall-hotd'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                    ],
                ];
            } elseif ($star == 3) {
                $cols = 2;
                $cards = [
                    [
                        'label' => 'Kecukupan LOP',
                        'sub'   => 'Kelola data kecukupan LOP',
                        'badge' => 'LOP',
                        'route' => route('admin.rising-star.feature', 'kecukupan-lop'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                    ],
                ];
            } else {
                $cols = 2;
                $cards = [
                    [
                        'label' => 'Asodomoro 0-3 Bulan',
                        'sub'   => 'Kelola data asodomoro 0-3 bulan',
                        'badge' => '0-3 Bln',
                        'route' => route('admin.rising-star.feature', 'asodomoro-0-3-bulan'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    ],
                    [
                        'label' => 'Asodomoro >3 Bulan',
                        'sub'   => 'Kelola data asodomoro di atas 3 bulan',
                        'badge' => '>3 Bln',
                        'route' => route('admin.rising-star.feature', 'asodomoro-above-3-bulan'),
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    ],
                ];
            }
        @endphp

        {{-- ══ RENDER CARDS ══ --}}
        <div class="grid grid-cols-1 {{ $cols == 3 ? 'md:grid-cols-3' : 'md:grid-cols-2' }} gap-5">
            @foreach($cards as $card)
            <a href="{{ $card['route'] }}"
                class="group bg-white rounded-2xl border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1.5 overflow-hidden relative">
                <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    style="background: radial-gradient(ellipse at top right, #fff1f2 0%, transparent 60%);"></div>
                <div class="p-6 relative">
                    <div class="flex items-start justify-between mb-5">
                        <div class="rounded-xl flex items-center justify-center shadow-sm border-2"
                            style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:52px; height:52px;">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $card['icon'] !!}
                            </svg>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5">{{ $card['badge'] }}</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight mb-1">{{ $card['label'] }}</h3>
                    <p class="text-sm text-slate-500 font-medium mb-5 leading-relaxed">{{ $card['sub'] }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-slate-400 group-hover:text-red-600 uppercase tracking-widest transition-colors duration-200">Kelola Data</span>
                        <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-red-600 flex items-center justify-center transition-all duration-200">
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</div>
@endsection
