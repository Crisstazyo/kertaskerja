@extends('layouts.app')

@section('title', 'Admin - Scalling Management - SOE')

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
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">Scaling <span class="text-red-600">Management</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">
                            SOE
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.index') }}"
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

        {{-- ══ FLASH MESSAGES ══ --}}
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-xl flex items-center space-x-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-xl flex items-center space-x-3 shadow-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-bold text-sm">{{ session('error') }}</span>
        </div>
        @endif

        {{-- ══ LOP CATEGORIES ══ --}}
        <div class="mb-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight">Kategori LOP</h2>
                    </div>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-full px-4 py-1.5 shadow-sm uppercase tracking-wide">
                    SOE Segment
                </span>
            </div>

            @php
                $lopCards = [
                    [
                        'label'   => 'LOP On Hand',
                        'sub'     => 'Manage LOP On Hand data, upload files, dan lihat progress',
                        'badge'   => 'ON-HAND',
                        'type'    => 'on-hand',
                        'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                    ],
                    [
                        'label'   => 'LOP Qualified',
                        'sub'     => 'Manage LOP Qualified data, upload files, dan lihat progress',
                        'badge'   => 'QUALIFIED',
                        'type'    => 'qualified',
                        'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    ],
                    [
                        'label'   => 'Koreksi',
                        'sub'     => 'Manage Koreksi data, upload files, dan lihat progress',
                        'badge'   => 'KOREKSI',
                        'type'    => 'koreksi',
                        'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($lopCards as $card)
                <a href="{{ route('admin.scalling.soe.' . $card['type']) }}"
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
                            <span class="text-xs font-black text-slate-400 group-hover:text-red-600 uppercase tracking-widest transition-colors duration-200">Manage Data</span>
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
</div>
@endsection
