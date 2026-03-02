@extends('layouts.app')

@section('title', 'Aosodomoro >3 Bulan')

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
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">Aosodomoro <span class="text-red-600">&gt;3 Bulan</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input Realisasi Aosodomoro Periode Lebih dari 3 Bulan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard.gov') }}"
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

        {{-- ══ FLASH MESSAGES ══ --}}
        @if(session('success'))
        <div class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- ══ STATUS PERIODE INI ══ --}}
        @php $periode = now()->format('F Y'); @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
            {{-- Commitment dari Admin --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, #dc2626, #ef4444);"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Target Commitment — {{ $periode }}</p>
                @if($existing && $existing->commitment !== null)
                    <p class="text-4xl font-black text-slate-900">{{ number_format($existing->commitment, 2) }}<span class="text-2xl text-red-600">%</span></p>
                    <p class="text-xs text-slate-400 font-semibold mt-2 uppercase tracking-wide">Ditetapkan oleh Admin</p>
                @else
                    <p class="text-2xl font-black text-slate-300">—</p>
                    <p class="text-xs text-slate-400 font-semibold mt-2">Belum ada target dari admin untuk periode ini</p>
                @endif
            </div>

            {{-- Realisasi saat ini --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-green-500"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Realisasi Anda — {{ $periode }}</p>
                @if($existing && $existing->real_ratio !== null)
                    <p class="text-4xl font-black text-green-600">{{ number_format($existing->real_ratio, 2) }}<span class="text-2xl">%</span></p>
                    <p class="text-xs text-slate-400 font-semibold mt-2 uppercase tracking-wide">Terakhir diperbarui: {{ $existing->updated_at->format('d M Y H:i') }}</p>
                @else
                    <p class="text-2xl font-black text-slate-300">—</p>
                    <p class="text-xs text-slate-400 font-semibold mt-2">Belum ada realisasi untuk periode ini</p>
                @endif
            </div>
        </div>

        {{-- ══ FORM ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <div>
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">
                            {{ $existing && $existing->real_ratio !== null ? 'Update' : 'Input' }} Realisasi
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">
                            {{ $existing && $existing->real_ratio !== null
                                ? 'Nilai akan memperbarui realisasi periode ' . $periode
                                : 'Catat realisasi Aosodomoro periode lebih dari 3 bulan.' }}
                        </p>
                    </div>
                </div>
                <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">
                    {{ $periode }}
                </span>
            </div>
            <div class="p-8">
                <form method="POST" action="{{ route('dashboard.gov.aosodomoro-above-3-bulan.store') }}">
                    @csrf
                    <div class="max-w-md mx-auto space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 text-center">Realisasi (%)</label>
                            <div class="relative">
                                <input type="number" name="real_ratio"
                                    value="{{ old('real_ratio', $existing?->real_ratio) }}"
                                    placeholder="0.00" min="0" step="0.01" required
                                    class="w-full px-6 py-5 text-4xl font-black text-red-600 border-2 border-slate-200 rounded-xl bg-slate-50 text-center focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors @error('real_ratio') border-red-400 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-black text-2xl">%</span>
                                </div>
                            </div>
                            @error('real_ratio')
                            <p class="text-xs text-red-600 font-semibold mt-1.5 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-center pt-2">
                            <button type="submit"
                                class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ $existing && $existing->real_ratio !== null ? 'Update Realisasi' : 'Simpan Realisasi' }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══ HISTORY TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">History Realisasi</h2>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-full px-4 py-1.5 shadow-sm">&gt;3 Bulan</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Target (Admin)</th>
                            <th class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Realisasi</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Terakhir Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($history as $index => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-400">{{ $history->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                                {{ $item->periode ? \Carbon\Carbon::parse($item->periode)->format('F Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->commitment !== null)
                                    <span class="text-sm font-black text-slate-700">{{ number_format($item->commitment, 2) }}%</span>
                                @else
                                    <span class="text-slate-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->real_ratio !== null)
                                    <span class="text-sm font-black text-red-600">{{ number_format($item->real_ratio, 2) }}%</span>
                                @else
                                    <span class="text-xs font-semibold text-slate-400 bg-slate-50 border border-slate-200 rounded-md px-2 py-0.5">Belum diisi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-400 font-medium">
                                {{ $item->updated_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm font-bold text-slate-400">Belum ada data realisasi yang diinput</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($history->hasPages())
            <div class="px-8 py-4 border-t border-slate-100">
                {{ $history->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
