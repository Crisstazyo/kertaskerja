@extends('layouts.app')

@section('title', 'Visiting GM')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">👔 Visiting GM</h1>
                    <p class="text-gray-600 text-lg">Input Komitmen & Realisasi Visiting General Manager</p>
                </div>
                <a href="{{ route('rising-star.rising-star-1') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 rounded-full"></div>
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

        <!-- Tab Navigation & Forms -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="flex border-b border-gray-200">
                <button onclick="showTab('komitmen')" id="tab-komitmen" class="flex-1 py-4 px-6 text-center font-bold transition-all duration-300 tab-button active">
                    📋 Form Komitmen (Target 110%)
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
                                <p class="text-sm text-amber-700 mt-2">Target komitmen bulanan sudah pernah diinput untuk bulan ini. Form komitmen akan dapat diakses kembali pada bulan berikutnya.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <form method="POST" action="{{ route('rising-star.visiting-gm.store') }}">
                        @csrf
                        <input type="hidden" name="form_type" value="komitmen">
                        <input type="hidden" name="target_ratio" value="110">

                        <div class="space-y-6 max-w-2xl mx-auto">
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
                                <p class="text-sm text-blue-700">
                                    <strong>Note:</strong> Target ratio tetap 110% dan tidak dapat diubah. Pastikan realisasi mencapai minimal 110% dari komitmen yang ditetapkan.
                                </p>
                            </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">🎯 Target Ratio Komitmen</label>
                            <div class="relative mt-1 mb-6">
                                <input type="text" value="110" readonly class="block w-full p-4 text-4xl font-bold text-blue-700 border-2 border-blue-300 rounded-lg bg-blue-50 text-center cursor-not-allowed" placeholder="110">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-blue-500 font-bold text-2xl">%</span>
                                </div>
                            </div>
                            <p class="text-xs text-center text-gray-500 mb-6 italic">Target ratio tetap untuk semua visiting GM</p>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-4 px-8 rounded-xl hover:from-blue-600 hover:to-indigo-700 transition transform hover:scale-105 shadow-lg">
                            💾 Simpan Komitmen
                        </button>
                    </div>
                </form>
                @endif
            </div>

            <!-- Form Realisasi -->
            <div id="form-realisasi" class="tab-content p-8 hidden">
                <form method="POST" action="{{ route('rising-star.visiting-gm.store') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="realisasi">

                    <div class="space-y-6 max-w-2xl mx-auto">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">� Ratio Visiting (Realisasi) (%)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="ratio_aktual" placeholder="Masukkan ratio (contoh: 105.00)" required
                                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold text-xl">%</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Ratio realisasi visiting yang telah dicapai</p>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-bold py-4 px-8 rounded-xl hover:from-indigo-600 hover:to-blue-700 transition transform hover:scale-105 shadow-lg">
                            ✅ Simpan Realisasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-blue-500 to-indigo-600">
                <h3 class="text-2xl font-bold text-white">📊 Data Visiting GM</h3>
                <p class="text-blue-100 mt-1">Menampilkan semua data visiting General Manager</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Ratio (%)</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->type == 'komitmen')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        📋 Komitmen
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✅ Realisasi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                @if($item->type == 'komitmen')
                                    {{ number_format($item->target_ratio, 2) }}%
                                @else
                                    {{ number_format($item->ratio_aktual, 2) }}%
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada data</p>
                                    <p class="text-sm">Silakan input data menggunakan form di atas</p>
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

<style>
    .tab-button {
        color: #6B7280;
        background: transparent;
    }
    .tab-button.active {
        color: #3B82F6;
        background: linear-gradient(to bottom, transparent 0%, rgba(59, 130, 246, 0.1) 100%);
        border-bottom: 3px solid #3B82F6;
    }
</style>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById('form-' + tabName).classList.remove('hidden');
    document.getElementById('tab-' + tabName).classList.add('active');
}
</script>
@endsection
