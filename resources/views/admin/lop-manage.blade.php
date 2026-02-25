@extends('layouts.app')

@section('title', 'Kelola ' . ($lopCategory === 'none' ? 'PSAK' : 'LOP'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    @if($type === 'scalling')
                    <a href="{{ route('admin.select-type', [$role, $type]) }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Kembali ke Pilih LOP
                    </a>
                    @else
                    <a href="{{ route('admin.select-role', $role) }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Kembali ke Pilih Tipe
                    </a>
                    @endif
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ ucfirst($role) }} - 
                        @if($lopCategory === 'none')
                            PSAK
                        @else
                            {{ str_replace('_', ' ', ucwords($lopCategory)) }}
                        @endif
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola worksheet dan data</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Tambah Tabel -->
            <button onclick="toggleCreateModal()" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-purple-500 hover:shadow-md transition-all overflow-hidden text-left">
                <div class="bg-purple-600 p-6 text-white">
                    <h2 class="text-xl font-semibold mb-1">Tambah Tabel</h2>
                    <p class="text-purple-100 text-sm">Buat worksheet baru</p>
                </div>
                <div class="p-4">
                    <span class="text-purple-600 font-medium text-sm">Klik untuk buat</span>
                </div>
            </button>

            <!-- Lihat Data -->
            <a href="{{ route('admin.view-data', [$role, $type, $lopCategory]) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all overflow-hidden">
                <div class="bg-blue-600 p-6 text-white">
                    <h2 class="text-xl font-semibold mb-1">Lihat Data</h2>
                    <p class="text-blue-100 text-sm">Worksheet aktif</p>
                </div>
                <div class="p-4">
                    <span class="text-blue-600 font-medium text-sm">Lihat worksheet</span>
                </div>
            </a>

            <!-- Lihat Riwayat -->
            <a href="{{ route('admin.view-history', [$role, $type, $lopCategory]) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-green-500 hover:shadow-md transition-all overflow-hidden">
                <div class="bg-green-600 p-6 text-white">
                    <h2 class="text-xl font-semibold mb-1">Lihat Riwayat</h2>
                    <p class="text-green-100 text-sm">Semua worksheet</p>
                </div>
                <div class="p-4">
                    <span class="text-green-600 font-medium text-sm">Lihat riwayat</span>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Create Worksheet Modal -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-4">Buat Worksheet Baru</h3>
        <p class="text-gray-600 mb-6">Worksheet akan berisi 8 baris kosong yang siap diisi</p>
        
        <form action="{{ route('admin.create-worksheet') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="lop_category" value="{{ $lopCategory }}">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select name="month" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Pilih Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <input type="number" name="year" value="{{ date('Y') }}" min="2024" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    Buat Worksheet
                </button>
                <button type="button" onclick="toggleCreateModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCreateModal() {
    document.getElementById('createModal').classList.toggle('hidden');
}
</script>
@endsection
