@extends('layouts.app')

@section('title', 'SME - LOP Koreksi')

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
                            LOP <span class="text-red-600">Koreksi</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Scalling SME Management</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard.sme') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        @if($latestImport)

        @if(session('success'))
        <div class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 mb-5 rounded-xl">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-sm font-bold">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="flex items-center space-x-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 mb-5 rounded-xl">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-bold">{{ session('error') }}</p>
        </div>
        @endif

        @php $isReadOnly = ($latestImport->status ?? 'active') !== 'active'; @endphp

        @if($isReadOnly)
        <div class="flex items-center space-x-3 bg-amber-50 border border-amber-200 text-amber-800 px-5 py-3.5 mb-6 rounded-xl">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <div>
                <p class="text-sm font-black uppercase tracking-wide">Mode View Only</p>
                <p class="text-xs font-medium mt-0.5">Data ini telah dikunci oleh admin. Anda tidak dapat mengubah realisasi.</p>
            </div>
        </div>
        @endif

        {{-- ══ META INFO ══ --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Data LOP Koreksi</h2>
            </div>
            <div class="flex items-center space-x-3">
                {{-- Periode Selector --}}
                @if(isset($periodOptions) && count($periodOptions))
                <form method="GET" class="flex items-center">
                    <div class="relative">
                        <select id="periode" name="periode" onchange="this.form.submit()"
                            class="appearance-none text-xs font-bold text-slate-700 bg-white border-2 border-slate-200 hover:border-red-400 rounded-lg pl-3 pr-8 py-1.5 shadow-sm focus:outline-none focus:border-red-400 cursor-pointer transition-colors">
                            @foreach($periodOptions as $p)
                                <option value="{{ $p }}" {{ $p === $currentPeriode ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->format('F Y') }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </form>
                @endif

                <span class="text-[10px] font-black tracking-widest text-orange-700 bg-orange-50 border border-orange-200 rounded-md px-3 py-1 uppercase">KOREKSI</span>
                <span class="text-[10px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 uppercase shadow-sm">SME</span>

                @if($isReadOnly)
                <span class="text-[12px] font-black tracking-widest text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-3 py-1 uppercase">
                    🔒 Locked
                </span>
                @endif

                @php
                    $lastUpdate = $rows->map(fn($row) => $row->updated_at)->filter()->max();
                @endphp
                @if($lastUpdate)
                <span class="text-[10px] font-black tracking-widest text-slate-500 bg-white border border-slate-200 rounded-md px-3 py-1 shadow-sm">
                    🕐 {{ \Carbon\Carbon::parse($lastUpdate)->format('d M Y, H:i') }}
                </span>
                @endif
            </div>
        </div>

        {{-- ══ SUMMARY CARDS ══ --}}
        @php
            $totalKomitmen  = $rows->sum('nilai_komitmen');
            $totalRealisasi = $rows->sum('realisasi');
            $pctRealisasi   = $totalKomitmen > 0 ? ($totalRealisasi / $totalKomitmen) * 100 : 0;
            $jumlahData     = $rows->count();
            $sudahRealisasi = $rows->filter(fn($r) => $r->realisasi > 0)->count();
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4">
                <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-1">Total LOP</p>
                <p class="text-2xl font-black text-slate-900">{{ $jumlahData }}</p>
                <p class="text-xs text-slate-400 mt-0.5 font-medium">Data aktif periode ini</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4">
                <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-1">Nilai Komitmen</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($totalKomitmen, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-400 mt-0.5 font-medium">Total komitmen (Rp)</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4">
                <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-1">Total Realisasi</p>
                <p class="text-lg font-black text-emerald-600" id="summary-total-realisasi">{{ number_format($totalRealisasi, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-400 mt-0.5 font-medium">{{ $sudahRealisasi }} dari {{ $jumlahData }} LOP</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4">
                <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-1">Pencapaian</p>
                <p class="text-2xl font-black {{ $pctRealisasi >= 100 ? 'text-emerald-600' : ($pctRealisasi >= 50 ? 'text-yellow-500' : 'text-red-500') }}" id="summary-pct">
                    {{ number_format($pctRealisasi, 1, ',', '.') }}%
                </p>
                <p class="text-xs text-slate-400 mt-0.5 font-medium">Realisasi / Komitmen</p>
            </div>
        </div>

        {{-- ══ TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead>
                        <tr class="bg-slate-800">
                            <th class="px-3 py-3 text-center text-[10px] font-black text-slate-300 uppercase tracking-widest border-r border-slate-700 w-10">NO</th>
                            <th class="px-4 py-3 text-left text-[10px] font-black text-slate-300 uppercase tracking-widest border-r border-slate-700">NAMA PELANGGAN</th>
                            <th class="px-4 py-3 text-right text-[10px] font-black text-slate-300 uppercase tracking-widest border-r border-slate-700 w-44">NILAI KOMITMEN (Rp)</th>
                            <th class="px-4 py-3 text-center text-[10px] font-black text-slate-300 uppercase tracking-widest border-r border-slate-700 w-44">PROGRESS</th>
                            <th class="px-4 py-3 text-right text-[10px] font-black text-emerald-400 uppercase tracking-widest w-56">REALISASI (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100" id="koreksi-tbody">
                        @forelse($rows as $row)
                        @php
                            $hasRealisasi = $row->realisasi !== null && $row->realisasi > 0;
                            $pctRow = ($row->nilai_komitmen > 0 && $row->realisasi > 0)
                                ? ($row->realisasi / $row->nilai_komitmen) * 100
                                : 0;
                            $barColor  = $pctRow >= 100 ? '#16a34a' : ($pctRow >= 50 ? '#eab308' : '#ef4444');
                            $textColor = $pctRow >= 100 ? '#16a34a' : ($pctRow >= 50 ? '#ca8a04' : '#ef4444');
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors koreksi-row"
                            data-id="{{ $row->id }}"
                            data-komitmen="{{ $row->nilai_komitmen ?? 0 }}"
                            data-realisasi="{{ $row->realisasi ?? 0 }}">

                            {{-- No --}}
                            <td class="px-3 py-3 text-center font-bold text-slate-500 border-r border-slate-100">
                                {{ $row->no ?? $loop->iteration }}
                            </td>

                            {{-- Nama Pelanggan --}}
                            <td class="px-4 py-3 text-slate-800 border-r border-slate-100 font-semibold">
                                {{ $row->nama_pelanggan }}
                            </td>

                            {{-- Nilai Komitmen --}}
                            <td class="px-4 py-3 text-right font-black text-slate-800 border-r border-slate-100 tabular-nums">
                                @if($row->nilai_komitmen !== null)
                                    {{ number_format($row->nilai_komitmen, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>

                            {{-- Progress bar --}}
                            <td class="px-4 py-3 border-r border-slate-100">
                                @if($row->nilai_komitmen > 0)
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-2 rounded-full transition-all duration-500 realisasi-bar"
                                            style="width: {{ min(100, $pctRow) }}%; background: {{ $barColor }};"
                                            data-id="{{ $row->id }}">
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-black tabular-nums realisasi-pct"
                                        data-id="{{ $row->id }}"
                                        style="color: {{ $textColor }}; min-width: 36px;">
                                        {{ number_format($pctRow, 0) }}%
                                    </span>
                                </div>
                                @else
                                <span class="text-slate-300 font-bold text-center block">—</span>
                                @endif
                            </td>

                            {{-- Realisasi — inline editable --}}
                            <td class="px-3 py-2.5 bg-emerald-50 border-l border-emerald-100" id="realisasi-cell-{{ $row->id }}">
                                @if(!$isReadOnly)
                                <div class="flex items-center justify-end space-x-2">
                                    {{-- Display mode --}}
                                    <div class="realisasi-display font-black tabular-nums cursor-pointer transition-colors {{ $hasRealisasi ? 'text-emerald-700 hover:text-emerald-500' : 'text-slate-300 hover:text-slate-400' }}"
                                        id="realisasi-display-{{ $row->id }}"
                                        onclick="startEdit({{ $row->id }}, {{ $row->nilai_komitmen ?? 0 }})"
                                        title="Klik untuk edit">
                                        @if($hasRealisasi)
                                            {{ number_format($row->realisasi, 0, ',', '.') }}
                                        @else
                                            <span class="text-xs font-bold">— klik untuk isi</span>
                                        @endif
                                    </div>

                                    {{-- Edit mode (hidden by default) --}}
                                    <div class="realisasi-edit hidden items-center space-x-1"
                                        id="realisasi-edit-{{ $row->id }}">
                                        <input type="number" min="0" step="1"
                                            id="realisasi-input-{{ $row->id }}"
                                            value="{{ $row->realisasi > 0 ? $row->realisasi : '' }}"
                                            placeholder="0"
                                            class="w-36 px-2 py-1 border-2 border-emerald-400 rounded-lg text-xs font-black text-slate-800 text-right focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-100 tabular-nums"
                                            onkeydown="handleKey(event, {{ $row->id }}, {{ $row->nilai_komitmen ?? 0 }})">
                                        <button onclick="saveRealisasi({{ $row->id }}, {{ $row->nilai_komitmen ?? 0 }})"
                                            class="p-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors flex-shrink-0"
                                            title="Simpan (Enter)">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                        <button onclick="cancelEdit({{ $row->id }})"
                                            class="p-1.5 bg-slate-200 hover:bg-slate-300 text-slate-600 rounded-lg transition-colors flex-shrink-0"
                                            title="Batal (Esc)">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @else
                                {{-- Read-only mode --}}
                                <div class="text-right">
                                    @if($hasRealisasi)
                                        <span class="font-black text-emerald-700 tabular-nums">{{ number_format($row->realisasi, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-slate-300 font-bold">—</span>
                                    @endif
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-bold">
                                Tidak ada data koreksi untuk periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                    <tfoot>
                        <tr class="border-t-2 border-slate-300 bg-slate-800">
                            <td colspan="2" class="px-4 py-3 text-right text-xs font-black text-slate-300 uppercase tracking-widest">
                                TOTAL
                            </td>
                            <td class="px-4 py-3 text-right font-black text-white tabular-nums border-l border-slate-700">
                                {{ number_format($totalKomitmen, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center border-l border-slate-700">
                                @php $totalPct = $totalKomitmen > 0 ? ($totalRealisasi / $totalKomitmen) * 100 : 0; @endphp
                                <span class="text-xs font-black tabular-nums" id="footer-pct"
                                    style="color: {{ $totalPct >= 100 ? '#4ade80' : ($totalPct >= 50 ? '#fde047' : '#fca5a5') }}">
                                    {{ number_format($totalPct, 1, ',', '.') }}%
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right border-l border-slate-700">
                                <span class="font-black text-emerald-400 tabular-nums" id="footer-total-realisasi">
                                    {{ number_format($totalRealisasi, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ══ INFO ══ --}}
        <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl px-5 py-3 flex items-start space-x-3">
            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-xs text-blue-700 leading-relaxed">
                <span class="font-black">Cara penggunaan:</span>
                @if(!$isReadOnly)
                    Klik nilai di kolom <span class="font-black text-emerald-700">Realisasi</span> untuk mengisi atau mengubah angka realisasi secara langsung.
                    Tekan <span class="font-black">Enter</span> atau klik tombol ✓ untuk menyimpan.
                    Tekan <span class="font-black">Escape</span> atau klik ✕ untuk membatalkan.
                    Progress bar akan otomatis terupdate setelah disimpan.
                @else
                    Data dalam mode <span class="font-black">View Only</span> — tidak dapat diedit karena periode telah dikunci oleh admin.
                @endif
            </div>
        </div>

        @else
        {{-- ══ EMPTY STATE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5"
                style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border: 2px solid #fecdd3;">
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-black text-slate-700 mb-2 uppercase tracking-tight">Data Belum Tersedia</h3>
            <p class="text-sm font-medium text-slate-400">LOP Koreksi data has not been uploaded yet for this period</p>
        </div>
        @endif

    </div>
</div>

@if($latestImport && !$isReadOnly)
<script>
(function () {
    const CSRF  = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const ROUTE = '{{ route("dashboard.sme.koreksi.update-realisasi") }}';

    // Simpan nilai asal tiap baris supaya bisa di-rollback saat error / cancel
    const origValues = {};
    document.querySelectorAll('.koreksi-row').forEach(function (tr) {
        origValues[tr.dataset.id] = parseFloat(tr.dataset.realisasi) || 0;
    });

    // Totals — di-track di JS supaya update tanpa reload
    let totalKomitmen = {{ $totalKomitmen }};
    let totalReal     = {{ $totalRealisasi }};

    // ── Buka editor inline ──
    window.startEdit = function (id, komitmen) {
        // Tutup editor lain yang sedang terbuka
        document.querySelectorAll('.realisasi-edit').forEach(function (el) {
            if (!el.classList.contains('hidden')) {
                var otherId = el.id.replace('realisasi-edit-', '');
                cancelEdit(parseInt(otherId));
            }
        });

        var display = document.getElementById('realisasi-display-' + id);
        var edit    = document.getElementById('realisasi-edit-' + id);
        var input   = document.getElementById('realisasi-input-' + id);

        display.classList.add('hidden');
        edit.classList.remove('hidden');
        edit.classList.add('flex');
        input.focus();
        input.select();
    };

    // ── Batal edit, kembalikan display ──
    window.cancelEdit = function (id) {
        var display = document.getElementById('realisasi-display-' + id);
        var edit    = document.getElementById('realisasi-edit-' + id);
        var input   = document.getElementById('realisasi-input-' + id);

        edit.classList.add('hidden');
        edit.classList.remove('flex');
        display.classList.remove('hidden');

        // Reset input ke nilai semula
        input.value = origValues[id] > 0 ? origValues[id] : '';
    };

    // ── Keyboard handler: Enter = simpan, Escape = batal ──
    window.handleKey = function (event, id, komitmen) {
        if (event.key === 'Enter') {
            event.preventDefault();
            saveRealisasi(id, komitmen);
        } else if (event.key === 'Escape') {
            cancelEdit(id);
        }
    };

    // ── Simpan realisasi via AJAX ──
    window.saveRealisasi = function (id, komitmen) {
        var input    = document.getElementById('realisasi-input-' + id);
        var rawValue = input.value.trim();
        var newValue = rawValue === '' ? 0 : parseFloat(rawValue);

        if (isNaN(newValue) || newValue < 0) {
            input.classList.add('border-red-500');
            input.focus();
            setTimeout(function () { input.classList.remove('border-red-500'); }, 1500);
            return;
        }

        // Optimistic UI: tampilkan "Menyimpan..." sementara request jalan
        var display = document.getElementById('realisasi-display-' + id);
        var edit    = document.getElementById('realisasi-edit-' + id);
        display.innerHTML = '<span class="text-slate-400 text-xs font-bold animate-pulse">Menyimpan...</span>';
        display.classList.remove('hidden');
        edit.classList.add('hidden');
        edit.classList.remove('flex');

        fetch(ROUTE, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ id: id, realisasi: newValue }),
        })
        .then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(function (data) {
            if (!data.success) throw new Error(data.message || 'Gagal menyimpan');

            var oldValue  = origValues[id] || 0;
            origValues[id] = newValue;
            input.value    = newValue > 0 ? newValue : '';

            // Perbarui tampilan display
            if (newValue > 0) {
                display.innerHTML = '<span class="font-black text-emerald-700 tabular-nums">' + formatNumber(newValue) + '</span>';
            } else {
                display.innerHTML = '<span class="text-xs font-bold text-slate-300">— klik untuk isi</span>';
            }
            display.className = 'realisasi-display font-black tabular-nums cursor-pointer transition-colors ' +
                (newValue > 0 ? 'text-emerald-700 hover:text-emerald-500' : 'text-slate-300 hover:text-slate-400');
            display.setAttribute('onclick', 'startEdit(' + id + ', ' + komitmen + ')');

            // Perbarui progress bar di baris yang sama
            updateRowProgress(id, komitmen, newValue);

            // Perbarui total
            totalReal = totalReal - oldValue + newValue;
            updateFooterTotals();
            updateSummaryCards();

            // Flash hijau di cell
            var cell = document.getElementById('realisasi-cell-' + id);
            cell.style.background = '#d1fae5';
            setTimeout(function () { cell.style.background = ''; }, 1200);
        })
        .catch(function (err) {
            console.error(err);

            // Rollback display ke nilai sebelumnya
            var val = origValues[id] || 0;
            if (val > 0) {
                display.innerHTML = '<span class="font-black text-emerald-700 tabular-nums">' + formatNumber(val) + '</span>';
            } else {
                display.innerHTML = '<span class="text-xs font-bold text-slate-300">— klik untuk isi</span>';
            }
            display.className = 'realisasi-display font-black tabular-nums cursor-pointer transition-colors ' +
                (val > 0 ? 'text-emerald-700 hover:text-emerald-500' : 'text-slate-300 hover:text-slate-400');
            display.setAttribute('onclick', 'startEdit(' + id + ', ' + komitmen + ')');

            // Flash merah di cell
            var cell = document.getElementById('realisasi-cell-' + id);
            cell.style.background = '#fee2e2';
            setTimeout(function () { cell.style.background = ''; }, 1500);

            alert('Gagal menyimpan realisasi: ' + err.message);
        });
    };

    // ── Update progress bar per baris ──
    function updateRowProgress(id, komitmen, realisasi) {
        var bar     = document.querySelector('.realisasi-bar[data-id="' + id + '"]');
        var pctSpan = document.querySelector('.realisasi-pct[data-id="' + id + '"]');
        if (!bar || !pctSpan) return;

        var pct    = komitmen > 0 ? Math.min(100, (realisasi / komitmen) * 100) : 0;
        var color  = pct >= 100 ? '#16a34a' : (pct >= 50 ? '#eab308' : '#ef4444');
        var color2 = pct >= 100 ? '#16a34a' : (pct >= 50 ? '#ca8a04' : '#ef4444');

        bar.style.width      = pct + '%';
        bar.style.background = color;
        pctSpan.textContent  = Math.round(pct) + '%';
        pctSpan.style.color  = color2;
    }

    // ── Update tfoot total ──
    function updateFooterTotals() {
        var pct = totalKomitmen > 0 ? (totalReal / totalKomitmen) * 100 : 0;
        var elR = document.getElementById('footer-total-realisasi');
        var elP = document.getElementById('footer-pct');
        if (elR) elR.textContent = formatNumber(totalReal);
        if (elP) {
            elP.textContent  = pct.toFixed(1).replace('.', ',') + '%';
            elP.style.color  = pct >= 100 ? '#4ade80' : (pct >= 50 ? '#fde047' : '#fca5a5');
        }
    }

    // ── Update summary cards di atas ──
    function updateSummaryCards() {
        var sr  = document.getElementById('summary-total-realisasi');
        var sp  = document.getElementById('summary-pct');
        var pct = totalKomitmen > 0 ? (totalReal / totalKomitmen) * 100 : 0;
        if (sr) sr.textContent = formatNumber(totalReal);
        if (sp) {
            sp.textContent = pct.toFixed(1).replace('.', ',') + '%';
            sp.className   = 'text-2xl font-black ' +
                (pct >= 100 ? 'text-emerald-600' : (pct >= 50 ? 'text-yellow-500' : 'text-red-500'));
        }
    }

    // ── Format angka dengan titik ribuan ──
    function formatNumber(num) {
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
})();
</script>
@endif

@endsection