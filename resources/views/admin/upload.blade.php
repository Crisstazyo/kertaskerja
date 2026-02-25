@extends('layouts.app')

@section('title', 'Admin - Upload ' . ucfirst($role))

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
                            <h1 class="text-3xl font-bold text-gray-900">Upload File - {{ ucfirst($role) }}</h1>
                            <p class="text-gray-600 mt-1">Upload data LOP dan lihat history</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Upload Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- LOP On Hand Upload -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <span class="text-3xl">📄</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">LOP On Hand</h3>
                        <p class="text-xs text-gray-500">Upload Excel Data</p>
                    </div>
                </div>
                <form action="{{ route('admin.lop.upload', [$role, 'on_hand']) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan & Tahun</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select name="month" required class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                            <select name="year" required class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Tahun</option>
                                @for($y = 2024; $y <= 2030; $y++)
                                    <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Excel</label>
                        <input type="file" name="file" accept=".xlsx,.xls" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        Upload On Hand
                    </button>
                </form>
            </div>

            <!-- LOP Qualified Upload -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-emerald-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-emerald-100 p-3 rounded-lg">
                        <span class="text-3xl">✅</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">LOP Qualified</h3>
                        <p class="text-xs text-gray-500">Upload Excel Data</p>
                    </div>
                </div>
                <form action="{{ route('admin.lop.upload', [$role, 'qualified']) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan & Tahun</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select name="month" required class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Bulan</option>
                                @for($i =1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                            <select name="year" required class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Tahun</option>
                                @for($y = 2024; $y <= 2030; $y++)
                                    <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Excel</label>
                        <input type="file" name="file" accept=".xlsx,.xls" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        Upload Qualified
                    </button>
                </form>
            </div>

            <!-- LOP Koreksi Upload -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-orange-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-orange-100 p-3 rounded-lg">
                        <span class="text-3xl">🔧</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">LOP Koreksi</h3>
                        <p class="text-xs text-gray-500">Upload Excel Data</p>
                    </div>
                </div>
                <form action="{{ route('admin.lop.upload', [$role, 'koreksi']) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan & Tahun</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select name="month" required class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                            <select name="year" required class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Tahun</option>
                                @for($y = 2024; $y <= 2030; $y++)
                                    <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Excel</label>
                        <input type="file" name="file" accept=".xlsx,.xls" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        Upload Koreksi
                    </button>
                </form>
            </div>
        </div>

        <!-- Upload History -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-slate-700 to-gray-800 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <span class="text-3xl">📚</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">History Upload</h2>
                            <p class="text-gray-300 text-sm">Riwayat upload file LOP</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Filters -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="on_hand">On Hand</option>
                            <option value="qualified">Qualified</option>
                            <option value="koreksi">Koreksi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tahun</option>
                            @for($y = 2024; $y <= 2030; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300">
                            Filter
                        </button>
                    </div>
                </div>

                <!-- History Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">File Name</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Total Rows</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Bulan</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Tahun</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Uploaded By</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Uploaded At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Sample data - will be populated from database -->
                            <tr class="hover:bg-gray-50">
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <span class="text-5xl mb-3">📭</span>
                                        <p class="font-semibold">Belum ada history upload</p>
                                        <p class="text-sm">Upload file untuk melihat history</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
</script>
@endif

@if($errors->any())
<script>
    alert('Error: {{ $errors->first() }}');
</script>
@endif
@endsection
