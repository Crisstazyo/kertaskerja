@extends('layouts.app')

@section('title', 'Asodomoro >3 Bulan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-indigo-50 to-pink-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">⏰ Asodomoro >3 Bulan</h1>
                    <p class="text-gray-600 text-lg">Input Komitmen & Realisasi Asodomoro Periode Lebih dari 3 Bulan</p>
                </div>
                <a href="{{ route('rising-star.rising-star-4') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 via-indigo-500 to-pink-600 rounded-full"></div>
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

        <!-- Tab Navigation & Forms -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="flex border-b border-gray-200">
                <button onclick="showTab('komitmen')" id="tab-komitmen" class="flex-1 py-4 px-6 text-center font-bold transition-all duration-300 tab-button active">
                    📋 Form Komitmen (Target 70%)
                </button>
                <button onclick="showTab('realisasi')" id="tab-realisasi" class="flex-1 py-4 px-6 text-center font-bold transition-all duration-300 tab-button">
                    ✅ Form Realisasi
                </button>
            </div>

            <!-- Form Komitmen -->
            <div id="form-komitmen" class="tab-content p-8">
                @if($hasMonthlyCommitment)
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-6 mb-6 rounded-r-lg max-w-2xl mx-auto">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-amber-800">🔒 Target Sudah Terkunci</h3>
                                <p class="text-sm text-amber-700 mt-2">Target komitmen bulanan sudah pernah diinput untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong>. Form komitmen akan dapat diakses kembali di bulan depan.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <form method="POST" action="{{ route('rising-star.asodomoro-above-3-bulan.store') }}">
                        @csrf
                        <input type="hidden" name="form_type" value="komitmen">
                        <input type="hidden" name="target_ratio" value="70">

                        <div class="space-y-6 max-w-2xl mx-auto">
                            <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded-lg mb-6">
                                <p class="text-sm text-purple-700">
                                    <strong>Note:</strong> Target ratio tetap 70% dan tidak dapat diubah. Pastikan realisasi mencapai minimal 70% dari komitmen yang ditetapkan.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide text-center">Target Ratio Komitmen</label>
                                <div class="relative mt-1 mb-6">
                                    <input type="text" value="70" readonly class="block w-full p-4 text-4xl font-bold text-purple-700 border-2 border-purple-300 rounded-lg bg-purple-50 text-center cursor-not-allowed" placeholder="70">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-purple-500 font-bold text-2xl">%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-center text-gray-500 mb-6 italic">Target ratio tetap untuk Asodomoro >3 Bulan</p>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold py-4 px-8 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition transform hover:scale-105 shadow-lg">
                                💾 Simpan Komitmen
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Form Realisasi -->
            <div id="form-realisasi" class="tab-content p-8 hidden">
                <form method="POST" action="{{ route('rising-star.asodomoro-above-3-bulan.store') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="realisasi">

                    <div class="space-y-6 max-w-2xl mx-auto">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
                            <p class="text-sm text-blue-700">
                                <strong>Info:</strong> Input realisasi ratio Asodomoro >3 Bulan. Nilai realisasi sebaiknya mencapai minimal 70%.
                            </p>
                        </div>

                        <div>
                            <label for="ratio_aktual" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Ratio Asodomoro (Realisasi) (%)</label>
                            <div class="relative mt-1">
                                <input type="number" step="0.01" id="ratio_aktual" name="ratio_aktual" required 
                                       class="block w-full p-4 text-lg border-2 border-purple-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition" 
                                       placeholder="Masukkan ratio realisasi (contoh: 70, 75, 80)">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-purple-500 font-bold">%</span>
                                </div>
                            </div>
                            @error('ratio_aktual')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-pink-600 text-white font-bold py-4 px-8 rounded-xl hover:from-indigo-600 hover:to-pink-700 transition transform hover:scale-105 shadow-lg">
                            ✅ Simpan Realisasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 border-b border-gray-200">
                <h2 class="text-xl font-bold text-white">📊 Data Asodomoro >3 Bulan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Ratio (%)</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $item->type === 'komitmen' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800' }}">
                                        {{ ucfirst($item->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ number_format($item->nominal, 2) }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('rising-star.asodomoro-above-3-bulan.delete', $item->id) }}" method="POST" class="inline">
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
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
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
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'bg-purple-50', 'text-purple-700', 'border-b-2', 'border-purple-500');
        button.classList.add('text-gray-600', 'hover:bg-gray-50');
    });
    
    // Show selected tab and mark as active
    document.getElementById('form-' + tabName).classList.remove('hidden');
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.add('active', 'bg-purple-50', 'text-purple-700', 'border-b-2', 'border-purple-500');
    activeTab.classList.remove('text-gray-600', 'hover:bg-gray-50');
}

// Initialize first tab
document.addEventListener('DOMContentLoaded', function() {
    showTab('komitmen');
});
</script>

<style>
.tab-button.active {
    background-color: #faf5ff;
    color: #7c3aed;
    border-bottom: 2px solid #a855f7;
}
.tab-button:not(.active) {
    color: #4b5563;
}
.tab-button:not(.active):hover {
    background-color: #f9fafb;
}
</style>
@endsection
