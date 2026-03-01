@extends('layouts.app')

@section('title', 'Admin - Combat The Churn Management')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            CTC <span class="text-red-600">Combat The Churn</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input komitmen dan realisasi Combat The Churn</p>
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

        {{-- ══ MAIN CONTENT ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <div>
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Combat The Churn</h2>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Input commitment SSL dan realisasi per kategori</p>
                    </div>
                </div>
                <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">
                    Periode: {{ now()->translatedFormat('F Y') }}
                </span>
            </div>

            <div class="p-8 space-y-6">

                {{-- ══════════ CT0 ══════════ --}}
                @php
                    $ct0Real = $data->where('category','ct0')->where('type','realisasi')->first();
                    $hasCt0Real = !is_null($ct0Real);
                @endphp
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">CT0</h3>
                        </div>
                        @if($hasCt0Real)
                            <span class="text-[10px] font-black text-green-700 bg-green-50 border border-green-200 rounded-md px-2.5 py-1 uppercase tracking-widest">Sudah Diinput</span>
                        @else
                            <span class="text-[10px] font-black text-slate-500 bg-white border border-slate-200 rounded-md px-2.5 py-1 uppercase tracking-widest">Realisasi Only</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="bg-white border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Commitment (SSL)</p>
                            <div class="flex items-start space-x-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-4">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-slate-500 font-semibold">Langsung input realisasi untuk CT0</p>
                            </div>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Real (CT0)</p>
                            <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST">
                                @csrf
                                <input type="hidden" name="category" value="ct0">
                                <div class="space-y-3">
                                    <input type="number" name="quantity" required placeholder="Masukkan jumlah unit" min="0"
                                        value="{{ $hasCt0Real ? $ct0Real->quantity : '' }}"
                                        {{ $hasCt0Real ? 'disabled' : '' }}
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm font-bold focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all {{ $hasCt0Real ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'text-slate-800' }}">
                                    <button type="submit" {{ $hasCt0Real ? 'disabled' : '' }}
                                        class="w-full flex items-center justify-center space-x-2 text-white px-4 py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider transition-all duration-200 {{ $hasCt0Real ? 'bg-slate-300 cursor-not-allowed' : 'bg-slate-900 hover:bg-red-600' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>{{ $hasCt0Real ? 'Sudah Tersimpan' : 'Simpan Real' }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ══════════ SALES HSI ══════════ --}}
                @php
                    $hasCommitmentSalesHsi = $commitments->has('sales_hsi');
                    $salesHsiReal = $data->where('category','sales_hsi')->where('type','realisasi')->first();
                    $hasRealisasiSalesHsi = !is_null($salesHsiReal);
                @endphp
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">Sales HSI</h3>
                        </div>
                        @if($hasCommitmentSalesHsi)
                            <span class="text-[10px] font-black text-green-700 bg-green-50 border border-green-200 rounded-md px-2.5 py-1 uppercase tracking-widest">SSL Committed</span>
                        @else
                            <span class="text-[10px] font-black text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-2.5 py-1 uppercase tracking-widest">SSL Pending</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="bg-white border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Commitment (SSL)</p>
                            <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                @csrf
                                <input type="hidden" name="category" value="sales_hsi">
                                <div class="space-y-3">
                                    <input type="number" name="quantity" required min="0"
                                        value="{{ $hasCommitmentSalesHsi ? $commitments->get('sales_hsi')->quantity : '' }}"
                                        placeholder="Target SSL"
                                        {{ $hasCommitmentSalesHsi ? 'disabled' : '' }}
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm font-bold focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all {{ $hasCommitmentSalesHsi ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'text-slate-800' }}">
                                    <button type="submit" {{ $hasCommitmentSalesHsi ? 'disabled' : '' }}
                                        class="w-full flex items-center justify-center space-x-2 text-white px-4 py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider transition-all duration-200 {{ $hasCommitmentSalesHsi ? 'bg-slate-300 cursor-not-allowed' : 'bg-slate-900 hover:bg-red-600' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>{{ $hasCommitmentSalesHsi ? 'Sudah Tersimpan' : 'Simpan SSL' }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-5 {{ !$hasCommitmentSalesHsi ? 'opacity-50' : '' }}">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Real (SSL)</p>
                            @if(!$hasCommitmentSalesHsi)
                                <div class="flex items-start space-x-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-4">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                    <p class="text-xs text-slate-500 font-semibold">Input SSL Commitment terlebih dahulu</p>
                                </div>
                            @else
                                <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="category" value="sales_hsi">
                                    <div class="space-y-3">
                                        <input type="number" name="quantity" required min="0"
                                            value="{{ $hasRealisasiSalesHsi ? $salesHsiReal->quantity : '' }}"
                                            placeholder="Realisasi SSL"
                                            {{ $hasRealisasiSalesHsi ? 'disabled' : '' }}
                                            class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm font-bold focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all {{ $hasRealisasiSalesHsi ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'text-slate-800' }}">
                                        <button type="submit" {{ $hasRealisasiSalesHsi ? 'disabled' : '' }}
                                            class="w-full flex items-center justify-center space-x-2 text-white px-4 py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider transition-all duration-200 {{ $hasRealisasiSalesHsi ? 'bg-slate-300 cursor-not-allowed' : 'bg-slate-900 hover:bg-red-600' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>{{ $hasRealisasiSalesHsi ? 'Sudah Tersimpan' : 'Simpan Real' }}</span>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ══════════ CHURN ══════════ --}}
                @php
                    $hasCommitmentChurn = $commitments->has('churn');
                    $churnReal = $data->where('category','churn')->where('type','realisasi')->first();
                    $hasRealisasiChurn = !is_null($churnReal);
                @endphp
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">Churn</h3>
                        </div>
                        @if($hasCommitmentChurn)
                            <span class="text-[10px] font-black text-green-700 bg-green-50 border border-green-200 rounded-md px-2.5 py-1 uppercase tracking-widest">SSL Committed</span>
                        @else
                            <span class="text-[10px] font-black text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-2.5 py-1 uppercase tracking-widest">SSL Pending</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="bg-white border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Commitment (SSL)</p>
                            <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                @csrf
                                <input type="hidden" name="category" value="churn">
                                <div class="space-y-3">
                                    <input type="number" name="quantity" required min="0"
                                        value="{{ $hasCommitmentChurn ? $commitments->get('churn')->quantity : '' }}"
                                        placeholder="Target SSL"
                                        {{ $hasCommitmentChurn ? 'disabled' : '' }}
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm font-bold focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all {{ $hasCommitmentChurn ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'text-slate-800' }}">
                                    <button type="submit" {{ $hasCommitmentChurn ? 'disabled' : '' }}
                                        class="w-full flex items-center justify-center space-x-2 text-white px-4 py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider transition-all duration-200 {{ $hasCommitmentChurn ? 'bg-slate-300 cursor-not-allowed' : 'bg-slate-900 hover:bg-red-600' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>{{ $hasCommitmentChurn ? 'Sudah Tersimpan' : 'Simpan SSL' }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-5 {{ !$hasCommitmentChurn ? 'opacity-50' : '' }}">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Real (SSL)</p>
                            @if(!$hasCommitmentChurn)
                                <div class="flex items-start space-x-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-4">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                    <p class="text-xs text-slate-500 font-semibold">Input SSL Commitment terlebih dahulu</p>
                                </div>
                            @else
                                <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="category" value="churn">
                                    <div class="space-y-3">
                                        <input type="number" name="quantity" required min="0"
                                            value="{{ $hasRealisasiChurn ? $churnReal->quantity : '' }}"
                                            placeholder="Realisasi SSL"
                                            {{ $hasRealisasiChurn ? 'disabled' : '' }}
                                            class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm font-bold focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all {{ $hasRealisasiChurn ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'text-slate-800' }}">
                                        <button type="submit" {{ $hasRealisasiChurn ? 'disabled' : '' }}
                                            class="w-full flex items-center justify-center space-x-2 text-white px-4 py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider transition-all duration-200 {{ $hasRealisasiChurn ? 'bg-slate-300 cursor-not-allowed' : 'bg-slate-900 hover:bg-red-600' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>{{ $hasRealisasiChurn ? 'Sudah Tersimpan' : 'Simpan Real' }}</span>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ══════════ WINBACK ══════════ --}}
                @php
                    $hasCommitmentWinback = $commitments->has('winback');
                    $winbackReal = $data->where('category','winback')->where('type','realisasi')->first();
                    $hasRealisasiWinback = !is_null($winbackReal);
                @endphp
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">Winback</h3>
                        </div>
                        @if($hasCommitmentWinback)
                            <span class="text-[10px] font-black text-green-700 bg-green-50 border border-green-200 rounded-md px-2.5 py-1 uppercase tracking-widest">SSL Committed</span>
                        @else
                            <span class="text-[10px] font-black text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-2.5 py-1 uppercase tracking-widest">SSL Pending</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="bg-white border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Commitment (SSL)</p>
                            <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                @csrf
                                <input type="hidden" name="category" value="winback">
                                <div class="space-y-3">
                                    <input type="number" name="quantity" required min="0"
                                        value="{{ $hasCommitmentWinback ? $commitments->get('winback')->quantity : '' }}"
                                        placeholder="Target SSL"
                                        {{ $hasCommitmentWinback ? 'disabled' : '' }}
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm font-bold focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all {{ $hasCommitmentWinback ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'text-slate-800' }}">
                                    <button type="submit" {{ $hasCommitmentWinback ? 'disabled' : '' }}
                                        class="w-full flex items-center justify-center space-x-2 text-white px-4 py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider transition-all duration-200 {{ $hasCommitmentWinback ? 'bg-slate-300 cursor-not-allowed' : 'bg-slate-900 hover:bg-red-600' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>{{ $hasCommitmentWinback ? 'Sudah Tersimpan' : 'Simpan SSL' }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-xl p-5 {{ !$hasCommitmentWinback ? 'opacity-50' : '' }}">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Real (SSL)</p>
                            @if(!$hasCommitmentWinback)
                                <div class="flex items-start space-x-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-4">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                    <p class="text-xs text-slate-500 font-semibold">Input SSL Commitment terlebih dahulu</p>
                                </div>
                            @else
                                <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="category" value="winback">
                                    <div class="space-y-3">
                                        <input type="number" name="quantity" required min="0"
                                            value="{{ $hasRealisasiWinback ? $winbackReal->quantity : '' }}"
                                            placeholder="Realisasi SSL"
                                            {{ $hasRealisasiWinback ? 'disabled' : '' }}
                                            class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm font-bold focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all {{ $hasRealisasiWinback ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'text-slate-800' }}">
                                        <button type="submit" {{ $hasRealisasiWinback ? 'disabled' : '' }}
                                            class="w-full flex items-center justify-center space-x-2 text-white px-4 py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider transition-all duration-200 {{ $hasRealisasiWinback ? 'bg-slate-300 cursor-not-allowed' : 'bg-slate-900 hover:bg-red-600' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>{{ $hasRealisasiWinback ? 'Sudah Tersimpan' : 'Simpan Real' }}</span>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ══ DATA TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">Riwayat Combat The Churn</h3>
                </div>
                <span id="totalDataCount" class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Total: {{ $data->count() }} data</span>
            </div>

            @if($data->count() > 0)
            <div class="px-8 py-4 bg-slate-50 border-b border-slate-100">
                <div class="grid grid-cols-4 gap-3">
                    <select id="filterTipe"
                        class="px-4 py-2.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 focus:outline-none focus:border-red-400 bg-white cursor-pointer">
                        <option value="">Semua Tipe</option>
                        <option value="komitmen">Komitmen</option>
                        <option value="realisasi">Realisasi</option>
                    </select>
                    <select id="filterCategory"
                        class="px-4 py-2.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 focus:outline-none focus:border-red-400 bg-white cursor-pointer">
                        <option value="">Semua Category</option>
                        <option value="ct0">CT0</option>
                        <option value="sales_hsi">Sales HSI</option>
                        <option value="churn">Churn</option>
                        <option value="winback">Winback</option>
                    </select>
                    <select id="filterPeriode"
                        class="px-4 py-2.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 focus:outline-none focus:border-red-400 bg-white cursor-pointer">
                        <option value="">Semua Periode</option>
                        @php
                            $uniquePeriodes = $data->unique(function($item) {
                                return $item->month . '-' . $item->year;
                            })->sortByDesc(function($item) {
                                return $item->year . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                            });
                        @endphp
                        @foreach($uniquePeriodes as $item)
                            <option value="{{ $item->month }}-{{ $item->year }}">
                                {{ \Carbon\Carbon::create()->month($item->month)->format('F') }} {{ $item->year }}
                            </option>
                        @endforeach
                    </select>
                    <button onclick="resetFilters()"
                        class="flex items-center justify-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2.5 rounded-lg text-xs font-black uppercase tracking-wider transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Quantity</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Edit</th>
                            <th class="text-center px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="dataTableBody">
                        @foreach($data as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors data-row"
                            data-type="{{ $item->type }}"
                            data-category="{{ $item->category }}"
                            data-periode="{{ $item->month }}-{{ $item->year }}">
                            <td class="px-6 py-4 text-xs font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                @if($item->type === 'komitmen')
                                    <span class="text-[10px] font-black text-red-700 bg-red-50 border border-red-200 rounded-md px-2 py-0.5 uppercase">Komitmen</span>
                                @else
                                    <span class="text-[10px] font-black text-slate-600 bg-slate-100 border border-slate-200 rounded-md px-2 py-0.5 uppercase">Realisasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($item->category === 'ct0')
                                    <span class="text-[10px] font-black text-slate-700 bg-slate-100 border border-slate-200 rounded-md px-2 py-0.5 uppercase">CT0</span>
                                @elseif($item->category === 'sales_hsi')
                                    <span class="text-[10px] font-black text-green-700 bg-green-50 border border-green-200 rounded-md px-2 py-0.5 uppercase">Sales HSI</span>
                                @elseif($item->category === 'churn')
                                    <span class="text-[10px] font-black text-red-700 bg-red-50 border border-red-200 rounded-md px-2 py-0.5 uppercase">Churn</span>
                                @else
                                    <span class="text-[10px] font-black text-slate-600 bg-slate-100 border border-slate-200 rounded-md px-2 py-0.5 uppercase">Winback</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-black text-slate-800">{{ number_format($item->quantity, 0, ',', '.') }} unit</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600">{{ \Carbon\Carbon::create()->month($item->month)->format('F') }} {{ $item->year }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                @if($item->created_at != $item->updated_at)
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($isAdmin)
                                <button onclick="openEditModalCombat({{ $item->id }}, '{{ $item->category }}', '{{ $item->type }}', {{ $item->quantity }})"
                                    class="flex items-center space-x-1.5 bg-slate-100 hover:bg-red-600 text-slate-500 hover:text-white px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 mx-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </button>
                                @endif
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
                <p class="text-sm font-bold text-slate-400">Belum ada data Combat The Churn</p>
                <p class="text-xs text-slate-300 mt-1">Mulai dengan menginput komitmen bulanan</p>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ══ EDIT MODAL ══ --}}
<div id="editModalCombat" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-200">
        <div class="px-8 pt-8 pb-4 relative">
            <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="rounded-xl flex items-center justify-center border-2 flex-shrink-0"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:40px; height:40px;">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">Edit Data Combat Churn</h3>
                </div>
                <button onclick="closeEditModalCombat()" class="text-slate-300 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <form id="editFormCombat" method="POST" class="px-8 pb-8">
            @csrf
            @method('PUT')
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Category</label>
                    <input type="text" id="editCategoryCombat" readonly
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-500 bg-slate-50 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tipe</label>
                    <input type="text" id="editTypeCombat" readonly
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-500 bg-slate-50 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Quantity</label>
                    <input type="number" name="quantity" id="editQuantityCombat" min="0" required
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit"
                    class="flex-1 flex items-center justify-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
                <button type="button" onclick="closeEditModalCombat()"
                    class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs py-3 rounded-xl transition-all duration-200 uppercase tracking-wider">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModalCombat(id, category, type, quantity) {
    const modal = document.getElementById('editModalCombat');
    const form = document.getElementById('editFormCombat');
    const editCategory = document.getElementById('editCategoryCombat');
    const editType = document.getElementById('editTypeCombat');
    const editQuantity = document.getElementById('editQuantityCombat');
    form.action = `/admin/ctc/combat-churn/${id}`;
    const categoryNames = { 'ct0': 'CT0', 'sales_hsi': 'Sales HSI', 'churn': 'Churn', 'winback': 'Winback' };
    editCategory.value = categoryNames[category] || category.toUpperCase();
    editType.value = type === 'komitmen' ? 'Komitmen SSL' : 'Realisasi SSL';
    editQuantity.value = quantity;
    modal.classList.remove('hidden');
}

function closeEditModalCombat() {
    document.getElementById('editModalCombat').classList.add('hidden');
}

document.getElementById('editModalCombat')?.addEventListener('click', function(e) {
    if (e.target === this) closeEditModalCombat();
});

function applyFilters() {
    const filterTipe = document.getElementById('filterTipe').value.toLowerCase();
    const filterCategory = document.getElementById('filterCategory').value.toLowerCase();
    const filterPeriode = document.getElementById('filterPeriode').value.toLowerCase();
    const rows = document.querySelectorAll('.data-row');
    let visibleCount = 0;
    rows.forEach(function(row) {
        const rowTipe = row.getAttribute('data-type').toLowerCase();
        const rowCategory = row.getAttribute('data-category').toLowerCase();
        const rowPeriode = row.getAttribute('data-periode').toLowerCase();
        let showRow = true;
        if (filterTipe !== '' && rowTipe !== filterTipe) showRow = false;
        if (filterCategory !== '' && rowCategory !== filterCategory) showRow = false;
        if (filterPeriode !== '' && rowPeriode !== filterPeriode) showRow = false;
        if (showRow) {
            row.style.display = '';
            visibleCount++;
            row.querySelector('td:first-child').textContent = visibleCount;
        } else {
            row.style.display = 'none';
        }
    });
    const totalCountElement = document.getElementById('totalDataCount');
    if (totalCountElement) totalCountElement.textContent = `Total: ${visibleCount} data`;
}

function resetFilters() {
    document.getElementById('filterTipe').value = '';
    document.getElementById('filterCategory').value = '';
    document.getElementById('filterPeriode').value = '';
    applyFilters();
}

document.getElementById('filterTipe')?.addEventListener('change', applyFilters);
document.getElementById('filterCategory')?.addEventListener('change', applyFilters);
document.getElementById('filterPeriode')?.addEventListener('change', applyFilters);
</script>
@endsection
