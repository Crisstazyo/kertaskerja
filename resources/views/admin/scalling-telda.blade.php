@extends('layouts.app')

@section('title', 'Scaling Telda - Admin')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            Scaling <span class="text-red-600">Telda</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">9 Telekomunikasi Daerah · Commitment & Realisasi</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="history.back()"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-slate-900 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back</span>
                    </button>
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
        @if(session('error'))
        <div class="flex items-center space-x-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- ══ INPUT FORM — TELDA CARDS ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">
                        Input Data — {{ \Carbon\Carbon::now()->format('F Y') }}
                    </h2>
                    @if($existing)
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-md px-2.5 py-1 ml-2">
                        ✏️ Update data
                    </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 font-medium">
                    ⚠ Realisasi hanya aktif jika Commitment sudah diisi
                </p>
            </div>

            <form action="{{ route('admin.scalling.telda.store') }}" method="POST" id="teldaForm">
                @csrf
                <input type="hidden" name="periode" value="{{ \Carbon\Carbon::now()->format('Y-m') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-6">
                    @foreach($teldas as $key => $label)
                    @php
                        $commitmentVal = $existing ? $existing->{$key . '_commitment'} : null;
                        $realVal       = $existing ? $existing->{$key . '_real'} : null;
                        $realDisabled  = is_null($commitmentVal);
                    @endphp
                    <div class="border border-slate-200 rounded-xl p-5 hover:border-red-200 hover:shadow-sm transition-all duration-200">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wide">{{ $label }}</h3>
                        </div>

                        {{-- Commitment --}}
                        <div class="mb-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Commitment</label>
                            <input type="number"
                                name="{{ $key }}_commitment"
                                id="{{ $key }}_commitment"
                                value="{{ $commitmentVal ?? '' }}"
                                placeholder="Masukkan target"
                                min="0"
                                data-telda="{{ $key }}"
                                class="telda-commitment w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                        </div>

                        {{-- Realisasi --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Realisasi</label>
                            <input type="number"
                                name="{{ $key }}_real"
                                id="{{ $key }}_real"
                                value="{{ $realVal ?? '' }}"
                                placeholder="{{ $realDisabled ? 'Isi commitment dulu' : 'Masukkan realisasi' }}"
                                min="0"
                                {{ $realDisabled ? 'disabled' : '' }}
                                class="telda-real w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors disabled:bg-slate-50 disabled:text-slate-300 disabled:cursor-not-allowed">
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-2.5 rounded-lg transition-all duration-200 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Semua Data Telda</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ══ HISTORY TABLE ══ --}}
        @if($history->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Riwayat Data Telda</h2>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 border border-slate-200 rounded-full px-3 py-1">
                    {{ $history->count() }} records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-4 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Periode</th>
                            @foreach($teldas as $key => $label)
                            <th class="px-4 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap" colspan="2">{{ $label }}</th>
                            @endforeach
                        </tr>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-2"></th>
                            @foreach($teldas as $key => $label)
                            <th class="px-3 py-2 text-center text-[9px] font-black text-blue-400 uppercase tracking-widest">COM</th>
                            <th class="px-3 py-2 text-center text-[9px] font-black text-green-400 uppercase tracking-widest">REAL</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($history as $row)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5">
                                    {{ \Carbon\Carbon::parse($row->periode)->format('M Y') }}
                                </span>
                            </td>
                            @foreach($teldas as $key => $label)
                            @php
                                $com  = $row->{$key . '_commitment'};
                                $real = $row->{$key . '_real'};
                            @endphp
                            <td class="px-3 py-3 text-center font-bold text-slate-700 whitespace-nowrap">
                                {{ !is_null($com) ? number_format($com, 0, ',', '.') : '<span class="text-slate-300">—</span>' }}
                            </td>
                            <td class="px-3 py-3 text-center whitespace-nowrap">
                                @if(!is_null($real) && !is_null($com) && $com > 0)
                                    @php $pct = ($real / $com) * 100; @endphp
                                    <span class="text-xs font-bold rounded px-1.5 py-0.5
                                        {{ $pct >= 100 ? 'text-green-700 bg-green-50' : ($pct >= 80 ? 'text-yellow-700 bg-yellow-50' : 'text-red-700 bg-red-50') }}">
                                        {{ number_format($real, 0, ',', '.') }}
                                    </span>
                                @elseif(!is_null($real))
                                    <span class="text-slate-600 font-bold text-xs">{{ number_format($real, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
    // Enable/disable real inputs based on commitment value
    document.querySelectorAll('.telda-commitment').forEach(function(input) {
        input.addEventListener('input', function() {
            const telda   = this.getAttribute('data-telda');
            const realEl  = document.getElementById(telda + '_real');
            const hasVal  = this.value.trim() !== '';
            realEl.disabled = !hasVal;
            realEl.placeholder = hasVal ? 'Masukkan realisasi' : 'Isi commitment dulu';
            if (!hasVal) realEl.value = '';
        });
    });
</script>
@endsection
