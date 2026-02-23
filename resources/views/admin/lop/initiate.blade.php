@extends('layouts.app')

@section('title', 'LOP Initiate - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <a href="{{ route('admin.lop.category-select', [$entity, 'scalling']) }}" class="mr-4 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">🚀 LOP Initiate</h1>
                        <p class="text-gray-600">{{ ucfirst($entity) }} - Add & View Data</p>
                    </div>
                </div>
                <a href="{{ route('admin.lop.initiate.history', $entity) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md">
                    📜 History
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full"></div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border-2 border-purple-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🔍 Filter Data</h2>
            <form method="GET" action="{{ route('admin.lop.initiate', $entity) }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                        <select name="month" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-purple-500 focus:border-purple-500 p-2.5">
                            <option value="">Semua Bulan</option>
                            <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>April</option>
                            <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <select name="year" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-purple-500 focus:border-purple-500 p-2.5">
                            <option value="">Semua Tahun</option>
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white px-8 py-2.5 rounded-lg font-semibold transition-all duration-300 shadow-md w-full">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Data Button -->
        <div class="mb-6">
            <button onclick="toggleForm()" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md">
                ➕ Tambah Data Baru
            </button>
        </div>

        <!-- Add Data Form (Hidden by default) -->
        <div id="addForm" class="hidden mb-6 bg-white rounded-xl shadow-lg p-6 border-2 border-purple-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📝 Tambah Data LOP Initiate</h2>
            <form action="{{ route('admin.lop.initiate.store', $entity) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan <span class="text-red-500">*</span></label>
                        <select name="month" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Bulan</option>
                            <option value="1" {{ request('month', date('n')) == 1 ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ request('month', date('n')) == 2 ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ request('month', date('n')) == 3 ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ request('month', date('n')) == 4 ? 'selected' : '' }}>April</option>
                            <option value="5" {{ request('month', date('n')) == 5 ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ request('month', date('n')) == 6 ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ request('month', date('n')) == 7 ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ request('month', date('n')) == 8 ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ request('month', date('n')) == 9 ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('month', date('n')) == 10 ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('month', date('n')) == 11 ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('month', date('n')) == 12 ? 'selected' : '' }}>Desember</option>
                        </select>
                        @error('month')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun <span class="text-red-500">*</span></label>
                        <select name="year" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Tahun</option>
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        @error('year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No</label>
                        <input type="text" name="no" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Project <span class="text-red-500">*</span></label>
                        <input type="text" name="project" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ID LOP</label>
                        <input type="text" name="id_lop" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CC</label>
                        <input type="text" name="cc" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIPNAS</label>
                        <input type="text" name="nipnas" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">AM</label>
                        <input type="text" name="am" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mitra</label>
                        <input type="text" name="mitra" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Plan Bulan Billcom P 2025</label>
                        <input type="text" name="plan_bulan_billcom_p_2025" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Est Nilai BC</label>
                        <input type="text" name="est_nilai_bc" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="toggleForm()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-semibold transition-all duration-300">
                        Batal
                    </button>
                    <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        @if($data->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 text-white">
                <h2 class="text-xl font-bold">📋 Data LOP Initiate</h2>
                <p class="text-sm text-purple-100">Total: {{ $data->count() }} data</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Project</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID LOP</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">CC</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">NIPNAS</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">AM</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Mitra</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Plan Bulan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Est Nilai BC</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->no }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->project }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->id_lop }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->cc }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->nipnas }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->am }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->mitra }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->plan_bulan_billcom_p_2025 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->est_nilai_bc }}</td>
                            <td class="px-4 py-3 text-sm">
                                <form action="{{ route('admin.lop.initiate.delete', [$entity, $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-gray-100">
            <span class="text-6xl mb-4 block">📭</span>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data</h3>
            <p class="text-gray-600">Klik tombol "Tambah Data Baru" untuk mulai menambahkan data</p>
        </div>
        @endif
    </div>
</div>

<script>
function toggleForm() {
    const form = document.getElementById('addForm');
    form.classList.toggle('hidden');
}
</script>
@endsection
