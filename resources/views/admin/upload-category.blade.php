@extends('layouts.app')

@section('title', 'Admin - Upload ' . ucfirst(str_replace('_', ' ', $category)))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-8">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.role.menu', $role) }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Menu
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Upload LOP {{ ucfirst(str_replace('_', ' ', $category)) }}</h1>
                        <p class="text-gray-600 mt-1">{{ ucfirst($role) }} - Upload file dan lihat history</p>
                    </div>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-200">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Upload Excel File</h2>
                <p class="text-sm text-gray-600">Upload file Excel untuk LOP {{ ucfirst(str_replace('_', ' ', $category)) }}</p>
            </div>

            <form action="{{ route('admin.lop.upload', [$role, $category]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Month Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Bulan
                            </span>
                        </label>
                        <select name="month" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Pilih Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Year Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tahun
                            </span>
                        </label>
                        <select name="year" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Pilih Tahun</option>
                            @for($y = 2024; $y <= 2030; $y++)
                                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                File Excel
                            </span>
                        </label>
                        <input type="file" name="file" accept=".xlsx,.xls" required 
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <p class="text-sm text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Format file: .xlsx atau .xls
                    </p>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-8 rounded-lg font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload File
                    </button>
                </div>
            </form>
        </div>

        <!-- Upload History -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-slate-700 to-gray-800 p-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">History Upload</h2>
                    <p class="text-gray-300 text-sm">Riwayat upload untuk LOP {{ ucfirst(str_replace('_', ' ', $category)) }}</p>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Filters -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <form method="GET" class="contents">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                            <select name="filter_month" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('filter_month') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                            <select name="filter_year" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Tahun</option>
                                @for($y = 2024; $y <= 2030; $y++)
                                    <option value="{{ $y }}" {{ request('filter_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="md:col-span-2 flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300">
                                Filter
                            </button>
                            <a href="{{ route('admin.upload.category', [$role, $category]) }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- History Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">File Name</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Total Rows</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Bulan</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Tahun</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Uploaded By</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Uploaded At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($uploadHistory as $index => $upload)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="font-semibold">{{ $upload->file_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-bold">{{ $upload->total_rows }}</span>
                                </td>
                                <td class="px-4 py-3 text-center font-semibold text-gray-900">
                                    {{ date('F', mktime(0, 0, 0, $upload->month, 1)) }}
                                </td>
                                <td class="px-4 py-3 text-center font-semibold text-gray-900">{{ $upload->year }}</td>
                                <td class="px-4 py-3 text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>{{ $upload->uploaded_by }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $upload->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="font-semibold text-lg">Belum ada history upload</p>
                                        <p class="text-sm mt-1">Upload file untuk melihat history</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    setTimeout(() => {
        alert('{{ session('success') }}');
    }, 100);
</script>
@endif

@if($errors->any())
<script>
    setTimeout(() => {
        alert('Error: {{ $errors->first() }}');
    }, 100);
</script>
@endif
@endsection
