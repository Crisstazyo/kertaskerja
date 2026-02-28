@extends('layouts.app')

@section('title', 'Admin - Combat The Churn Management')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #ea580c, #f97316, #ea580c);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #ea580c;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-orange-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            CTC <span class="text-orange-600">Combat The Churn</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input komitmen dan realisasi Combat The Churn</p>
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
                            class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-orange-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-orange-200">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
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

        {{-- ══ MAIN CONTENT SECTION ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="px-8 py-10">
                <div class="flex items-center justify-between mb-8 pb-4 border-b-2 border-slate-100">
                    <div>
                        <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tight">Input Combat The Churn</h2>
                        <p class="text-sm text-slate-500 italic mt-1">Input commitment SSL dan realisasi per kategori</p>
                    </div>
                    <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1.5 rounded-full uppercase tracking-wider">
                        Periode: {{ now()->translatedFormat('F Y') }}
                    </span>
                </div>

                <div class="space-y-6">
                    {{-- CT0 - ONLY REAL INPUT --}}
                    <div class="bg-gradient-to-br from-blue-50 to-white border-2 border-blue-200 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-blue-100">
                            <h3 class="text-2xl font-black text-blue-900 uppercase tracking-wide flex items-center">
                                <svg class="w-7 h-7 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                                CT0
                            </h3>
                            <span class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold text-sm uppercase tracking-wider">Realisasi Only</span>
                        </div>

                        <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST" class="max-w-2xl">
                            @csrf
                            <input type="hidden" name="category" value="ct0">
                            
                            <div class="bg-white border-2 border-blue-200 rounded-xl p-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-black text-slate-700 mb-3 uppercase tracking-wide">Input Real CT0</label>
                                    <div class="flex items-center space-x-3">
                                        <input type="number" name="quantity" required placeholder="Masukkan jumlah unit" min="0"
                                            class="flex-1 px-5 py-4 border-2 border-blue-300 rounded-xl text-lg font-bold text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all">
                                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-black text-sm shadow-xl transition-all transform hover:-translate-y-1">
                                            💾 Simpan Real
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- SALES HSI - COMMITMENT SSL + REAL SSL --}}
                    @php
                        $hasCommitmentSalesHsi = $commitments->has('sales_hsi');
                    @endphp
                    <div class="bg-gradient-to-br from-purple-50 to-white border-2 border-purple-200 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-purple-100">
                            <h3 class="text-2xl font-black text-purple-900 uppercase tracking-wide flex items-center">
                                <svg class="w-7 h-7 mr-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                </svg>
                                Sales HSI
                            </h3>
                            @if($hasCommitmentSalesHsi)
                                <span class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold text-sm">✓ SSL Committed</span>
                            @else
                                <span class="bg-amber-500 text-white px-4 py-2 rounded-lg font-bold text-sm">⏳ SSL Pending</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- COMMITMENT SSL --}}
                            <div class="bg-white border-2 border-purple-200 rounded-xl p-6">
                                <h4 class="text-sm font-black text-purple-800 mb-4 uppercase tracking-wider flex items-center">
                                    📋 Commitment (SSL)
                                </h4>
                                @if($hasCommitmentSalesHsi && !$isAdmin)
                                    {{-- Locked for regular users --}}
                                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <div>
                                                <p class="text-green-800 font-bold text-sm">SSL sudah terkunci</p>
                                                <p class="text-green-700 text-xs mt-1">Target: <span class="font-black">{{ number_format($commitments->get('sales_hsi')->quantity, 0, ',', '.') }} unit</span></p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($hasCommitmentSalesHsi && $isAdmin)
                                    {{-- Admin can edit existing commitment --}}
                                    <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="sales_hsi">
                                        <div class="space-y-3">
                                            <div class="bg-amber-50 border-l-4 border-amber-400 p-2 rounded-r-lg mb-2">
                                                <p class="text-xs text-amber-700 font-semibold">🔑 Admin: Edit commitment yang sudah terkunci</p>
                                            </div>
                                            <input type="number" name="quantity" required value="{{ $commitments->get('sales_hsi')->quantity }}" min="0"
                                                class="w-full px-4 py-3 border-2 border-purple-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100">
                                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                💾 Update SSL
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="sales_hsi">
                                        <div class="space-y-3">
                                            <input type="number" name="quantity" required placeholder="Target SSL" min="0"
                                                class="w-full px-4 py-3 border-2 border-purple-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100">
                                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                💾 Simpan SSL
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>

                            {{-- REAL SSL --}}
                            <div class="bg-white border-2 {{ $hasCommitmentSalesHsi ? 'border-green-300' : 'border-slate-200' }} rounded-xl p-6 {{ !$hasCommitmentSalesHsi ? 'opacity-50' : '' }}">
                                <h4 class="text-sm font-black {{ $hasCommitmentSalesHsi ? 'text-green-800' : 'text-slate-600' }} mb-4 uppercase tracking-wider flex items-center">
                                    ✅ Real (SSL)
                                </h4>
                                @if(!$hasCommitmentSalesHsi)
                                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                                        <p class="text-red-700 font-semibold text-xs">🔒 Input SSL Commitment terlebih dahulu</p>
                                    </div>
                                @else
                                    <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="sales_hsi">
                                        <div class="space-y-3">
                                            <input type="number" name="quantity" required placeholder="Realisasi SSL" min="0"
                                                class="w-full px-4 py-3 border-2 border-green-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                ✅ Simpan Real
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- CHURN - COMMITMENT SSL + REAL SSL --}}
                    @php
                        $hasCommitmentChurn = $commitments->has('churn');
                    @endphp
                    <div class="bg-gradient-to-br from-red-50 to-white border-2 border-red-200 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-red-100">
                            <h3 class="text-2xl font-black text-red-900 uppercase tracking-wide flex items-center">
                                <svg class="w-7 h-7 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Churn
                            </h3>
                            @if($hasCommitmentChurn)
                                <span class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold text-sm">✓ SSL Committed</span>
                            @else
                                <span class="bg-amber-500 text-white px-4 py-2 rounded-lg font-bold text-sm">⏳ SSL Pending</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- COMMITMENT SSL --}}
                            <div class="bg-white border-2 border-red-200 rounded-xl p-6">
                                <h4 class="text-sm font-black text-red-800 mb-4 uppercase tracking-wider flex items-center">
                                    📋 Commitment (SSL)
                                </h4>
                                @if($hasCommitmentChurn && !$isAdmin)
                                    {{-- Locked for regular users --}}
                                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <div>
                                                <p class="text-green-800 font-bold text-sm">SSL sudah terkunci</p>
                                                <p class="text-green-700 text-xs mt-1">Target: <span class="font-black">{{ number_format($commitments->get('churn')->quantity, 0, ',', '.') }} unit</span></p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($hasCommitmentChurn && $isAdmin)
                                    {{-- Admin can edit existing commitment --}}
                                    <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="churn">
                                        <div class="space-y-3">
                                            <div class="bg-amber-50 border-l-4 border-amber-400 p-2 rounded-r-lg mb-2">
                                                <p class="text-xs text-amber-700 font-semibold">🔑 Admin: Edit commitment yang sudah terkunci</p>
                                            </div>
                                            <input type="number" name="quantity" required value="{{ $commitments->get('churn')->quantity }}" min="0"
                                                class="w-full px-4 py-3 border-2 border-red-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                💾 Update SSL
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="churn">
                                        <div class="space-y-3">
                                            <input type="number" name="quantity" required placeholder="Target SSL" min="0"
                                                class="w-full px-4 py-3 border-2 border-red-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                💾 Simpan SSL
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>

                            {{-- REAL SSL --}}
                            <div class="bg-white border-2 {{ $hasCommitmentChurn ? 'border-green-300' : 'border-slate-200' }} rounded-xl p-6 {{ !$hasCommitmentChurn ? 'opacity-50' : '' }}">
                                <h4 class="text-sm font-black {{ $hasCommitmentChurn ? 'text-green-800' : 'text-slate-600' }} mb-4 uppercase tracking-wider flex items-center">
                                    ✅ Real (SSL)
                                </h4>
                                @if(!$hasCommitmentChurn)
                                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                                        <p class="text-red-700 font-semibold text-xs">🔒 Input SSL Commitment terlebih dahulu</p>
                                    </div>
                                @else
                                    <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="churn">
                                        <div class="space-y-3">
                                            <input type="number" name="quantity" required placeholder="Realisasi SSL" min="0"
                                                class="w-full px-4 py-3 border-2 border-green-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                ✅ Simpan Real
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- WINBACK - COMMITMENT SSL + REAL SSL --}}
                    @php
                        $hasCommitmentWinback = $commitments->has('winback');
                    @endphp
                    <div class="bg-gradient-to-br from-green-50 to-white border-2 border-green-200 rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-green-100">
                            <h3 class="text-2xl font-black text-green-900 uppercase tracking-wide flex items-center">
                                <svg class="w-7 h-7 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                </svg>
                                Winback
                            </h3>
                            @if($hasCommitmentWinback)
                                <span class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold text-sm">✓ SSL Committed</span>
                            @else
                                <span class="bg-amber-500 text-white px-4 py-2 rounded-lg font-bold text-sm">⏳ SSL Pending</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- COMMITMENT SSL --}}
                            <div class="bg-white border-2 border-green-200 rounded-xl p-6">
                                <h4 class="text-sm font-black text-green-800 mb-4 uppercase tracking-wider flex items-center">
                                    📋 Commitment (SSL)
                                </h4>
                                @if($hasCommitmentWinback && !$isAdmin)
                                    {{-- Locked for regular users --}}
                                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <div>
                                                <p class="text-green-800 font-bold text-sm">SSL sudah terkunci</p>
                                                <p class="text-green-700 text-xs mt-1">Target: <span class="font-black">{{ number_format($commitments->get('winback')->quantity, 0, ',', '.') }} unit</span></p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($hasCommitmentWinback && $isAdmin)
                                    {{-- Admin can edit existing commitment --}}
                                    <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="winback">
                                        <div class="space-y-3">
                                            <div class="bg-amber-50 border-l-4 border-amber-400 p-2 rounded-r-lg mb-2">
                                                <p class="text-xs text-amber-700 font-semibold">🔑 Admin: Edit commitment yang sudah terkunci</p>
                                            </div>
                                            <input type="number" name="quantity" required value="{{ $commitments->get('winback')->quantity }}" min="0"
                                                class="w-full px-4 py-3 border-2 border-green-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                💾 Update SSL
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('admin.ctc.combat-churn.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="winback">
                                        <div class="space-y-3">
                                            <input type="number" name="quantity" required placeholder="Target SSL" min="0"
                                                class="w-full px-4 py-3 border-2 border-green-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                💾 Simpan SSL
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>

                            {{-- REAL SSL --}}
                            <div class="bg-white border-2 {{ $hasCommitmentWinback ? 'border-green-300' : 'border-slate-200' }} rounded-xl p-6 {{ !$hasCommitmentWinback ? 'opacity-50' : '' }}">
                                <h4 class="text-sm font-black {{ $hasCommitmentWinback ? 'text-green-800' : 'text-slate-600' }} mb-4 uppercase tracking-wider flex items-center">
                                    ✅ Real (SSL)
                                </h4>
                                @if(!$hasCommitmentWinback)
                                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                                        <p class="text-red-700 font-semibold text-xs">🔒 Input SSL Commitment terlebih dahulu</p>
                                    </div>
                                @else
                                    <form action="{{ route('admin.ctc.combat-churn.storeRealisasi') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" value="winback">
                                        <div class="space-y-3">
                                            <input type="number" name="quantity" required placeholder="Realisasi SSL" min="0"
                                                class="w-full px-4 py-3 border-2 border-green-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                                                ✅ Simpan Real
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ DATA TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-orange-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">📜 Riwayat Combat The Churn</h3>
                </div>
                <span id="totalDataCount" class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total: {{ $data->count() }} data</span>
            </div>

            @if($data->count() > 0)
            {{-- FILTER SECTION --}}
            <div class="px-8 py-4 bg-slate-50 border-b border-slate-200">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span class="text-sm font-black text-slate-700 uppercase tracking-wider">Filter:</span>
                    </div>

                    {{-- Filter Tipe --}}
                    <div class="flex-1">
                        <select id="filterTipe" class="w-full px-4 py-2 border-2 border-slate-300 rounded-lg text-xs font-bold text-slate-700 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all cursor-pointer">
                            <option value="">📋 Semua Tipe</option>
                            <option value="komitmen">Komitmen</option>
                            <option value="realisasi">Realisasi</option>
                        </select>
                    </div>

                    {{-- Filter Category --}}
                    <div class="flex-1">
                        <select id="filterCategory" class="w-full px-4 py-2 border-2 border-slate-300 rounded-lg text-xs font-bold text-slate-700 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all cursor-pointer">
                            <option value="">🏷️ Semua Category</option>
                            <option value="ct0">CT0</option>
                            <option value="sales_hsi">Sales HSI</option>
                            <option value="churn">Churn</option>
                            <option value="winback">Winback</option>
                        </select>
                    </div>

                    {{-- Filter Periode --}}
                    <div class="flex-1">
                        <select id="filterPeriode" class="w-full px-4 py-2 border-2 border-slate-300 rounded-lg text-xs font-bold text-slate-700 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition-all cursor-pointer">
                            <option value="">📅 Semua Periode</option>
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
                    </div>

                    {{-- Reset Button --}}
                    <button onclick="resetFilters()" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg text-xs font-black uppercase tracking-wider transition-all shadow-sm">
                        🔄 Reset
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">No</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Tipe</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Category</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Quantity</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Periode</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Tanggal Input</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Waktu Edit</th>
                            <th class="text-center px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50" id="dataTableBody">
                        @foreach($data as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors data-row" 
                            data-type="{{ $item->type }}" 
                            data-category="{{ $item->category }}" 
                            data-periode="{{ $item->month }}-{{ $item->year }}">
                            <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                @if($item->type === 'komitmen')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-blue-100 text-blue-700">Komitmen</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-orange-100 text-orange-700">Realisasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($item->category === 'ct0')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-700">CT0</span>
                                @elseif($item->category === 'sales_hsi')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-green-100 text-green-700">Sales HSI</span>
                                @elseif($item->category === 'churn')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-red-100 text-red-700">Churn</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-cyan-100 text-cyan-700">Winback</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-orange-600">{{ number_format($item->quantity, 0, ',', '.') }} unit</td>
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
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    @if($isAdmin)
                                    <button onclick="openEditModalCombat({{ $item->id }}, '{{ $item->category }}', '{{ $item->type }}', {{ $item->quantity }})" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-[10px] font-bold transition-all">
                                        ✏️ Edit
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-16 px-8">
                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Belum ada data Combat The Churn</p>
                <p class="text-xs text-slate-400 mt-1">Mulai dengan menginput komitmen bulanan</p>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- EDIT MODAL --}}
<div id="editModalCombat" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-slate-100">
            <h3 class="text-xl font-black text-slate-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                </svg>
                Edit Data Combat Churn
            </h3>
            <button onclick="closeEditModalCombat()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editFormCombat" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                    <input type="text" id="editCategoryCombat" readonly
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg text-sm font-bold text-slate-600 bg-slate-50 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tipe</label>
                    <input type="text" id="editTypeCombat" readonly
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg text-sm font-bold text-slate-600 bg-slate-50 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Quantity</label>
                    <input type="number" name="quantity" id="editQuantityCombat" min="0" required
                        class="w-full px-4 py-3 border-2 border-blue-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                </div>
            </div>

            <div class="flex items-center space-x-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                    💾 Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditModalCombat()" class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-lg font-bold text-sm transition-all">
                    ❌ Batal
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
    
    // Set form action
    form.action = `/admin/ctc/combat-churn/${id}`;
    
    // Set values
    const categoryNames = {
        'ct0': 'CT0',
        'sales_hsi': 'Sales HSI',
        'churn': 'Churn',
        'winback': 'Winback'
    };
    editCategory.value = categoryNames[category] || category.toUpperCase();
    editType.value = type === 'komitmen' ? 'Komitmen SSL' : 'Realisasi SSL';
    editQuantity.value = quantity;
    
    // Show modal
    modal.classList.remove('hidden');
}

function closeEditModalCombat() {
    const modal = document.getElementById('editModalCombat');
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModalCombat')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModalCombat();
    }
});

// ══════════════════════════════════════════
// FILTERING FUNCTIONALITY
// ══════════════════════════════════════════

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
        
        // Filter by Tipe
        if (filterTipe !== '' && rowTipe !== filterTipe) {
            showRow = false;
        }
        
        // Filter by Category
        if (filterCategory !== '' && rowCategory !== filterCategory) {
            showRow = false;
        }
        
        // Filter by Periode
        if (filterPeriode !== '' && rowPeriode !== filterPeriode) {
            showRow = false;
        }
        
        // Show or hide row
        if (showRow) {
            row.style.display = '';
            visibleCount++;
            // Update row number
            row.querySelector('td:first-child').textContent = visibleCount;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update total count
    const totalCountElement = document.getElementById('totalDataCount');
    if (totalCountElement) {
        totalCountElement.textContent = `Total: ${visibleCount} data`;
    }
}

function resetFilters() {
    document.getElementById('filterTipe').value = '';
    document.getElementById('filterCategory').value = '';
    document.getElementById('filterPeriode').value = '';
    applyFilters();
}

// Add event listeners to filters
document.getElementById('filterTipe')?.addEventListener('change', applyFilters);
document.getElementById('filterCategory')?.addEventListener('change', applyFilters);
document.getElementById('filterPeriode')?.addEventListener('change', applyFilters);
</script>
@endsection