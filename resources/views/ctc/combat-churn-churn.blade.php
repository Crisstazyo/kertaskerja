@extends('layouts.app')

@section('title', 'Churn - Combat the Churn')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-orange-50 to-pink-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">⚠️ Churn</h1>
                    <p class="text-gray-600 text-lg">Customer Churn Prevention - SSL Tracking</p>
                </div>
                <a href="{{ route('ctc.combat-the-churn') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-red-500 via-orange-500 to-pink-600 rounded-full"></div>
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

        <!-- Forms Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('komitmen')" id="tab-komitmen" class="tab-button group relative min-w-0 flex-1 overflow-hidden bg-red-50 py-4 px-4 text-center text-sm font-medium hover:bg-red-100 focus:z-10 border-b-2 border-red-500 text-red-600">
                        <span>📋 Form Komitmen</span>
                    </button>
                    <button onclick="showTab('realisasi')" id="tab-realisasi" class="tab-button group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 border-b-2 border-transparent">
                        <span>✅ Form Realisasi</span>
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- Form Komitmen -->
                <div id="content-komitmen" class="tab-content">
                    <div class="flex items-center justify-between border-b pb-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Input Komitmen Churn</h2>
                            <p class="text-sm text-gray-500 italic">Masukkan target komitmen SSL per region</p>
                        </div>
                        <span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Komitmen</span>
                    </div>

                    @if($hasMonthlyCommitment)
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-6 mb-6 rounded-r-lg">
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
                        <form method="POST" action="{{ route('ctc.combat-the-churn.store') }}" class="max-w-lg mx-auto space-y-6">
                            @csrf
                            <input type="hidden" name="form_type" value="komitmen">
                            <input type="hidden" name="category" value="churn">
                            <input type="hidden" name="region" value="inner_sumut">

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">📊 Kuantitas SSL</label>
                                <input type="number" name="quantity" step="1" min="0" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                                       placeholder="Masukkan jumlah SSL (contoh: 100)">
                                <p class="mt-1 text-xs text-gray-500">Jumlah SSL dalam satuan kuantitas</p>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-orange-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:from-red-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                💾 Simpan Komitmen
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Form Realisasi -->
                <div id="content-realisasi" class="tab-content hidden">
                    <div class="flex items-center justify-between border-b pb-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Input Realisasi Churn</h2>
                            <p class="text-sm text-gray-500 italic">Masukkan realisasi SSL per region</p>
                        </div>
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Realisasi</span>
                    </div>

                    <form method="POST" action="{{ route('ctc.combat-the-churn.store') }}" class="max-w-lg mx-auto space-y-6">
                        @csrf
                        <input type="hidden" name="form_type" value="realisasi">
                        <input type="hidden" name="category" value="churn">
                        <input type="hidden" name="region" value="inner_sumut">

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">📊 Kuantitas SSL</label>
                            <input type="number" name="quantity" step="1" min="0" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                   placeholder="Masukkan jumlah SSL (contoh: 90)">
                            <p class="mt-1 text-xs text-gray-500">Jumlah SSL dalam satuan kuantitas</p>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            💾 Simpan Realisasi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-red-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white uppercase tracking-wider">
                    📊 Data Churn
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">No</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Region</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Type</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Quantity (SSL)</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Date</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $item->region)) }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $item->type == 'komitmen' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-bold text-gray-900">{{ number_format($item->quantity) }} SSL</td>
                            <td class="p-4 text-sm text-gray-600">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <form action="{{ route('ctc.combat-the-churn.delete', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                <div class="text-5xl mb-4">📊</div>
                                <p class="text-lg font-semibold">Belum ada data Churn</p>
                                <p class="text-sm">Silakan tambahkan data melalui form di atas</p>
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
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('bg-red-50', 'text-red-600', 'border-red-500');
        button.classList.add('bg-white', 'text-gray-500', 'border-transparent');
    });
    
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('bg-white', 'text-gray-500', 'border-transparent');
    activeButton.classList.add('bg-red-50', 'text-red-600', 'border-red-500');
}
</script>
@endsection
