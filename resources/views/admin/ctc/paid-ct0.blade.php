@extends('layouts.app')

@section('title', 'Admin - Paid CT0 Management')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #7c3aed, #a855f7, #7c3aed);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #7c3aed;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-purple-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            CTC <span class="text-purple-600">Paid CT0</span>
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
                            class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-purple-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-purple-200">
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
            <div class="flex border-b border-slate-100 bg-slate-50">
                <button onclick="switchTab('komitmen')" id="tab-komitmen" 
                    class="flex-1 py-4 text-center font-bold text-purple-600 border-b-4 border-purple-500 transition-all">
                    📝 Form Komitmen (Bulanan)
                </button>
                <button onclick="switchTab('realisasi')" id="tab-realisasi"
                    class="flex-1 py-4 text-center font-bold text-slate-500 hover:text-purple-500 border-b-4 border-transparent transition-all">
                    ✅ Form Realisasi (Harian)
                </button>
            </div>

            <div class="p-8">
                {{-- KOMITMEN TAB --}}
                <div id="content-komitmen" class="space-y-6">
                    <div class="flex items-center justify-between border-b pb-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">Input Komitmen Bulanan - Semua Region</h2>
                            <p class="text-sm text-slate-500 italic">Isi nominal target untuk region yang Anda inginkan (bisa lebih dari 1)</p>
                        </div>
                        <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">
                            Periode: {{ now()->translatedFormat('F Y') }}
                        </span>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-white border-2 border-purple-200 rounded-2xl p-8 shadow-lg">
                        <h3 class="text-lg font-black text-purple-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            10 Region Sumut - Input Target Komitmen
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @foreach($regions as $index => $region)
                                @php
                                    $hasCommitment = $commitmentRegions->has($region);
                                    $commitmentData = $hasCommitment ? $commitmentRegions->get($region) : null;
                                @endphp
                                
                                <div class="relative">
                                    <form action="{{ route('admin.ctc.paid-ct0.storeKomitmen') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="region" value="{{ $region }}">
                                        
                                        <div class="p-5 border-2 rounded-xl transition-all {{ $hasCommitment ? 'border-green-400 bg-green-50' : 'border-purple-200 bg-white hover:border-purple-400 hover:shadow-md' }}">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="font-bold text-sm text-slate-900">{{ $index + 1 }}. {{ $region }}</div>
                                                @if($hasCommitment)
                                                    <span class="bg-green-600 text-white text-[10px] font-black px-2 py-1 rounded uppercase">✓ Sudah Input</span>
                                                @else
                                                    <span class="bg-amber-100 text-amber-700 text-[10px] font-black px-2 py-1 rounded uppercase">⏳ Belum</span>
                                                @endif
                                            </div>
                                            
                                            @if($hasCommitment)
                                                <div class="space-y-2">
                                                    <div class="text-xs text-green-700 font-semibold">
                                                        Target: <span class="font-black text-green-900">Rp {{ number_format($commitmentData->nominal, 0, ',', '.') }}</span>
                                                    </div>
                                                    <p class="text-[10px] text-green-600 italic">Region ini sudah terkunci untuk {{ now()->translatedFormat('F Y') }}</p>
                                                </div>
                                            @else
                                                <div class="flex items-center space-x-2">
                                                    <input type="number" name="nominal" step="0.01" placeholder="Nominal target (Rp)" required
                                                        class="flex-1 px-3 py-2 border-2 border-purple-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition-all">
                                                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-bold text-xs shadow-md transition-all whitespace-nowrap">
                                                        💾 Simpan
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-6 border-t-2 border-purple-100">
                            <p class="text-xs text-slate-600 italic flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <strong>Info:</strong>&nbsp;Region yang sudah diisi akan terkunci sampai bulan depan. Untuk edit, gunakan tombol edit di tabel riwayat di bawah.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- REALISASI TAB --}}
                <div id="content-realisasi" class="hidden space-y-6">
                    <div class="flex items-center justify-between border-b pb-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">Input Realisasi Paid CT0</h2>
                            <p class="text-sm text-slate-500 italic">Input realisasi harian untuk region yang sudah memiliki komitmen</p>
                        </div>
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Harian</span>
                    </div>

                    @if($commitmentRegions->count() == 0)
                        <div class="bg-red-50 border-l-4 border-red-400 p-6 rounded-r-lg">
                            <div class="flex items-center">
                                <div class="text-2xl mr-4">🔒</div>
                                <div>
                                    <p class="text-red-800 font-bold text-lg">Input Realisasi Belum Tersedia</p>
                                    <p class="text-sm text-red-700 mt-1">
                                        Anda harus menginput <strong>Komitmen Bulanan</strong> terlebih dahulu minimal untuk 1 region.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-br from-green-50 to-white border-2 border-green-200 rounded-2xl p-8 shadow-lg">
                            <h3 class="text-lg font-black text-green-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Region Aktif untuk Input Realisasi
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                @foreach($regions as $index => $region)
                                    @php
                                        $hasCommitment = $commitmentRegions->has($region);
                                    @endphp
                                    
                                    <div class="relative">
                                        @if($hasCommitment)
                                            <form action="{{ route('admin.ctc.paid-ct0.storeRealisasi') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="region" value="{{ $region }}">
                                                
                                                <div class="p-5 border-2 border-green-400 bg-green-50 rounded-xl">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div class="font-bold text-sm text-slate-900">{{ $index + 1 }}. {{ $region }}</div>
                                                        <span class="bg-green-600 text-white text-[10px] font-black px-2 py-1 rounded uppercase">✓ AKTIF</span>
                                                    </div>
                                                    
                                                    <div class="flex items-center space-x-2">
                                                        <input type="number" name="nominal" step="0.01" placeholder="Nominal realisasi (Rp)" required
                                                            class="flex-1 px-3 py-2 border-2 border-green-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all">
                                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-bold text-xs shadow-md transition-all whitespace-nowrap">
                                                            ✅ Simpan
                                                        </button>
                                                    </div>
                                                    <p class="text-[10px] text-green-700 mt-2 italic">💡 Bisa input berkali-kali setiap hari</p>
                                                </div>
                                            </form>
                                        @else
                                            <div class="p-5 border-2 border-slate-200 bg-slate-50 rounded-xl opacity-50">
                                                <div class="flex items-center justify-between mb-3">
                                                    <div class="font-bold text-sm text-slate-700">{{ $index + 1 }}. {{ $region }}</div>
                                                    <span class="bg-slate-300 text-slate-600 text-[10px] font-black px-2 py-1 rounded uppercase">🔒 LOCKED</span>
                                                </div>
                                                <p class="text-xs text-slate-500">Belum ada komitmen untuk region ini</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 pt-6 border-t-2 border-green-100">
                                <p class="text-xs text-slate-600 italic flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Hanya region dengan komitmen yang bisa diinput realisasi. Input bisa dilakukan berkali-kali setiap hari.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══ DATA TABLE - KOMITMEN ══ --}}
        <div id="table-komitmen" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-blue-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">📜 Riwayat Data Komitmen</h3>
                </div>
                @php
                    $komitmenData = $data->where('type', 'komitmen');
                @endphp
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total: {{ $komitmenData->count() }} data</span>
            </div>

            @if($komitmenData->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">No</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">User</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Region</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Nominal</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Periode</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Tanggal Input</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Waktu Edit</th>
                            <th class="text-center px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($komitmenData as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-slate-900">{{ $item->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-700">{{ $item->region }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-blue-600">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
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
                                    <button onclick="openEditModal({{ $item->id }}, '{{ $item->region }}', '{{ $item->type }}', {{ $item->nominal }})" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-[10px] font-bold transition-all">
                                        ✏️ Edit
                                    </button>
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
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Belum ada data Komitmen</p>
                <p class="text-xs text-slate-400 mt-1">Mulai dengan menginput komitmen bulanan</p>
            </div>
            @endif
        </div>

        {{-- ══ DATA TABLE - REALISASI ══ --}}
        <div id="table-realisasi" class="hidden bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-purple-600 rounded-full"></div>
                    <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">📜 Riwayat Data Realisasi</h3>
                </div>
                @php
                    $realisasiData = $data->where('type', 'realisasi');
                @endphp
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total: {{ $realisasiData->count() }} data</span>
            </div>

            @if($realisasiData->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">No</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">User</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Region</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Nominal</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Periode</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Tanggal Input</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Waktu Edit</th>
                            <th class="text-center px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($realisasiData as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-slate-900">{{ $item->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-700">{{ $item->region }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-purple-600">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
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
                                    <button onclick="openEditModal({{ $item->id }}, '{{ $item->region }}', '{{ $item->type }}', {{ $item->nominal }})" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-[10px] font-bold transition-all">
                                        ✏️ Edit
                                    </button>
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
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Belum ada data Realisasi</p>
                <p class="text-xs text-slate-400 mt-1">Input realisasi setelah menentukan komitmen</p>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- EDIT MODAL --}}
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-slate-100">
            <h3 class="text-xl font-black text-slate-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                </svg>
                Edit Data
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Region</label>
                    <input type="text" id="editRegion" readonly
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg text-sm font-bold text-slate-600 bg-slate-50 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tipe</label>
                    <input type="text" id="editType" readonly
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg text-sm font-bold text-slate-600 bg-slate-50 cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nominal (Rp)</label>
                    <input type="number" name="nominal" id="editNominal" step="0.01" required
                        class="w-full px-4 py-3 border-2 border-blue-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                </div>

                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
                    <p class="text-xs text-amber-800 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <strong>Info:</strong>&nbsp;Tanggal input tidak akan berubah, hanya waktu edit yang diperbarui
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold text-sm shadow-lg transition-all">
                    💾 Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-lg font-bold text-sm transition-all">
                    ❌ Batal
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
        komitmenTab.classList.add('text-purple-600', 'border-purple-500');
        komitmenTab.classList.remove('text-slate-500', 'border-transparent');
        realisasiTab.classList.remove('text-purple-600', 'border-purple-500');
        realisasiTab.classList.add('text-slate-500', 'border-transparent');
        
        komitmenContent.classList.remove('hidden');
        realisasiContent.classList.add('hidden');
        
        // Show komitmen table, hide realisasi table
        tableKomitmen.classList.remove('hidden');
        tableRealisasi.classList.add('hidden');
    } else {
        realisasiTab.classList.add('text-purple-600', 'border-purple-500');
        realisasiTab.classList.remove('text-slate-500', 'border-transparent');
        komitmenTab.classList.remove('text-purple-600', 'border-purple-500');
        komitmenTab.classList.add('text-slate-500', 'border-transparent');
        
        realisasiContent.classList.remove('hidden');
        komitmenContent.classList.add('hidden');
        
        // Show realisasi table, hide komitmen table
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
    
    // Set form action
    form.action = `/admin/ctc/paid-ct0/${id}`;
    
    // Set values
    editRegion.value = region;
    editType.value = type === 'komitmen' ? 'Komitmen' : 'Realisasi';
    editNominal.value = nominal;
    
    // Show modal
    modal.classList.remove('hidden');
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endsection