@extends('layouts.app')

@section('title', 'Rising Star 4 - Asodomoro')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">⭐ Rising Star 4 - Asodomoro</h1>
                    <p class="text-gray-600 text-lg">Input Realisasi Asodomoro - Commitment Tetap 70%</p>
                </div>
                <a href="{{ route('rising-star.dashboard') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-600 rounded-full"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Info Card - Commitment 70% Fixed -->
        <div class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-600 rounded-xl shadow-lg p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-xl font-bold text-white">🔒 Commitment Tetap (Tidak Dapat Diubah)</h3>
                        <p class="text-sm text-pink-100 mt-1">Target commitment untuk Rising Star 4 adalah <strong>70%</strong> dan tidak dapat diubah. Anda hanya perlu input realisasi untuk kedua kategori Asodomoro.</p>
                    </div>
                </div>
                <div class="text-right bg-white bg-opacity-20 px-6 py-4 rounded-lg backdrop-blur-sm">
                    <p class="text-5xl font-bold text-white">70%</p>
                    <p class="text-sm text-pink-100 font-semibold uppercase tracking-wide">Commitment</p>
                </div>
            </div>
        </div>

        <!-- Form Realisasi Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">✅ Input Realisasi Asodomoro</h2>
                        <p class="text-sm text-green-100 italic">Pilih kategori dan input realisasi</p>
                    </div>
                    <span class="bg-white text-green-700 text-xs font-semibold px-4 py-2 rounded-full uppercase shadow-md">Realisasi Only</span>
                </div>
            </div>

            <div class="p-8">
                <!-- Sub-tabs for Realisasi -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button onclick="showRealisasiTab('03bulan')" id="realisasi-tab-03bulan" class="flex-1 py-3 px-6 text-center font-semibold transition-all duration-300 realisasi-tab-button active-sub">
                        📅 Asodomoro 0-3 Bulan
                    </button>
                    <button onclick="showRealisasiTab('above3bulan')" id="realisasi-tab-above3bulan" class="flex-1 py-3 px-6 text-center font-semibold transition-all duration-300 realisasi-tab-button">
                        ⏰ Asodomoro >3 Bulan
                    </button>
                </div>

                <!-- Realisasi 0-3 Bulan -->
                <div id="realisasi-form-03bulan" class="realisasi-tab-content">
                    <form method="POST" action="{{ route('rising-star.asodomoro.store') }}">
                        @csrf
                        <input type="hidden" name="form_type" value="realisasi">
                        <input type="hidden" name="category" value="03bulan">

                        <div class="space-y-6 max-w-2xl mx-auto">
                            <div class="bg-pink-50 border-l-4 border-pink-500 p-4 rounded-lg mb-6">
                                <p class="text-sm text-pink-700">
                                    <strong>Info:</strong> Input realisasi ratio Asodomoro 0-3 Bulan. Commitment tetap <strong>70%</strong> untuk seluruh kategori.
                                </p>
                            </div>

                            <div>
                                <label for="ratio_aktual_03" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Ratio Asodomoro 0-3 Bulan (Realisasi) (%)</label>
                                <div class="relative mt-1">
                                    <input type="number" step="0.01" id="ratio_aktual_03" name="ratio_aktual" required 
                                           class="block w-full p-4 text-lg border-2 border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 transition" 
                                           placeholder="Masukkan ratio realisasi (contoh: 65, 70, 75)">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-pink-500 font-bold">%</span>
                                    </div>
                                </div>
                                @error('ratio_aktual')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold py-4 px-8 rounded-xl hover:from-pink-600 hover:to-purple-700 transition transform hover:scale-105 shadow-lg">
                                ✅ Simpan Realisasi 0-3 Bulan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Realisasi >3 Bulan -->
                <div id="realisasi-form-above3bulan" class="realisasi-tab-content hidden">
                    <form method="POST" action="{{ route('rising-star.asodomoro.store') }}">
                        @csrf
                        <input type="hidden" name="form_type" value="realisasi">
                        <input type="hidden" name="category" value="above3bulan">

                        <div class="space-y-6 max-w-2xl mx-auto">
                            <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded-lg mb-6">
                                <p class="text-sm text-purple-700">
                                    <strong>Info:</strong> Input realisasi ratio Asodomoro >3 Bulan. Commitment tetap <strong>70%</strong> untuk seluruh kategori.
                                </p>
                            </div>

                            <div>
                                <label for="ratio_aktual_above3" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Ratio Asodomoro >3 Bulan (Realisasi) (%)</label>
                                <div class="relative mt-1">
                                    <input type="number" step="0.01" id="ratio_aktual_above3" name="ratio_aktual" required 
                                           class="block w-full p-4 text-lg border-2 border-purple-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" 
                                           placeholder="Masukkan ratio realisasi (contoh: 65, 70, 75)">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-purple-500 font-bold">%</span>
                                    </div>
                                </div>
                                @error('ratio_aktual')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-4 px-8 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition transform hover:scale-105 shadow-lg">
                                ✅ Simpan Realisasi >3 Bulan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-pink-500 to-indigo-600 border-b border-gray-200">
                <h2 class="text-xl font-bold text-white">📊 Data Asodomoro (0-3 Bulan & >3 Bulan)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Ratio (%)</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $allData = collect($data03)->merge($dataAbove3)->sortByDesc('entry_date');
                        @endphp
                        @forelse($allData as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $item instanceof App\Models\Asodomoro03BulanData ? 'bg-pink-100 text-pink-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $item instanceof App\Models\Asodomoro03BulanData ? '0-3 Bulan' : '>3 Bulan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $item->type === 'komitmen' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($item->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ number_format((float)($item->nominal ?? 0), 2) }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('rising-star.asodomoro.delete', ['id' => $item->id, 'category' => $item instanceof App\Models\Asodomoro03BulanData ? '03bulan' : 'above3bulan']) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                                class="text-red-600 hover:text-red-900 font-semibold transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data untuk bulan ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Realisasi Sub-Tab Functions
function showRealisasiTab(tabName) {
    document.querySelectorAll('.realisasi-tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    document.querySelectorAll('.realisasi-tab-button').forEach(button => {
        button.classList.remove('active-sub', 'bg-purple-100', 'text-purple-700');
        button.classList.add('text-gray-600', 'hover:bg-gray-100');
    });
    
    document.getElementById('realisasi-form-' + tabName).classList.remove('hidden');
    const activeTab = document.getElementById('realisasi-tab-' + tabName);
    activeTab.classList.add('active-sub', 'bg-purple-100', 'text-purple-700');
    activeTab.classList.remove('text-gray-600', 'hover:bg-gray-100');
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    showRealisasiTab('03bulan');
});
</script>

<style>
.realisasi-tab-button.active-sub {
    background-color: #f3e8ff;
    color: #7c3aed;
}
</style>
@endsection
