@extends('layouts.app')

@section('title', 'Admin - Progress ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-8">
    <div class="max-w-[98%] mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.role.menu', $role) }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                    <div class="flex items-center gap-3">
                        @if($role === 'government')
                            <span class="text-4xl">🏛️</span>
                        @elseif($role === 'private')
                            <span class="text-4xl">🏢</span>
                        @elseif($role === 'soe')
                            <span class="text-4xl">🏭</span>
                        @elseif($role === 'sme')
                            <span class="text-4xl">🏪</span>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Monitor Progress - {{ ucfirst($role) }}</h1>
                            <p class="text-gray-600 mt-1">Lihat progress update dari user</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-gray-200">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <span class="text-3xl">🔍</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Filter Data</h2>
                    <p class="text-sm text-gray-600">Pilih kategori dan periode untuk melihat progress</p>
                </div>
            </div>

            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Kategori LOP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori LOP</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="on_hand" {{ request('category') == 'on_hand' ? 'selected' : '' }}>LOP On Hand</option>
                        <option value="qualified" {{ request('category') == 'qualified' ? 'selected' : '' }}>LOP Qualified</option>
                        <option value="koreksi" {{ request('category') == 'koreksi' ? 'selected' : '' }}>LOP Koreksi</option>
                        <option value="initiate" {{ request('category') == 'initiate' ? 'selected' : '' }}>LOP Initiate</option>
                    </select>
                </div>

                <!-- Month -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                    <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ (request('month', date('n')) == $i) ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Year -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                    <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @for($y = 2024; $y <= 2030; $y++)
                            <option value="{{ $y }}" {{ (request('year', date('Y')) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- User Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Filter User</label>
                    <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        🔍 Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Display -->
        @if($latestImport)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-slate-700 to-gray-800 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <span class="text-3xl">📈</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">
                                {{ ucfirst(str_replace('_', ' ', $category)) }}
                            </h2>
                            <p class="text-gray-300 text-sm">
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
                                @if(request('user_id'))
                                    - Filtered by User
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-300 text-sm">Total Data</p>
                        <p class="text-3xl font-bold text-white">{{ $latestImport->data->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Last Update Info -->
                @php
                    $lastUpdate = $latestImport->data
                        ->map(fn($row) => $row->funnel?->updated_at)
                        ->filter()
                        ->max();
                    
                    $lastUpdatedBy = $latestImport->data
                        ->map(fn($row) => $row->funnel)
                        ->filter()
                        ->sortByDesc('updated_at')
                        ->first();
                @endphp

                @if($lastUpdate)
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-500 rounded-full p-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Terakhir Diupdate</p>
                                <p class="text-xs text-gray-600">{{ $lastUpdate->format('d M Y, H:i:s') }} WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Note: This is READ-ONLY view for admin -->
                <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-yellow-800 font-semibold">Mode Monitoring: Data ditampilkan dalam mode read-only. Admin tidak dapat mengubah checkbox.</p>
                    </div>
                </div>

                <!-- Add link to go to detailed view like user page -->
                <div class="text-center py-8">
                    <a href="{{ route('admin.progress.detail', [$role, $category, $month, $year]) }}" 
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span class="text-2xl">📊</span>
                        <span>Lihat Detail Tabel Progress</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <p class="mt-3 text-sm text-gray-600">Klik untuk melihat tabel lengkap seperti tampilan user</p>
                </div>

                <!-- Summary Statistics -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 mb-1">Total Rows</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $latestImport->total_rows }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 mb-1">File Uploaded</p>
                        <p class="text-sm font-bold text-emerald-700 truncate">{{ $latestImport->file_name }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 mb-1">Uploaded By</p>
                        <p class="text-sm font-bold text-purple-700">{{ $latestImport->uploaded_by }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 mb-1">Upload Date</p>
                        <p class="text-sm font-bold text-orange-700">{{ $latestImport->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center border border-gray-200">
            <span class="text-6xl mb-4 inline-block">📭</span>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Data</h3>
            <p class="text-gray-600 mb-6">Belum ada data untuk kategori, bulan, dan tahun yang dipilih</p>
            <a href="{{ route('admin.upload.page', $role) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                <span>📤</span>
                <span>Upload Data</span>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
