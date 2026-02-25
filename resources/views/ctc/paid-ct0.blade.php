@extends('layouts.app')

@section('title', 'Paid CT0 - CTC')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">💰 Paid Pra CT0</h1>
                    <p class="text-gray-600 text-lg">Input Komitmen & Realisasi per Region</p>
                </div>
                <a href="{{ route('ctc.dashboard') }}" class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-600 rounded-full"></div>
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

        <!-- Filter Region Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">🗺️ Select Region</label>
                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent" name="region" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ request('region') == 'all' || !request('region') ? 'selected' : '' }}>All Regions</option>
                        <option value="inner_sumut" {{ request('region') == 'inner_sumut' ? 'selected' : '' }}>Inner Sumut</option>
                        <option value="telda_lubuk_pakam" {{ request('region') == 'telda_lubuk_pakam' ? 'selected' : '' }}>Telda Lubuk Pakam</option>
                        <option value="telda_binjai" {{ request('region') == 'telda_binjai' ? 'selected' : '' }}>Telda Binjai</option>
                        <option value="telda_siantar" {{ request('region') == 'telda_siantar' ? 'selected' : '' }}>Telda Siantar</option>
                        <option value="telda_kisaran" {{ request('region') == 'telda_kisaran' ? 'selected' : '' }}>Telda Kisaran</option>
                        <option value="telda_kabanjahe" {{ request('region') == 'telda_kabanjahe' ? 'selected' : '' }}>Telda Kabanjahe</option>
                        <option value="telda_rantau_prapat" {{ request('region') == 'telda_rantau_prapat' ? 'selected' : '' }}>Telda Rantau Prapat</option>
                        <option value="telda_toba" {{ request('region') == 'telda_toba' ? 'selected' : '' }}>Telda Toba</option>
                        <option value="telda_sibolga" {{ request('region') == 'telda_sibolga' ? 'selected' : '' }}>Telda Sibolga</option>
                        <option value="telda_padang_sidempuan" {{ request('region') == 'telda_padang_sidempuan' ? 'selected' : '' }}>Telda Padang Sidempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">&nbsp;</label>
                    <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white py-3 px-6 rounded-lg font-bold hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">
                        🔍 Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Forms Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('komitmen')" id="tab-komitmen" class="tab-button group relative min-w-0 flex-1 overflow-hidden bg-cyan-50 py-4 px-4 text-center text-sm font-medium hover:bg-cyan-100 focus:z-10 border-b-2 border-cyan-500 text-cyan-600">
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
                            <h2 class="text-2xl font-bold text-gray-800">Input Komitmen</h2>
                            <p class="text-sm text-gray-500 italic">Masukkan target komitmen per region</p>
                        </div>
                        <span class="bg-cyan-100 text-cyan-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Komitmen</span>
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
                        <form method="POST" action="{{ route('ctc.paid-ct0.store') }}" class="max-w-lg mx-auto space-y-6">
                            @csrf
                            <input type="hidden" name="form_type" value="komitmen">
                            <input type="hidden" name="region" value="{{ request('region', 'inner_sumut') }}">

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">💰 Nominal Komitmen (Rp)</label>
                                <input type="number" name="nominal" step="1" min="0" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent" 
                                       placeholder="Masukkan nominal komitmen (contoh: 50000000)">
                                <p class="mt-1 text-xs text-gray-500">Nominal dalam Rupiah tanpa tanda titik atau koma</p>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                💾 Simpan Komitmen
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Form Realisasi -->
                <div id="content-realisasi" class="tab-content hidden">
                    <div class="flex items-center justify-between border-b pb-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Input Realisasi</h2>
                            <p class="text-sm text-gray-500 italic">Masukkan realisasi pencapaian per region</p>
                        </div>
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Realisasi</span>
                    </div>

                    <form method="POST" action="{{ route('ctc.paid-ct0.store') }}" class="max-w-lg mx-auto space-y-6">
                        @csrf
                        <input type="hidden" name="form_type" value="realisasi">
                        <input type="hidden" name="region" value="{{ request('region', 'inner_sumut') }}">

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">💵 Nominal Realisasi (Rp)</label>
                            <input type="number" name="nominal" step="1" min="0" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                   placeholder="Masukkan nominal realisasi (contoh: 45000000)">
                            <p class="mt-1 text-xs text-gray-500">Nominal dalam Rupiah tanpa tanda titik atau koma</p>
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
            <div class="bg-gray-800 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white uppercase tracking-wider">
                    📊 Data Paid Pra CT0 - 
                    @if(request('region') != 'all' && request('region'))
                        {{ ucwords(str_replace('_', ' ', request('region'))) }}
                    @else
                        All Regions
                    @endif
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">No</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Region</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Type</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600 text-right">Nominal (Rp)</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Tanggal</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600">Keterangan</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($data as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm font-medium text-gray-800">{{ $item->formatted_region }}</td>
                            <td class="p-4 text-sm">
                                @if($item->type == 'komitmen')
                                    <span class="bg-cyan-100 text-cyan-700 px-2 py-1 rounded text-xs font-semibold">📋 Komitmen</span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">✅ Realisasi</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-gray-800 text-right font-semibold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td class="p-4 text-sm text-gray-600">{{ $item->entry_date->translatedFormat('d M Y') }}</td>
                            <td class="p-4 text-sm text-gray-600 italic">{{ $item->description ?? '-' }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('ctc.paid-ct0.delete', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition-all">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">
                                <div class="text-4xl mb-2">📭</div>
                                <p class="font-semibold">Belum ada data</p>
                                <p class="text-sm">Silakan input data komitmen dan realisasi</p>
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
    
    // Remove active state from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('bg-cyan-50', 'border-cyan-500', 'text-cyan-600', 'bg-green-50', 'border-green-500', 'text-green-600');
        button.classList.add('bg-white', 'border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active state to selected button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('bg-white', 'border-transparent', 'text-gray-500');
    
    if (tabName === 'komitmen') {
        activeButton.classList.add('bg-cyan-50', 'border-cyan-500', 'text-cyan-600');
    } else {
        activeButton.classList.add('bg-green-50', 'border-green-500', 'text-green-600');
    }
}
</script>
@endsection
