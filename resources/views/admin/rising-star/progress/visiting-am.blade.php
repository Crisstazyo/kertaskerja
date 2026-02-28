@extends('layouts.app')

@section('title', 'Progress Visiting AM - Admin')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5" style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Rising Star · Star 1</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            Progress <span class="text-red-600">Visiting AM</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.rising-star.dashboard', 1) }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-slate-900 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back</span>
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

        {{-- ══ FILTER ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('admin.rising-star.progress.visiting-am') }}" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Bulan</label>
                    <select name="month" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 transition-colors">
                        @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tahun</label>
                    <select name="year" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 transition-colors">
                        @for($y = \Carbon\Carbon::now()->year; $y >= 2023; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">User</label>
                    <select name="user_id" class="px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 transition-colors">
                        <option value="">Semua User</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ $userId == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-5 py-2.5 rounded-lg transition-all duration-200 uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    <span>Filter</span>
                </button>
            </form>
        </div>

        {{-- ══ STATS ══ --}}
        <div class="grid grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center">
                <p class="text-3xl font-black text-slate-900">{{ $totalUsers }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Total User</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-200 shadow-sm p-6 text-center">
                <p class="text-3xl font-black text-green-600">{{ $completedUsers }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Sudah Input</p>
            </div>
            <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-6 text-center">
                <p class="text-3xl font-black text-red-600">{{ $totalUsers - $completedUsers }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Belum Input</p>
            </div>
        </div>

        {{-- ══ USERS NOT INPUT ══ --}}
        @if($usersNotInput->count() > 0)
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-6">
            <p class="text-xs font-black text-red-600 uppercase tracking-widest mb-3">⚠ User Belum Input Bulan Ini</p>
            <div class="flex flex-wrap gap-2">
                @foreach($usersNotInput as $u)
                <span class="text-xs font-bold text-red-700 bg-white border border-red-200 rounded-lg px-3 py-1.5">
                    {{ $u->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ══ DATA TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Data Visiting AM</h2>
                </div>
                <span class="text-xs font-bold text-slate-400 bg-slate-50 border border-slate-200 rounded-full px-3 py-1">
                    {{ $data->count() }} records
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Bulan/Tahun</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Target Ratio</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Ratio Aktual</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $i => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-slate-400">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $item->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-100 rounded-md px-2.5 py-1">
                                    {{ \Carbon\Carbon::create()->month($item->month)->format('M') }} {{ $item->year }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-800">
                                {{ !is_null($item->target_ratio) ? number_format($item->target_ratio, 2) . '%' : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-800">
                                {{ !is_null($item->ratio_aktual) ? number_format($item->ratio_aktual, 2) . '%' : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @if(!is_null($item->ratio_aktual) && !is_null($item->target_ratio) && $item->target_ratio > 0)
                                    @php $pct = ($item->ratio_aktual / $item->target_ratio) * 100; @endphp
                                    <span class="text-xs font-bold rounded-md px-2.5 py-1
                                        {{ $pct >= 100 ? 'text-green-700 bg-green-50 border border-green-200' : ($pct >= 80 ? 'text-yellow-700 bg-yellow-50 border border-yellow-200' : 'text-red-700 bg-red-50 border border-red-200') }}">
                                        {{ number_format($pct, 1) }}%
                                    </span>
                                @else
                                    <span class="text-slate-300 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-400">
                                {{ $item->entry_date ? \Carbon\Carbon::parse($item->entry_date)->format('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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
@endsection
