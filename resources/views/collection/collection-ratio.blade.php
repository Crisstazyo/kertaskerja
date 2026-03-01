@extends('layouts.app')

@section('title', 'Collection Ratio')

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
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">Collection <span class="text-red-600">Ratio</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Performance Metrics & Analysis</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('collection.dashboard') }}"
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

        {{-- ══ SECTION HEADER ══ --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Collection Ratio</h2>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-full px-4 py-1.5 shadow-sm">By Segment</span>
        </div>

        {{-- ══ MENU GRID ══ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @php
            $crCards = [
                [
                    'label' => 'CR SME',
                    'sub'   => 'Collection Ratio untuk Segmen SME',
                    'badge' => 'SME',
                    'route' => route('collection.cr-sme'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                ],
                [
                    'label' => 'CR Gov',
                    'sub'   => 'Collection Ratio untuk Segmen Government',
                    'badge' => 'GOV',
                    'route' => route('collection.cr-gov'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h1v11H4zm6 0h1v11h-1zm5 0h1v11h-1zm5 0h1v11h-1z"/>',
                ],
                [
                    'label' => 'CR Private',
                    'sub'   => 'Collection Ratio untuk Segmen Private',
                    'badge' => 'PVT',
                    'route' => route('collection.cr-private'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                ],
                [
                    'label' => 'CR SOE',
                    'sub'   => 'Collection Ratio untuk Segmen State-Owned Enterprise',
                    'badge' => 'SOE',
                    'route' => route('collection.cr-soe'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                ],
            ];
            @endphp

            @foreach($crCards as $card)
            <a href="{{ $card['route'] }}"
                class="group bg-white rounded-2xl border-2 border-slate-100 hover:border-red-200 shadow-sm hover:shadow-xl hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1.5 overflow-hidden relative">
                <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    style="background: radial-gradient(ellipse at top right, #fff1f2 0%, transparent 60%);"></div>
                <div class="p-7 flex items-center space-x-6 relative">
                    <div class="rounded-2xl flex items-center justify-center shadow-sm border-2 flex-shrink-0"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:64px; height:64px;">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $card['icon'] !!}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5">{{ $card['badge'] }}</span>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight mt-2 mb-1">{{ $card['label'] }}</h3>
                        <p class="text-sm text-slate-500 font-medium mb-3">{{ $card['sub'] }}</p>
                        <div class="flex items-center text-xs font-black text-slate-400 group-hover:text-red-600 uppercase tracking-widest transition-colors duration-200">
                            Open {{ $card['label'] }}
                            <svg class="w-3.5 h-3.5 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-red-600 flex items-center justify-center transition-all duration-200 flex-shrink-0">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach

        </div>

    </div>
</div>
@endsection
