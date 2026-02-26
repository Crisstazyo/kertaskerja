@extends('layouts.app')

@section('title', 'Admin - PSAK ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">
                        ← Kembali ke Dashboard
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">PSAK Data - {{ ucfirst($role) }}</h1>
                    <p class="text-gray-600">Admin mengelola semua data Commitment dan Realisasi</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Input Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center space-x-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Input Data PSAK</span>
            </h2>
            
            <form action="{{ route('admin.psak.store', $role) }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Periode Input -->
                <div>
                    <label for="periode" class="block text-sm font-medium text-gray-700 mb-2 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Periode</span>
                    </label>
                    <input type="month" 
                           id="periode" 
                           name="periode" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-900 font-medium"
                           value="{{ date('Y-m') }}">
                    @error('periode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Segment Selection -->
                <div>
                    <label for="segment" class="block text-sm font-medium text-gray-700 mb-2 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Pilih Segmen</span>
                    </label>
                    <select id="segment" 
                            name="segment" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900 font-medium">
                        <option value="">-- Pilih Segmen --</option>
                        <option value="nc_step14">Not Close Step 1-4</option>
                        <option value="nc_step5">Not Close Step 5</option>
                        <option value="nc_konfirmasi">Not Close Konfirmasi</option>
                        <option value="nc_splitbill">Not Close Split Bill</option>
                        <option value="nc_crvariable">Not Close CR Variable</option>
                        <option value="nc_unidentified">Not Close Unidentified KB</option>
                    </select>
                    @error('segment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Order Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-blue-800">Format Order</span>
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="commitment_order" class="block text-sm font-semibold text-gray-700 mb-2">Commitment (Order)</label>
                                <input type="number" 
                                       id="commitment_order" 
                                       name="commitment_order" 
                                       step="0.01"
                                       placeholder="Contoh: 150.50"
                                       class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                @error('commitment_order')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="real_order" class="block text-sm font-semibold text-gray-700 mb-2">Realisasi (Order)</label>
                                <input type="number" 
                                       id="real_order" 
                                       name="real_order" 
                                       step="0.01"
                                       placeholder="Contoh: 140.75"
                                       class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                @error('real_order')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rupiah Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-purple-800">Format Rupiah</span>
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="commitment_rp" class="block text-sm font-semibold text-gray-700 mb-2">Commitment (Rp)</label>
                                <input type="number" 
                                       id="commitment_rp" 
                                       name="commitment_rp" 
                                       step="0.01"
                                       placeholder="Contoh: 50000000"
                                       class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white">
                                @error('commitment_rp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="real_rp" class="block text-sm font-semibold text-gray-700 mb-2">Realisasi (Rp)</label>
                                <input type="number" 
                                       id="real_rp" 
                                       name="real_rp" 
                                       step="0.01"
                                       placeholder="Contoh: 48000000"
                                       class="w-full px-4 py-2 border border-purple-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white">
                                @error('real_rp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="reset" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition-all">
                        Reset
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-2 rounded-lg font-medium transition-all shadow-md hover:shadow-lg flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Data</span>
                    </button>
                </div>
            </form>
        </div>

        @if($psakData->count() > 0)

        <!-- ===== UNIFIED FILTER PANEL ===== -->
        <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 mb-6">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                <h3 class="text-base font-bold text-gray-800">Filter & Pencarian Data</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Segment Dropdown Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Segmen</label>
                    <select id="masterFilterSegmen" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                        <option value="">-- Semua Segmen --</option>
                        <option value="Not Close Step 1-4">Not Close Step 1-4</option>
                        <option value="Not Close Step 5">Not Close Step 5</option>
                        <option value="Not Close Konfirmasi">Not Close Konfirmasi</option>
                        <option value="Not Close Split Bill">Not Close Split Bill</option>
                        <option value="Not Close CR Variable">Not Close CR Variable</option>
                        <option value="Not Close Unidentified KB">Not Close Unidentified KB</option>
                    </select>
                </div>
                <!-- Period Month Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Bulan</label>
                    <select id="masterFilterBulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                        <option value="">-- Semua Bulan --</option>
                        <option value="Jan">Januari</option>
                        <option value="Feb">Februari</option>
                        <option value="Mar">Maret</option>
                        <option value="Apr">April</option>
                        <option value="May">Mei</option>
                        <option value="Jun">Juni</option>
                        <option value="Jul">Juli</option>
                        <option value="Aug">Agustus</option>
                        <option value="Sep">September</option>
                        <option value="Oct">Oktober</option>
                        <option value="Nov">November</option>
                        <option value="Dec">Desember</option>
                    </select>
                </div>
                <!-- Period Year Filter -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Tahun</label>
                    <select id="masterFilterTahun" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                        <option value="">-- Semua Tahun --</option>
                        @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <!-- Custom Text Search -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Pencarian</label>
                    <div class="relative">
                        <input type="text" id="masterFilterText" placeholder="Cari user, periode, segmen..." class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <button onclick="applyMasterFilter()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    <span>Terapkan Filter</span>
                </button>
                <button onclick="resetMasterFilter()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Reset</span>
                </button>
                <span id="filterResultCount" class="text-sm text-gray-500 italic"></span>
            </div>
        </div>

        <!-- Data Table Order -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Data PSAK - Format Order</span>
                    </h2>
                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">
                        Order
                    </span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="tableOrder">
                    <thead class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Segmen</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Commitment<br>(Order)</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Realisasi<br>(Order)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($psakData as $psak)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                                    {{ $psak->periode ? \Carbon\Carbon::parse($psak->periode)->format('M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @php
                                    $segmentNames = [
                                        'nc_step14' => 'Not Close Step 1-4',
                                        'nc_step5' => 'Not Close Step 5',
                                        'nc_konfirmasi' => 'Not Close Konfirmasi',
                                        'nc_splitbill' => 'Not Close Split Bill',
                                        'nc_crvariable' => 'Not Close CR Variable',
                                        'nc_unidentified' => 'Not Close Unidentified KB',
                                    ];
                                    $segmentName = $segmentNames[$psak->segment] ?? $psak->segment;
                                @endphp
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $segmentName }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <div class="bg-blue-100 p-1.5 rounded-full">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $psak->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-indigo-600">
                                {{ $psak->commitment_order ? number_format($psak->commitment_order, 2, ',', '.') . ' Order' : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-blue-600">
                                {{ $psak->real_order ? number_format($psak->real_order, 2, ',', '.') . ' Order' : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Data Table Rupiah -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Data PSAK - Format Rupiah</span>
                    </h2>
                    <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-semibold">
                        Rp
                    </span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="tableRupiah">
                    <thead class="bg-gradient-to-r from-purple-500 to-pink-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Segmen</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Commitment<br>(Rp)</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">Realisasi<br>(Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($psakData as $psak)
                        <tr class="hover:bg-purple-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs">
                                    {{ $psak->periode ? \Carbon\Carbon::parse($psak->periode)->format('M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @php
                                    $segmentNames = [
                                        'nc_step14' => 'Not Close Step 1-4',
                                        'nc_step5' => 'Not Close Step 5',
                                        'nc_konfirmasi' => 'Not Close Konfirmasi',
                                        'nc_splitbill' => 'Not Close Split Bill',
                                        'nc_crvariable' => 'Not Close CR Variable',
                                        'nc_unidentified' => 'Not Close Unidentified KB',
                                    ];
                                    $segmentName = $segmentNames[$psak->segment] ?? $psak->segment;
                                @endphp
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $segmentName }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <div class="bg-purple-100 p-1.5 rounded-full">
                                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $psak->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-purple-600">
                                {{ $psak->commitment_rp ? 'Rp ' . number_format($psak->commitment_rp, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                                {{ $psak->real_rp ? 'Rp ' . number_format($psak->real_rp, 0, ',', '.') : '-' }}
                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <!-- No Data Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-16 text-center">
            <div class="max-w-md mx-auto">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data PSAK</h2>
                <p class="text-gray-600">
Data PSAK untuk role {{ ucfirst($role) }} belum tersedia. Silakan input commitment terlebih dahulu.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attach live listeners for realtime filtering
    ['masterFilterSegmen', 'masterFilterBulan', 'masterFilterTahun', 'masterFilterText'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', applyMasterFilter);
            el.addEventListener('keyup', applyMasterFilter);
        }
    });

    // Apply initial filter
    applyMasterFilter();
});

function applyMasterFilter() {
    const segmenVal  = (document.getElementById('masterFilterSegmen')?.value  || '').toLowerCase();
    const bulanVal   = (document.getElementById('masterFilterBulan')?.value   || '').toLowerCase();
    const tahunVal   = (document.getElementById('masterFilterTahun')?.value   || '').toLowerCase();
    const textVal    = (document.getElementById('masterFilterText')?.value    || '').toLowerCase();

    let totalVisible = 0;

    ['tableOrder', 'tableRupiah'].forEach(function(tableId) {
        const table = document.getElementById(tableId);
        if (!table) return;

        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            if (cells.length < 3) continue;

            const periodeText = (cells[0].textContent || cells[0].innerText).trim().toLowerCase();
            const segmenText  = (cells[1].textContent || cells[1].innerText).trim().toLowerCase();
            const userText    = (cells[2].textContent || cells[2].innerText).trim().toLowerCase();
            const rowFull     = periodeText + ' ' + segmenText + ' ' + userText;

            const segmenMatch = !segmenVal || segmenText.includes(segmenVal);
            const bulanMatch  = !bulanVal  || periodeText.includes(bulanVal);
            const tahunMatch  = !tahunVal  || periodeText.includes(tahunVal);
            const textMatch   = !textVal   || rowFull.includes(textVal);

            const show = segmenMatch && bulanMatch && tahunMatch && textMatch;
            row.style.display = show ? '' : 'none';
            if (show) totalVisible++;
        }
    });

    const countEl = document.getElementById('filterResultCount');
    if (countEl) {
        if (segmenVal || bulanVal || tahunVal || textVal) {
            countEl.textContent = 'Menampilkan ' + totalVisible + ' baris yang cocok';
        } else {
            countEl.textContent = '';
        }
    }
}

function resetMasterFilter() {
    ['masterFilterSegmen', 'masterFilterBulan', 'masterFilterTahun'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    const textEl = document.getElementById('masterFilterText');
    if (textEl) textEl.value = '';
    applyMasterFilter();
}
</script>

@endsection
