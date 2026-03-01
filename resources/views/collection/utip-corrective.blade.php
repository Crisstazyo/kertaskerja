@extends('layouts.app')

@section('title', 'UTIP Corrective')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5"
                style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">UTIP <span class="text-red-600">Corrective</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Periode: {{ $currentPeriod }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('collection.utip') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-red-200">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ FLASH MESSAGES ══ --}}
        @if(session('success'))
            <div class="flex items-start space-x-4 bg-green-50 border border-green-200 rounded-xl px-5 py-4 mb-6">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-black text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-start space-x-4 bg-red-50 border border-red-200 rounded-xl px-5 py-4 mb-6">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-black text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        {{-- ══ STATUS CARD ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-8 py-6 mb-8">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <div>
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Ringkasan Periode</h2>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ $currentPeriod }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">{{ $currentPeriod }}</span>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-slate-50 rounded-xl px-5 py-4 border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Plan</p>
                    <p class="text-lg font-black text-slate-900">
                        @if($existingPlan) Rp {{ number_format($existingPlan->nominal, 0, ',', '.') }}
                        @else <span class="text-slate-300">—</span> @endif
                    </p>
                </div>
                <div class="bg-slate-50 rounded-xl px-5 py-4 border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Komitmen</p>
                    <p class="text-lg font-black text-slate-900">
                        @if($existingCommitment) Rp {{ number_format($existingCommitment->nominal, 0, ',', '.') }}
                        @else <span class="text-slate-300">—</span> @endif
                    </p>
                </div>
                <div class="bg-slate-50 rounded-xl px-5 py-4 border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Realisasi Terkini</p>
                    <p class="text-lg font-black text-slate-900">
                        @if($latestRealisasi) Rp {{ number_format($latestRealisasi->nominal, 0, ',', '.') }}
                        @else <span class="text-slate-300">—</span> @endif
                    </p>
                </div>
                <div class="bg-slate-50 rounded-xl px-5 py-4 border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status</p>
                    @if($existingCommitment && $latestRealisasi)
                        @if($latestRealisasi->nominal >= $existingCommitment->nominal)
                            <span class="text-xs font-bold rounded-md px-2.5 py-1 text-green-700 bg-green-50 border border-green-200">Tercapai</span>
                        @else
                            <span class="text-xs font-bold rounded-md px-2.5 py-1 text-red-700 bg-red-50 border border-red-200">Belum Tercapai</span>
                        @endif
                    @else
                        <span class="text-xs font-bold rounded-md px-2.5 py-1 text-slate-500 bg-slate-100 border border-slate-200">Belum Ada Data</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══ TAB FORM ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">

            <div class="flex border-b border-slate-100">
                <button onclick="showTab('plan')" id="tab-plan"
                    class="tab-button flex-1 flex items-center justify-center space-x-2 py-4 text-sm font-black uppercase tracking-wider text-red-600 border-b-2 border-red-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Form Plan</span>
                </button>
                <button onclick="showTab('komitmen')" id="tab-komitmen"
                    class="tab-button flex-1 flex items-center justify-center space-x-2 py-4 text-sm font-black uppercase tracking-wider text-slate-400 border-b-2 border-transparent transition-all hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Form Komitmen</span>
                </button>
                <button onclick="showTab('realisasi')" id="tab-realisasi"
                    class="tab-button flex-1 flex items-center justify-center space-x-2 py-4 text-sm font-black uppercase tracking-wider text-slate-400 border-b-2 border-transparent transition-all hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Form Realisasi</span>
                </button>
            </div>

            <div class="p-8">

                {{-- ── Form Plan ── --}}
                <div id="content-plan" class="tab-content space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                            <div>
                                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Plan</h2>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Tentukan nominal plan UTIP Corrective untuk periode ini.</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">{{ $currentPeriod }}</span>
                    </div>

                    @if($existingPlan)
                        <div class="flex items-start space-x-4 bg-amber-50 border border-amber-200 rounded-xl px-5 py-4">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-black text-amber-800">Plan Sudah Diinput</p>
                                <p class="text-xs text-amber-700 mt-0.5">Plan untuk periode ini sudah diinput: <strong>Rp {{ number_format($existingPlan->nominal, 0, ',', '.') }}</strong></p>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('collection.utip-corrective.plan.store') }}" class="max-w-md mx-auto space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nominal Plan (Rp)</label>
                                <input type="number" name="nominal_plan" step="1" min="0" required
                                    class="w-full px-6 py-4 text-xl font-black text-slate-800 border-2 border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                    placeholder="0">
                                @error('nominal_plan')
                                    <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1.5 text-xs text-slate-400 font-medium">Nominal dalam Rupiah tanpa tanda titik atau koma</p>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Simpan Plan</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                {{-- ── Form Komitmen ── --}}
                <div id="content-komitmen" class="tab-content hidden space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                            <div>
                                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Komitmen</h2>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Tentukan nominal komitmen UTIP Corrective untuk periode ini.</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">{{ $currentPeriod }}</span>
                    </div>

                    @if($hasMonthlyCommitment)
                        <div class="flex items-start space-x-4 bg-amber-50 border border-amber-200 rounded-xl px-5 py-4">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-black text-amber-800">Target Sudah Terkunci</p>
                                <p class="text-xs text-amber-700 mt-0.5">
                                    Anda telah menginput komitmen UTIP Corrective untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong>. Input baru hanya tersedia di bulan depan.
                                </p>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('collection.utip-corrective.komitmen.store') }}" class="max-w-md mx-auto space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nominal Komitmen (Rp)</label>
                                <input type="number" name="value" step="1" min="0" required
                                    class="w-full px-6 py-4 text-xl font-black text-slate-800 border-2 border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                    placeholder="0">
                                @error('value')
                                    <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1.5 text-xs text-slate-400 font-medium">Nominal dalam Rupiah tanpa tanda titik atau koma</p>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Simpan Komitmen</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                {{-- ── Form Realisasi ── --}}
                <div id="content-realisasi" class="tab-content hidden space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                            <div>
                                <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input Realisasi</h2>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Catat realisasi UTIP Corrective harian.</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-green-700 bg-green-50 border border-green-200 rounded-md px-3 py-1 uppercase">Harian</span>
                    </div>

                    <form method="POST" action="{{ route('collection.utip-corrective.realisasi.store') }}" class="max-w-md mx-auto space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nominal Realisasi (Rp)</label>
                            <input type="number" name="nominal_realisasi" step="1" min="0" required
                                class="w-full px-6 py-4 text-xl font-black text-slate-800 border-2 border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors"
                                placeholder="0">
                            @error('nominal_realisasi')
                                <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-slate-400 font-medium">Nominal dalam Rupiah tanpa tanda titik atau koma</p>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Simpan Realisasi</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- ══ HISTORY TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">History Data — {{ $currentPeriod }}</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                            <th class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                            <th class="px-6 py-3 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal (Rp)</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                                {{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->type == 'plan')
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1 text-red-700 bg-red-50 border border-red-200">Plan</span>
                                @elseif($item->type == 'komitmen')
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1 text-slate-700 bg-slate-100 border border-slate-200">Komitmen</span>
                                @else
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1 text-green-700 bg-green-50 border border-green-200">Realisasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-black text-slate-900">
                                Rp {{ number_format($item->value ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 font-medium">
                                {{ $item->keterangan ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center">
                                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-sm font-bold text-slate-400">Belum ada data untuk periode ini</p>
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
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        ['plan', 'komitmen', 'realisasi'].forEach(name => {
            const tab = document.getElementById('tab-' + name);
            tab.classList.remove('text-red-600', 'border-red-600');
            tab.classList.add('text-slate-400', 'border-transparent');
        });

        document.getElementById('content-' + tabName).classList.remove('hidden');

        const activeTab = document.getElementById('tab-' + tabName);
        activeTab.classList.remove('text-slate-400', 'border-transparent');
        activeTab.classList.add('text-red-600', 'border-red-600');
    }
</script>
@endsection
