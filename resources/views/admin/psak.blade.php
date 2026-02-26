@extends('layouts.app')

@section('title', 'Admin - PSAK ' . ucfirst($role))

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5"
                style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            PSAK <span class="text-red-600">{{ ucfirst($role) }}</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Admin mengelola semua data Commitment & Realisasi</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-slate-900 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-red-200">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ FLASH MESSAGES ══ --}}
        @if(session('success'))
        <div class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- ══ INPUT FORM ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Data PSAK</h2>
            </div>

            <form action="{{ route('admin.psak.store', $role) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Periode</label>
                        <input type="month" name="periode" required value="{{ date('Y-m') }}"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                        @error('periode')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Pilih Segmen</label>
                        <select name="segment" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors bg-white">
                            <option value="">— Pilih Segmen —</option>
                            <option value="nc_step14">Not Close Step 1-4</option>
                            <option value="nc_step5">Not Close Step 5</option>
                            <option value="nc_konfirmasi">Not Close Konfirmasi</option>
                            <option value="nc_splitbill">Not Close Split Bill</option>
                            <option value="nc_crvariable">Not Close CR Variable</option>
                            <option value="nc_unidentified">Not Close Unidentified KB</option>
                        </select>
                        @error('segment')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    {{-- Order --}}
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-5">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-1 h-5 bg-red-600 rounded-full"></div>
                            <h3 class="text-xs font-black text-slate-700 uppercase tracking-widest">Format Order</h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Commitment (Order)</label>
                                <input type="number" name="commitment_order" step="0.01" placeholder="cth: 150.50"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors bg-white">
                                @error('commitment_order')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Realisasi (Order)</label>
                                <input type="number" name="real_order" step="0.01" placeholder="cth: 140.75"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors bg-white">
                                @error('real_order')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Rupiah --}}
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-5">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-1 h-5 bg-red-600 rounded-full"></div>
                            <h3 class="text-xs font-black text-slate-700 uppercase tracking-widest">Format Rupiah</h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Commitment (Rp)</label>
                                <input type="number" name="commitment_rp" step="0.01" placeholder="cth: 50000000"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors bg-white">
                                @error('commitment_rp')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Realisasi (Rp)</label>
                                <input type="number" name="real_rp" step="0.01" placeholder="cth: 48000000"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors bg-white">
                                @error('real_rp')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="reset"
                        class="flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-5 py-2.5 rounded-lg transition-all duration-200 uppercase tracking-wider">
                        <span>Reset</span>
                    </button>
                    <button type="submit"
                        class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-2.5 rounded-lg transition-all duration-200 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Data</span>
                    </button>
                </div>
            </form>
        </div>

        @if($psakData->count() > 0)

        {{-- ══ FILTER ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                <h3 class="text-base font-black text-slate-900 uppercase tracking-wide">Filter & Pencarian</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Segmen</label>
                    <select id="masterFilterSegmen"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400 bg-white">
                        <option value="">Semua Segmen</option>
                        <option value="Not Close Step 1-4">Not Close Step 1-4</option>
                        <option value="Not Close Step 5">Not Close Step 5</option>
                        <option value="Not Close Konfirmasi">Not Close Konfirmasi</option>
                        <option value="Not Close Split Bill">Not Close Split Bill</option>
                        <option value="Not Close CR Variable">Not Close CR Variable</option>
                        <option value="Not Close Unidentified KB">Not Close Unidentified KB</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Bulan</label>
                    <select id="masterFilterBulan"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400 bg-white">
                        <option value="">Semua Bulan</option>
                        <option value="Jan">Januari</option><option value="Feb">Februari</option>
                        <option value="Mar">Maret</option><option value="Apr">April</option>
                        <option value="May">Mei</option><option value="Jun">Juni</option>
                        <option value="Jul">Juli</option><option value="Aug">Agustus</option>
                        <option value="Sep">September</option><option value="Oct">Oktober</option>
                        <option value="Nov">November</option><option value="Dec">Desember</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Tahun</label>
                    <select id="masterFilterTahun"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400 bg-white">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Cari</label>
                    <input type="text" id="masterFilterText" placeholder="Cari user, periode, segmen..."
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400">
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="resetMasterFilter()"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-lg transition-colors uppercase tracking-wider">
                    Reset Filter
                </button>
                <span id="filterResultCount" class="text-xs font-bold text-slate-400"></span>
            </div>
        </div>

        {{-- ══ TABEL ORDER ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Data PSAK — Format Order</h2>
                </div>
                <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5">ORDER</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full" id="tableOrder">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Segmen</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Commitment (Order)</th>
                            <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Realisasi (Order)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($psakData as $psak)
                        @php
                            $segmentNames = [
                                'nc_step14' => 'Not Close Step 1-4',
                                'nc_step5' => 'Not Close Step 5',
                                'nc_konfirmasi' => 'Not Close Konfirmasi',
                                'nc_splitbill' => 'Not Close Split Bill',
                                'nc_crvariable' => 'Not Close CR Variable',
                                'nc_unidentified' => 'Not Close Unidentified KB',
                            ];
                            $segmentName = $segmentNames[$psak->segment] ?? $psak->segment;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-100 rounded-md px-2.5 py-1">
                                    {{ $psak->periode ? \Carbon\Carbon::parse($psak->periode)->format('M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 border border-slate-200 rounded-md px-2.5 py-1">
                                    {{ $segmentName }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $psak->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-black text-slate-800">
                                {{ $psak->commitment_order ? number_format($psak->commitment_order, 2, ',', '.') . ' Order' : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-black text-slate-800">
                                {{ $psak->real_order ? number_format($psak->real_order, 2, ',', '.') . ' Order' : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ══ TABEL RUPIAH ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Data PSAK — Format Rupiah</h2>
                </div>
                <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5">RP</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full" id="tableRupiah">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Segmen</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Commitment (Rp)</th>
                            <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Realisasi (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($psakData as $psak)
                        @php
                            $segmentNames = [
                                'nc_step14' => 'Not Close Step 1-4',
                                'nc_step5' => 'Not Close Step 5',
                                'nc_konfirmasi' => 'Not Close Konfirmasi',
                                'nc_splitbill' => 'Not Close Split Bill',
                                'nc_crvariable' => 'Not Close CR Variable',
                                'nc_unidentified' => 'Not Close Unidentified KB',
                            ];
                            $segmentName = $segmentNames[$psak->segment] ?? $psak->segment;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-100 rounded-md px-2.5 py-1">
                                    {{ $psak->periode ? \Carbon\Carbon::parse($psak->periode)->format('M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 border border-slate-200 rounded-md px-2.5 py-1">
                                    {{ $segmentName }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $psak->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-black text-slate-800">
                                {{ $psak->commitment_rp ? 'Rp ' . number_format($psak->commitment_rp, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-black text-slate-800">
                                {{ $psak->real_rp ? 'Rp ' . number_format($psak->real_rp, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @else
        {{-- ══ EMPTY STATE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
            <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-sm font-bold text-slate-400">Belum ada data PSAK untuk {{ ucfirst($role) }}</p>
            <p class="text-xs text-slate-300 mt-1">Silakan input commitment terlebih dahulu</p>
        </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    ['masterFilterSegmen', 'masterFilterBulan', 'masterFilterTahun', 'masterFilterText'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', applyMasterFilter);
            el.addEventListener('keyup', applyMasterFilter);
        }
    });
});

function applyMasterFilter() {
    const segmenVal = (document.getElementById('masterFilterSegmen')?.value || '').toLowerCase();
    const bulanVal  = (document.getElementById('masterFilterBulan')?.value  || '').toLowerCase();
    const tahunVal  = (document.getElementById('masterFilterTahun')?.value  || '').toLowerCase();
    const textVal   = (document.getElementById('masterFilterText')?.value   || '').toLowerCase();

    let totalVisible = 0;

    ['tableOrder', 'tableRupiah'].forEach(function(tableId) {
        const table = document.getElementById(tableId);
        if (!table) return;
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length < 3) continue;
            const periodeText = (cells[0].textContent || '').trim().toLowerCase();
            const segmenText  = (cells[1].textContent || '').trim().toLowerCase();
            const rowFull     = (rows[i].textContent  || '').trim().toLowerCase();
            const show = (!segmenVal || segmenText.includes(segmenVal))
                      && (!bulanVal  || periodeText.includes(bulanVal))
                      && (!tahunVal  || periodeText.includes(tahunVal))
                      && (!textVal   || rowFull.includes(textVal));
            rows[i].style.display = show ? '' : 'none';
            if (show) totalVisible++;
        }
    });

    const countEl = document.getElementById('filterResultCount');
    if (countEl) {
        countEl.textContent = (segmenVal || bulanVal || tahunVal || textVal)
            ? 'Menampilkan ' + totalVisible + ' baris'
            : '';
    }
}

function resetMasterFilter() {
    ['masterFilterSegmen', 'masterFilterBulan', 'masterFilterTahun'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    const t = document.getElementById('masterFilterText');
    if (t) t.value = '';
    applyMasterFilter();
}
</script>
@endsection
