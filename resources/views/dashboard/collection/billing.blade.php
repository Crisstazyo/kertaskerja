@extends('layouts.app')

@section('title', 'Billing Perdana Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-purple-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert">
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert">
                <p class="font-bold">Error!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert">
                <p class="font-bold">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📄Billing Perdana</h1>
                    <p class="text-gray-600 text-lg">Billing Perdana</p>
                </div>
                <a href="{{ route('dashboard.collection') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali ke Dashboard
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full"></div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="flex border-b border-gray-100 bg-gray-50/50">
                <button onclick="switchTab('komitmen')" id="tab-komitmen" class="flex-1 py-4 text-center font-bold text-purple-600 border-b-4 border-purple-500 transition-all">
                    📝 Form Komitmen (Bulanan)
                </button>
                <button onclick="switchTab('realisasi')" id="tab-realisasi" class="flex-1 py-4 text-center font-bold text-gray-500 hover:text-purple-500 border-b-4 border-transparent transition-all">
                    ✅ Form Realisasi (Harian)
                </button>
            </div>

            <div class="p-8">
                <div id="content-komitmen" class="space-y-6">
                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Komitmen Bulanan</h2>
                            <p class="text-sm text-gray-500 italic">Target penagihan Anda untuk bulan ini.</p>
                        </div>
                        <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Periode: {{ now()->translatedFormat('F Y') }}</span>
                    </div>
                    
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-6 rounded-r-lg">
                            <div class="flex items-center">
                                <div class="text-2xl mr-4">ℹ️</div>
                                <div>
                                    <p class="text-amber-800 font-bold">Target Sudah Terkunci</p>
                                    <p class="text-sm text-amber-700">
                                        Target ratio untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong> telah ditambahkan. Input baru hanya tersedia di bulan depan.
                                    </p>
                                </div>
                            </div>
                        </div>
                            <!-- <input type="hidden" name="commitment" value="98"> -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide text-center">Target Ratio Billing Perdana</label>
                                <div class="relative mt-1">
                                    <input type="text" value="{{ $bill->first()->commitment ?? 0 }}" readonly class="block w-full p-4 text-4xl font-bold text-purple-700 border-2 border-purple-300 rounded-lg bg-purple-50 text-center" placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-purple-500 font-bold text-2xl">%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-center text-gray-500 mt-2 italic">Target tetap untuk periode ini</p>
                            </div>
                    </div>

                <div id="content-realisasi" class="hidden space-y-6">
                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Input Realisasi C3MR</h2>
                            <p class="text-sm text-gray-500 italic">Catat realisasi ratio harian.</p>
                        </div>
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full uppercase">Harian</span>
                    </div>

                    <form action="{{ route('collection.billing.storeRealisasi') }}" method="POST" class="max-w-lg mx-auto space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Realisasi C3MR (%)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="ratio_aktual" required class="w-full p-4 text-2xl font-bold text-green-600 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold text-xl">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-bold shadow-md transition-all">Simpan Realisasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gray-800 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white uppercase tracking-wider">
                    📜 Riwayat Aktivitas C3MR
                </h3>
                <span class="text-xs text-gray-400 italic">Hanya Baca (Data Permanen)</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="p-4 font-bold text-xs uppercase text-gray-600 text-center">Tanggal Input</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600 text-center">Tipe</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600 text-center">Ratio (%)</th>
                            <th class="p-4 font-bold text-xs uppercase text-gray-600 text-center">Komitmen (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($activities as $activity)
                            <tr class="{{ $activity->type == 'C3MR' ? 'bg-purple-50/30' : '' }}">
                                <td class="p-4 text-sm text-center text-gray-600 font-medium">{{ $activity->updated_at->translatedFormat('d M Y') }}</td>
                                <td class="p-4 text-center">
                                    @if($activity->type == 'Billing Perdana')
                                        <span class="bg-purple-600 text-white px-2 py-1 rounded text-[10px] font-bold uppercase">Target Bulanan</span>
                                    @else
                                        <span class="bg-green-100 text-green-700 border border-green-200 px-2 py-1 rounded text-[10px] font-bold uppercase">Realisasi</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center font-bold {{ $activity->type == 'C3MR' ? 'text-purple-700' : 'text-green-600' }}">
                                    {{ number_format($activity->real_ratio ?? 0, 2) }}%
                                </td>
                                <td class="p-4 text-center font-bold {{ $activity->type == 'C3MR' ? 'text-purple-700' : 'text-green-600' }}">
                                    {{$bill->first()->commitment ?? 0}}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400 italic">
                                    Belum ada data aktivitas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 p-4 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 font-medium tracking-widest uppercase">*** Seluruh data telah tervalidasi dan tidak dapat diubah kembali ***</p>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        const kTab = document.getElementById('tab-komitmen');
        const rTab = document.getElementById('tab-realisasi');
        const kContent = document.getElementById('content-komitmen');
        const rContent = document.getElementById('content-realisasi');

        if (tab === 'komitmen') {
            kTab.classList.add('text-purple-600', 'border-purple-500');
            kTab.classList.remove('text-gray-500', 'border-transparent');
            rTab.classList.add('text-gray-500', 'border-transparent');
            rTab.classList.remove('text-purple-600', 'border-purple-500');
            kContent.classList.remove('hidden');
            rContent.classList.add('hidden');
        } else {
            rTab.classList.add('text-purple-600', 'border-purple-500');
            rTab.classList.remove('text-gray-500', 'border-transparent');
            kTab.classList.add('text-gray-500', 'border-transparent');
            kTab.classList.remove('text-purple-600', 'border-purple-500');
            rContent.classList.remove('hidden');
            kContent.classList.add('hidden');
        }
    }
</script>
@endsection