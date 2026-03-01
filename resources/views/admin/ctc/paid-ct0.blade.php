@extends('layouts.app')

@section('title', 'Admin - Paid CT0 Management')

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
                            CTC <span class="text-red-600">Paid CT0</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input komitmen dan realisasi Paid CT0</p>
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
            <div class="flex border-b border-slate-100">
                <button onclick="switchTab('komitmen')" id="tab-komitmen"
                    class="flex-1 flex items-center justify-center space-x-2 py-4 text-xs font-black uppercase tracking-widest text-red-600 border-b-2 border-red-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Form Komitmen (Bulanan)</span>
                </button>
                <button onclick="switchTab('realisasi')" id="tab-realisasi"
                    class="flex-1 flex items-center justify-center space-x-2 py-4 text-xs font-black uppercase tracking-widest text-slate-400 border-b-2 border-transparent hover:text-slate-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Form Realisasi (Harian)</span>
                </button>
            </div>

            <div class="p-8">

                {{-- KOMITMEN TAB --}}
                <div id="content-komitmen" class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                            <div>
                                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Komitmen Bulanan — Semua Region</h2>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Isi nominal target untuk region yang diinginkan</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">
                            Periode: {{ now()->translatedFormat('F Y') }}
                        </span>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">10 Region Sumut — Target Komitmen</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($regions as $index => $region)
                                @php
                                    $hasCommitment = $commitmentRegions->has($region);
                                    $commitmentData = $hasCommitment ? $commitmentRegions->get($region) : null;
                                @endphp

                                <div class="relative">
                                    <form action="{{ route('admin.ctc.paid-ct0.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="region" value="{{ $region }}">

                                        <div class="p-4 border-2 rounded-xl transition-all {{ $hasCommitment ? 'border-green-200 bg-green-50' : 'border-slate-200 bg-white hover:border-red-200 hover:shadow-sm' }}">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-xs font-black text-slate-700">{{ $index + 1 }}. {{ $region }}</span>
                                                @if($hasCommitment)
                                                    <span class="text-[10px] font-black text-green-700 bg-green-100 border border-green-200 rounded-md px-2 py-0.5 uppercase">Sudah Input</span>
                                                @else
                                                    <span class="text-[10px] font-black text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-2 py-0.5 uppercase">Belum</span>
                                                @endif
                                            </div>

                                            @if($hasCommitment)
                                                <div class="space-y-1">
                                                    <p class="text-xs text-green-700 font-semibold">
                                                        Target: <span class="font-black text-green-900">Rp {{ number_format($commitmentData->nominal, 0, ',', '.') }}</span>
                                                    </p>
                                                    <p class="text-[10px] text-green-600">Region ini sudah terkunci untuk {{ now()->translatedFormat('F Y') }}</p>
                                                </div>
                                            @else
                                                <div class="flex items-center space-x-2">
                                                    <input type="number" name="nominal" step="0.01" placeholder="Nominal target (Rp)" required
                                                        class="flex-1 px-3 py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all bg-slate-50">
                                                    <button type="submit"
                                                        class="bg-slate-900 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-[10px] uppercase tracking-wider transition-all whitespace-nowrap">
                                                        Simpan
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5 pt-5 border-t border-slate-200">
                            <div class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-slate-500 font-semibold">
                                    Region yang sudah diisi akan terkunci sampai bulan depan. Untuk edit, gunakan tombol edit di tabel riwayat di bawah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- REALISASI TAB --}}
                <div id="content-realisasi" class="hidden space-y-6">
                    @if($commitmentRegions->count() == 0)
                        <div class="flex items-start space-x-4 bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H9m3-10a3 3 0 00-3 3v1H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-3V8a3 3 0 00-3-3z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-black text-red-800">Input Realisasi Belum Tersedia</p>
                                <p class="text-xs text-red-700 mt-0.5">Anda harus menginput <strong>Komitmen Bulanan</strong> terlebih dahulu minimal untuk 1 region.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                                <div>
                                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Realisasi Paid CT0</h2>
                                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Input realisasi harian untuk region yang sudah memiliki komitmen</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-black tracking-widest text-green-700 bg-green-50 border border-green-200 rounded-md px-3 py-1 uppercase">Harian</span>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">Region Aktif untuk Input Realisasi</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($regions as $index => $region)
                                    @php $hasCommitment = $commitmentRegions->has($region); @endphp

                                    <div class="relative">
                                        @if($hasCommitment)
                                            <form action="{{ route('admin.ctc.paid-ct0.storeRealisasi') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="region" value="{{ $region }}">

                                                <div class="p-4 border-2 border-green-200 bg-green-50 rounded-xl">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="text-xs font-black text-slate-700">{{ $index + 1 }}. {{ $region }}</span>
                                                        <span class="text-[10px] font-black text-green-700 bg-green-100 border border-green-200 rounded-md px-2 py-0.5 uppercase">Aktif</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <input type="number" name="nominal" step="0.01" placeholder="Nominal realisasi (Rp)" required
                                                            class="flex-1 px-3 py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-all bg-white">
                                                        <button type="submit"
                                                            class="bg-slate-900 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-[10px] uppercase tracking-wider transition-all whitespace-nowrap">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                    <p class="text-[10px] text-green-600 mt-2">Bisa input berkali-kali setiap hari</p>
                                                </div>
                                            </form>
                                        @else
                                            <div class="p-4 border-2 border-slate-100 bg-slate-50 rounded-xl opacity-50">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="text-xs font-black text-slate-500">{{ $index + 1 }}. {{ $region }}</span>
                                                    <span class="text-[10px] font-black text-slate-400 bg-slate-100 rounded-md px-2 py-0.5 uppercase">Terkunci</span>
                                                </div>
                                                <p class="text-xs text-slate-400">Belum ada komitmen untuk region ini</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-5 pt-5 border-t border-slate-200">
                                <div class="flex items-start space-x-2">
                                    <svg class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-xs text-slate-500 font-semibold">
                                        Hanya region dengan komitmen yang bisa diinput realisasi. Input bisa dilakukan berkali-kali setiap hari.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- ══ TABEL KOMITMEN ══ --}}
        <div id="table-komitmen" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">Riwayat Data Komitmen</h3>
                </div>
                @php $komitmenData = $data->where('type', 'komitmen'); @endphp
                <span class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Total: {{ $komitmenData->count() }} data</span>
            </div>

            @if($komitmenData->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Region</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Edit</th>
                            <th class="text-center px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($komitmenData as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $item->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600">{{ $item->region }}</td>
                            <td class="px-6 py-4 text-xs font-black text-slate-800">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
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
                                <button onclick="openEditModal({{ $item->id }}, '{{ $item->region }}', '{{ $item->type }}', {{ $item->nominal }})"
                                    class="flex items-center space-x-1.5 bg-slate-100 hover:bg-red-600 text-slate-500 hover:text-white px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 mx-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </button>
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
                <p class="text-sm font-bold text-slate-400">Belum ada data Komitmen</p>
                <p class="text-xs text-slate-300 mt-1">Mulai dengan menginput komitmen bulanan</p>
            </div>
            @endif
        </div>

        {{-- ══ TABEL REALISASI ══ --}}
        <div id="table-realisasi" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">Riwayat Data Realisasi</h3>
                </div>
                @php $realisasiData = $data->where('type', 'realisasi'); @endphp
                <span class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Total: {{ $realisasiData->count() }} data</span>
            </div>

            @if($realisasiData->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Region</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                            <th class="text-left px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Edit</th>
                            <th class="text-center px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($realisasiData as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-slate-700">{{ $item->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600">{{ $item->region }}</td>
                            <td class="px-6 py-4 text-xs font-black text-slate-800">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
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
                                <button onclick="openEditModal({{ $item->id }}, '{{ $item->region }}', '{{ $item->type }}', {{ $item->nominal }})"
                                    class="flex items-center space-x-1.5 bg-slate-100 hover:bg-red-600 text-slate-500 hover:text-white px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 mx-auto">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </button>
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
                <p class="text-sm font-bold text-slate-400">Belum ada data Realisasi</p>
                <p class="text-xs text-slate-300 mt-1">Input realisasi setelah menentukan komitmen</p>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ══ EDIT MODAL ══ --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-200">

        {{-- Modal Header --}}
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
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">Edit Data</h3>
                </div>
                <button onclick="closeEditModal()" class="text-slate-300 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <form id="editForm" method="POST" class="px-8 pb-8">
            @csrf
            @method('PUT')

            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Region</label>
                    <input type="text" id="editRegion" readonly
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-500 bg-slate-50 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tipe</label>
                    <input type="text" id="editType" readonly
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-500 bg-slate-50 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nominal (Rp)</label>
                    <input type="number" name="nominal" id="editNominal" step="0.01" required
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                </div>
                <div class="flex items-start space-x-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-amber-700 font-semibold">Tanggal input tidak akan berubah, hanya waktu edit yang diperbarui.</p>
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
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs py-3 rounded-xl transition-all duration-200 uppercase tracking-wider">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function switchTab(tab) {
    const komitmenTab = document.getElementById('tab-komitmen');
    const realisasiTab = document.getElementById('tab-realisasi');
    const komitmenContent = document.getElementById('content-komitmen');
    const realisasiContent = document.getElementById('content-realisasi');
    const tableKomitmen = document.getElementById('table-komitmen');
    const tableRealisasi = document.getElementById('table-realisasi');

    if (tab === 'komitmen') {
        komitmenTab.classList.add('text-red-600', 'border-red-600');
        komitmenTab.classList.remove('text-slate-400', 'border-transparent');
        realisasiTab.classList.remove('text-red-600', 'border-red-600');
        realisasiTab.classList.add('text-slate-400', 'border-transparent');
        komitmenContent.classList.remove('hidden');
        realisasiContent.classList.add('hidden');
        tableKomitmen.classList.remove('hidden');
        tableRealisasi.classList.add('hidden');
    } else {
        realisasiTab.classList.add('text-red-600', 'border-red-600');
        realisasiTab.classList.remove('text-slate-400', 'border-transparent');
        komitmenTab.classList.remove('text-red-600', 'border-red-600');
        komitmenTab.classList.add('text-slate-400', 'border-transparent');
        realisasiContent.classList.remove('hidden');
        komitmenContent.classList.add('hidden');
        tableRealisasi.classList.remove('hidden');
        tableKomitmen.classList.add('hidden');
    }
}

function openEditModal(id, region, type, nominal) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const editRegion = document.getElementById('editRegion');
    const editType = document.getElementById('editType');
    const editNominal = document.getElementById('editNominal');

    form.action = `/admin/ctc/paid-ct0/${id}`;
    editRegion.value = region;
    editType.value = type === 'komitmen' ? 'Komitmen' : 'Realisasi';
    editNominal.value = nominal;

    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endsection
