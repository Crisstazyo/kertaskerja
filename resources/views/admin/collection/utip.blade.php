@extends('layouts.app')

@section('title', 'Admin - UTIP Management')

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
                            Collection <span class="text-red-600">UTIP</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input plan, komitmen, dan realisasi UTIP</p>
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
            <div class="flex border-b border-slate-100 bg-slate-50">
                <button onclick="switchTab('plan')" id="tab-plan" 
                    class="flex-1 py-4 text-center font-bold text-red-600 border-b-4 border-red-500 transition-all">
                    📋 Form Plan (Bulanan)
                </button>
                <button onclick="switchTab('komitmen-realisasi')" id="tab-komitmen-realisasi"
                    class="flex-1 py-4 text-center font-bold {{ $hasMonthlyCommitment ? 'text-slate-500 hover:text-red-500' : 'text-slate-300 cursor-not-allowed' }} border-b-4 border-transparent transition-all"
                    {{ !$hasMonthlyCommitment ? 'disabled' : '' }}>
                    ✅ Form Komitmen & Realisasi (Harian)
                </button>
            </div>

            <div class="p-8">
                {{-- PLAN TAB --}}
                <div id="content-plan" class="space-y-6">
                    <div class="flex items-center justify-between border-b pb-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">Input Plan Bulanan</h2>
                            <p class="text-sm text-slate-500 italic">Tentukan target value UTIP untuk bulan ini</p>
                        </div>
                        <span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">
                            Periode: {{ now()->translatedFormat('F Y') }}
                        </span>
                    </div>

                    @if($hasMonthlyCommitment)
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-6 rounded-r-lg">
                            <div class="flex items-center">
                                <div class="text-2xl mr-4">ℹ️</div>
                                <div>
                                    <p class="text-amber-800 font-bold">Target Sudah Terkunci</p>
                                    <p class="text-sm text-amber-700">
                                        Anda telah menginput target plan untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong>. Input baru hanya tersedia di bulan depan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('admin.collection.utip.store') }}" method="POST" class="max-w-md mx-auto bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                            @csrf
                            <input type="hidden" name="category" value="plan">
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide text-center">Tipe UTIP</label>
                                <select name="utip_type" required
                                    class="block w-full p-3 text-sm font-bold text-slate-800 border-2 border-red-300 rounded-lg bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="New UTIP">New UTIP</option>
                                    <option value="Corrective UTIP">Corrective UTIP</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide text-center">Target Value UTIP</label>
                                <div class="relative mt-1">
                                    <input type="number" name="value" min="0" step="0.01" required 
                                        class="block w-full p-4 text-4xl font-bold text-red-700 border-2 border-red-300 rounded-lg bg-white text-center focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                                        placeholder="1000000">
                                </div>
                                <p class="text-xs text-center text-gray-500 mt-2 italic">Masukkan target value untuk periode ini</p>
                            </div>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-lg font-bold shadow-lg transition-all transform hover:-translate-y-1">
                                💾 Simpan Target Bulanan
                            </button>
                        </form>
                    @endif
                </div>

                {{-- KOMITMEN & REALISASI TAB --}}
                <div id="content-komitmen-realisasi" class="hidden space-y-6">
                    @if(!$hasMonthlyCommitment)
                        <div class="bg-red-50 border-l-4 border-red-400 p-6 rounded-r-lg">
                            <div class="flex items-center">
                                <div class="text-2xl mr-4">🔒</div>
                                <div>
                                    <p class="text-red-800 font-bold text-lg">Input Komitmen/Realisasi Belum Tersedia</p>
                                    <p class="text-sm text-red-700 mt-1">
                                        Anda harus menginput <strong>Plan Bulanan</strong> terlebih dahulu sebelum dapat menginput komitmen atau realisasi harian.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between border-b pb-4 mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-800">Input Komitmen & Realisasi Harian</h2>
                                <p class="text-sm text-slate-500 italic">Input pencapaian value UTIP hari ini</p>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Harian</span>
                        </div>

                        <form action="{{ route('admin.collection.utip.store') }}" method="POST" class="max-w-md mx-auto bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide text-center">Tipe UTIP</label>
                                <select name="utip_type" required
                                    class="block w-full p-3 text-sm font-bold text-slate-800 border-2 border-green-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="New UTIP">New UTIP</option>
                                    <option value="Corrective UTIP">Corrective UTIP</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide text-center">Kategori</label>
                                <select name="category" required
                                    class="block w-full p-3 text-sm font-bold text-slate-800 border-2 border-green-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="komitmen">Komitmen</option>
                                    <option value="realisasi">Realisasi</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide text-center">Value UTIP</label>
                                <div class="relative mt-1">
                                    <input type="number" name="value" min="0" step="0.01" required 
                                        class="block w-full p-4 text-4xl font-bold text-green-700 border-2 border-green-300 rounded-lg bg-white text-center focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                        placeholder="500000">
                                </div>
                                <p class="text-xs text-center text-gray-500 mt-2 italic">Masukkan value komitmen atau realisasi hari ini</p>
                            </div>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-lg font-bold shadow-lg transition-all transform hover:-translate-y-1">
                                ✅ Simpan Data Harian
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══ DATA TABLE - MY DATA ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">🎯 Data UTIP Saya</h3>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total: {{ $data->count() }} data</span>
            </div>

            @if($data->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">No</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Tipe</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Kategori</th>
                            <th class="text-right px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Value</th>
                            <th class="text-center px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Periode</th>
                            <th class="text-center px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($data as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider 
                                    {{ str_contains($item->utip_type ?? '', 'New') ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $item->utip_type ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->category === 'plan')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-700">Plan</span>
                                @elseif($item->category === 'komitmen')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-blue-100 text-blue-700">Komitmen</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-green-100 text-green-700">Realisasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-black text-slate-800">{{ number_format($item->value, 0, ',', '.') }}</td>
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
            <div class="flex flex-col items-center justify-center py-16 px-8">
                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Belum ada data UTIP</p>
                <p class="text-xs text-slate-400 mt-1">Mulai dengan menginput plan bulanan</p>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ══ PROGRESS MODAL ══ --}}
<div id="progressModal" class="hidden fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0,0,0,0.7);">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl max-w-7xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            {{-- Modal Header --}}
            <div class="px-8 py-6 border-b border-slate-200 bg-gradient-to-r from-red-50 to-white flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Progress Data UTIP - Semua User</h2>
                        <p class="text-sm text-slate-500 mt-1">Total: <strong>{{ $allData->count() }}</strong> data submission dari semua collection user</p>
                    </div>
                </div>
                <button onclick="closeProgressModal()" class="text-slate-400 hover:text-red-600 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto p-8">
                @if($allData->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full border border-slate-200 rounded-lg">
                        <thead class="bg-slate-800 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-black uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3 text-right text-xs font-black uppercase tracking-wider">Value</th>
                                <th class="px-4 py-3 text-center text-xs font-black uppercase tracking-wider">Periode</th>
                                <th class="px-4 py-3 text-center text-xs font-black uppercase tracking-wider">Tanggal Input</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($allData as $index => $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-xs font-bold text-slate-600">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center">
                                            <span class="text-[10px] font-black text-red-600">{{ substr($item->user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-700">{{ $item->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase 
                                        {{ str_contains($item->utip_type ?? '', 'New') ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $item->utip_type ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->category === 'plan')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase bg-slate-100 text-slate-700">P</span>
                                    @elseif($item->category === 'komitmen')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase bg-blue-100 text-blue-700">K</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase bg-green-100 text-green-700">R</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-black text-slate-800">{{ number_format($item->value, 0, ',', '.') }}</td>
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
                <div class="flex flex-col items-center justify-center py-16">
                    <svg class="w-20 h-20 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-lg font-bold text-slate-400">Belum ada data progress</p>
                    <p class="text-sm text-slate-400 mt-1">Menunggu user mulai menginput data UTIP</p>
                </div>
                @endif
            </div>

            {{-- Modal Footer --}}
            <div class="px-8 py-4 border-t border-slate-200 bg-slate-50 flex justify-end">
                <button onclick="closeProgressModal()" class="px-6 py-2.5 bg-slate-900 hover:bg-red-600 text-white text-sm font-bold rounded-lg transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Tab Switching
function switchTab(tabName) {
    // Hide all content
    document.getElementById('content-plan').classList.add('hidden');
    document.getElementById('content-komitmen-realisasi').classList.add('hidden');
    
    // Reset all tabs
    document.getElementById('tab-plan').classList.remove('text-red-600', 'border-red-500');
    document.getElementById('tab-plan').classList.add('text-slate-500', 'border-transparent');
    document.getElementById('tab-komitmen-realisasi').classList.remove('text-red-600', 'border-red-500');
    document.getElementById('tab-komitmen-realisasi').classList.add('text-slate-500', 'border-transparent');
    
    // Show selected content and highlight tab
    if (tabName === 'plan') {
        document.getElementById('content-plan').classList.remove('hidden');
        document.getElementById('tab-plan').classList.remove('text-slate-500', 'border-transparent');
        document.getElementById('tab-plan').classList.add('text-red-600', 'border-red-500');
    } else if (tabName === 'komitmen-realisasi') {
        const hasCommitment = {{ $hasMonthlyCommitment ? 'true' : 'false' }};
        if (hasCommitment) {
            document.getElementById('content-komitmen-realisasi').classList.remove('hidden');
            document.getElementById('tab-komitmen-realisasi').classList.remove('text-slate-500', 'border-transparent');
            document.getElementById('tab-komitmen-realisasi').classList.add('text-red-600', 'border-red-500');
        }
    }
}

// Progress Modal
function openProgressModal() {
    document.getElementById('progressModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeProgressModal() {
    document.getElementById('progressModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('progressModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeProgressModal();
    }
});

// ESC key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProgressModal();
    }
});
</script>
@endsection
