@extends('layouts.app')

@section('title', 'UTIP Corrective')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-red-50 to-orange-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">🔧 UTIP Corrective</h1>
                    <p class="text-gray-600 text-lg">Periode: {{ $currentPeriod }}</p>
                </div>
                <a href="{{ route('collection.utip') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-orange-500 to-red-600 rounded-full"></div>
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

        <!-- Status Card -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <p class="text-orange-200 text-sm uppercase tracking-wide mb-2">Plan</p>
                    <p class="text-3xl font-bold">
                        @if($existingPlan)
                            Rp {{ number_format($existingPlan->nominal, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-orange-200 text-sm uppercase tracking-wide mb-2">Komitmen</p>
                    <p class="text-3xl font-bold">
                        @if($existingCommitment)
                            Rp {{ number_format($existingCommitment->nominal, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-orange-200 text-sm uppercase tracking-wide mb-2">Realisasi Terkini</p>
                    <p class="text-3xl font-bold">
                        @if($latestRealisasi)
                            Rp {{ number_format($latestRealisasi->nominal, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-orange-200 text-sm uppercase tracking-wide mb-2">Status</p>
                    <p class="text-2xl font-bold">
                        @if($existingCommitment && $latestRealisasi)
                            @if($latestRealisasi->nominal >= $existingCommitment->nominal)
                                ✓ Tercapai
                            @else
                                ⚠ Belum Tercapai
                            @endif
                        @else
                            - Belum Ada Data
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Forms -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('plan')" id="tab-plan" class="tab-button group relative min-w-0 flex-1 overflow-hidden bg-orange-50 py-4 px-4 text-center text-sm font-medium hover:bg-orange-100 focus:z-10 border-b-2 border-orange-500 text-orange-600">
                        <span>📝 Form Plan</span>
                    </button>
                    <button onclick="showTab('komitmen')" id="tab-komitmen" class="tab-button group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 border-b-2 border-transparent">
                        <span>📋 Form Komitmen</span>
                    </button>
                    <button onclick="showTab('realisasi')" id="tab-realisasi" class="tab-button group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 border-b-2 border-transparent">
                        <span>✅ Form Realisasi</span>
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- Form Plan -->
                <div id="content-plan" class="tab-content">
                    @if($existingPlan)
                        <div class="bg-orange-50 border-l-4 border-orange-500 p-6 rounded-r-lg">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-orange-800 font-semibold">Plan untuk periode ini sudah diinput: Rp {{ number_format($existingPlan->nominal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('collection.utip-corrective.plan.store') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">💰 Nominal Plan (Rp)</label>
                                <input type="number" name="nominal_plan" step="1" min="0" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" 
                                       placeholder="Masukkan nominal plan (contoh: 50000000)" required>
                                @error('nominal_plan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Nominal dalam Rupiah tanpa tanda titik atau koma</p>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:from-orange-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                💾 Simpan Plan
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Form Komitmen -->
                <div id="content-komitmen" class="tab-content hidden">
                    @if($hasMonthlyCommitment)
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-6 rounded-r-lg">
                            <div class="flex items-center">
                                <div class="text-2xl mr-4">ℹ️</div>
                                <div>
                                    <p class="text-amber-800 font-bold">Target Sudah Terkunci</p>
                                    <p class="text-sm text-amber-700">
                                        Anda telah menginput komitmen UTIP Corrective untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong>. Input baru hanya tersedia di bulan depan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('collection.utip-corrective.komitmen.store') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">💰 Nominal Komitmen (Rp)</label>
                                <input type="number" name="value" step="1" min="0" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" 
                                       placeholder="Masukkan nominal komitmen (contoh: 45000000)" required>
                                @error('value')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Nominal dalam Rupiah tanpa tanda titik atau koma</p>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:from-orange-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                💾 Simpan Komitmen
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Form Realisasi -->
                <div id="content-realisasi" class="tab-content hidden">
                    <form method="POST" action="{{ route('collection.utip-corrective.realisasi.store') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">💰 Nominal Realisasi (Rp)</label>
                            <input type="number" name="nominal_realisasi" step="1" min="0" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" 
                                   placeholder="Masukkan nominal realisasi (contoh: 40000000)" required>
                            @error('nominal_realisasi')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Nominal dalam Rupiah tanpa tanda titik atau koma</p>

                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:from-orange-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            ✅ Simpan Realisasi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white">📊 History Data - {{ $currentPeriod }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Input</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nominal (Rp)</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $item)
                            <tr class="hover:bg-orange-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->type == 'plan')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            📝 Plan
                                        </span>
                                    @elseif($item->type == 'komitmen')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            📋 Komitmen
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            ✅ Realisasi
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-orange-600">
                                    Rp {{ number_format($item->value ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $item->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="font-semibold">Belum ada data untuk periode ini</p>
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

<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active state from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('bg-orange-50', 'border-orange-500', 'text-orange-600');
            button.classList.add('bg-white', 'border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById('content-' + tabName).classList.remove('hidden');
        
        // Add active state to selected tab
        const activeTab = document.getElementById('tab-' + tabName);
        activeTab.classList.remove('bg-white', 'border-transparent', 'text-gray-500');
        activeTab.classList.add('bg-orange-50', 'border-orange-500', 'text-orange-600');
    }
</script>
@endsection
