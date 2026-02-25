@extends('layouts.app')

@section('title', 'CT0 - Combat the Churn')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-cyan-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📊 CT0</h1>
                    <p class="text-gray-600 text-lg">Customer Touch Zero - SSL Tracking</p>
                </div>
                <a href="{{ route('ctc.combat-the-churn') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-cyan-500 to-indigo-600 rounded-full"></div>
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

        <!-- Form Realisasi Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">✅ Input Realisasi CT0</h2>
                        <p class="text-sm text-green-100 italic">Masukkan realisasi SSL CT0</p>
                    </div>
                    <span class="bg-white text-green-700 text-xs font-semibold px-4 py-2 rounded-full uppercase shadow-md">Realisasi</span>
                </div>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('ctc.combat-the-churn.store') }}" class="max-w-lg mx-auto space-y-6">
                    @csrf
                    <input type="hidden" name="form_type" value="realisasi">
                    <input type="hidden" name="category" value="ct0">
                    <input type="hidden" name="region" value="inner_sumut">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">📊 Kuantitas SSL</label>
                        <input type="number" name="quantity" step="1" min="0" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                               placeholder="Masukkan jumlah SSL (contoh: 90)">
                        <p class="mt-1 text-xs text-gray-500">Jumlah SSL dalam satuan kuantitas</p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        💾 Simpan Realisasi
                    </button>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white uppercase tracking-wider">
                    📊 Data CT0
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">No</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Region</th>
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
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <div class="text-5xl mb-4">📊</div>
                                <p class="text-lg font-semibold">Belum ada data CT0</p>
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
@endsection
