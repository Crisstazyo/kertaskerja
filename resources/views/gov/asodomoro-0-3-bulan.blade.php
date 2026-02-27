@extends('layouts.app')

@section('title', 'Government - Asodomoro 0-3 Bulan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('gov.dashboard') }}" class="text-pink-600 hover:text-pink-800 mb-2 inline-block flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2"> Asodomoro 0-3 Bulan</h1>
                    <p class="text-gray-600 text-lg">Input realisasi data Asodomoro untuk periode 0-3 bulan</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-pink-500 via-rose-500 to-purple-500 rounded-full"></div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">✓ {{ session('success') }}</span>
        </div>
        @endif

        <!-- Info Banner -->
        <div class="bg-pink-100 border-l-4 border-pink-500 rounded-lg p-4 mb-6">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-bold text-pink-900 mb-1">Informasi</p>
                    <p class="text-xs text-pink-800 leading-relaxed">
                        Silakan input data realisasi Asodomoro untuk periode 0-3 bulan. Target komitmen adalah <strong>70%</strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Asodomoro Form -->
        <form method="POST" action="{{ route('gov.asodomoro-0-3-bulan.store') }}" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Input Realisasi</h2>
                </div>
                <div class="p-8">
                    <!-- Realisasi Percentage -->
                    <div class="max-w-md mx-auto">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Realisasi (%) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="realisasi" value="{{ old('realisasi') }}" placeholder="100" min="0" step="0.01" required
                                   class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('realisasi') border-red-500 @enderror">
                            <span class="absolute right-4 top-3 text-gray-500 text-lg font-semibold">%</span>
                        </div>
                        @error('realisasi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">Masukkan nilai realisasi dalam persen</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('gov.dashboard') }}" class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-400 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-8 py-3 rounded-lg font-semibold hover:from-pink-600 hover:to-rose-600 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200">
                    💾 Simpan Realisasi
                </button>
            </div>
        </form>

        <!-- History Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mt-8">
            <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">📋 History Input Realisasi</h2>
            </div>
            <div class="p-6">
                @if($history->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Realisasi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Input</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($history as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $history->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-pink-600">{{ number_format($item->realisasi ?? 0, 2) }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::create()->month($item->month)->format('F') }} {{ $item->year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $history->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada data realisasi yang diinput</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
