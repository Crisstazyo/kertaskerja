@extends('layouts.app')

@section('title', 'Admin - Paid CT0 Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.ctc.dashboard') }}" class="text-cyan-600 hover:text-cyan-800 mb-2 inline-block text-sm font-medium">
                        ← Kembali ke CTC Management
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">💰 Admin — Paid CT0</h1>
                    <p class="text-gray-600">Kelola data Paid CT0 semua user</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Input Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center space-x-2">
                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Input Data Paid CT0</span>
            </h2>
            <form action="{{ route('admin.ctc.paid-ct0.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">User</label>
                    <select name="user_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500 bg-white">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Tipe</label>
                    <select name="form_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500 bg-white">
                        <option value="komitmen">Komitmen</option>
                        <option value="realisasi">Realisasi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Region</label>
                    <input type="text" name="region" required placeholder="cth: Jawa Barat" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Nominal</label>
                    <input type="number" name="nominal" required step="0.01" placeholder="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500">
                </div>
                <div class="md:col-span-2 lg:col-span-4 flex justify-end space-x-3 pt-2">
                    <button type="reset" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium transition-colors">Reset</button>
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Data</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-cyan-50 to-blue-50">
                <div class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Filter User</label>
                        <select id="filterUser" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500 bg-white" onchange="filterTable()">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->name }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Bulan</label>
                        <select id="filterBulan" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500 bg-white" onchange="filterTable()">
                            <option value="">Semua Bulan</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Tahun</label>
                        <select id="filterTahun" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500 bg-white" onchange="filterTable()">
                            <option value="">Semua Tahun</option>
                            @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Tipe</label>
                        <select id="filterTipe" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500 bg-white" onchange="filterTable()">
                            <option value="">Semua Tipe</option>
                            <option value="komitmen">Komitmen</option>
                            <option value="realisasi">Realisasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Pencarian</label>
                        <input type="text" id="filterSearch" placeholder="Cari region, user..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-cyan-500" oninput="filterTable()">
                    </div>
                    <button onclick="resetFilters()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">Reset</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="dataTable">
                    <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase">No</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase">User</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase">Tipe</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase">Region</th>
                            <th class="px-5 py-3 text-right text-xs font-bold uppercase">Nominal</th>
                            <th class="px-5 py-3 text-center text-xs font-bold uppercase">Bulan</th>
                            <th class="px-5 py-3 text-center text-xs font-bold uppercase">Tahun</th>
                            <th class="px-5 py-3 text-center text-xs font-bold uppercase">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $index => $item)
                        <tr class="hover:bg-cyan-50 transition-colors">
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-5 py-3">
                                <span class="text-sm font-medium text-gray-900">{{ $item->user->name ?? 'Unknown' }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-bold {{ $item->type === 'komitmen' ? 'bg-cyan-100 text-cyan-700' : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-700">{{ $item->region ?? '-' }}</td>
                            <td class="px-5 py-3 text-right text-sm font-bold text-cyan-700">
                                {{ $item->nominal ? number_format($item->nominal, 2, ',', '.') : '-' }}
                            </td>
                            <td class="px-5 py-3 text-center text-sm text-gray-600">{{ date('F', mktime(0,0,0,$item->month,1)) }}</td>
                            <td class="px-5 py-3 text-center text-sm text-gray-600">{{ $item->year }}</td>
                            <td class="px-5 py-3 text-center text-sm text-gray-500">
                                {{ $item->entry_date ? \Carbon\Carbon::parse($item->entry_date)->format('d M Y') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                                <p>Belum ada data Paid CT0</p>
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
function filterTable() {
    const userVal   = (document.getElementById('filterUser')?.value   || '').toLowerCase();
    const bulanVal  = (document.getElementById('filterBulan')?.value  || '').toLowerCase();
    const tahunVal  = (document.getElementById('filterTahun')?.value  || '').toLowerCase();
    const tipeVal   = (document.getElementById('filterTipe')?.value   || '').toLowerCase();
    const searchVal = (document.getElementById('filterSearch')?.value || '').toLowerCase();

    const rows = document.querySelectorAll('#dataTable tbody tr');
    rows.forEach(function(row) {
        const cells = row.getElementsByTagName('td');
        if (cells.length < 7) return;
        const userName = (cells[1].textContent || '').trim().toLowerCase();
        const tipe     = (cells[2].textContent || '').trim().toLowerCase();
        const bulan    = (cells[5].textContent || '').trim().toLowerCase();
        const tahun    = (cells[6].textContent || '').trim().toLowerCase();
        const rowFull  = (row.textContent || '').trim().toLowerCase();
        const show = (!userVal   || userName.includes(userVal))
                  && (!bulanVal  || bulan.includes(bulanVal))
                  && (!tahunVal  || tahun.includes(tahunVal))
                  && (!tipeVal   || tipe.includes(tipeVal))
                  && (!searchVal || rowFull.includes(searchVal));
        row.style.display = show ? '' : 'none';
    });
}
function resetFilters() {
    ['filterUser','filterBulan','filterTahun','filterTipe'].forEach(id => { const el = document.getElementById(id); if(el) el.value=''; });
    const s = document.getElementById('filterSearch'); if(s) s.value='';
    filterTable();
}
</script>
@endsection
