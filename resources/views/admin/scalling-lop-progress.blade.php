@extends('layouts.app')

@section('title', 'Progress - LOP ' . ucfirst($lopTypeDisplay) . ' - ' . ucfirst($roleNormalized))

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
                            Progress <span class="text-red-600">— LOP {{ ucfirst($lopTypeDisplay) }}</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">{{ ucfirst($roleNormalized) }} · Scaling Management System</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.scalling.lop', [$role, $lopType]) }}"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ STATS CARDS ══ --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            {{-- Total Users Active --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-[0.06]" style="background:#dc2626;"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="rounded-xl flex items-center justify-center shadow-sm border-2"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:52px; height:52px;">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5 uppercase">Users</span>
                </div>
                <p class="text-3xl font-black text-slate-900 mb-1">{{ $progressData->count() }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Users Active</p>
            </div>

            {{-- Total Progress Updates --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-[0.06]" style="background:#dc2626;"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="rounded-xl flex items-center justify-center shadow-sm border-2"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:52px; height:52px;">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5 uppercase">Updates</span>
                </div>
                <p class="text-3xl font-black text-slate-900 mb-1">{{ $totalUpdates }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Progress Updates</p>
            </div>

            {{-- Last Update --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-[0.06]" style="background:#dc2626;"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="rounded-xl flex items-center justify-center shadow-sm border-2"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:52px; height:52px;">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5 uppercase">Terbaru</span>
                </div>
                <p class="text-lg font-black text-slate-900 mb-1">{{ $lastUpdate }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Last Update</p>
            </div>
        </div>

        {{-- ══ TABEL PROGRESS ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Tabel Progres User</h2>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">LOP {{ ucfirst($lopTypeDisplay) }} · {{ ucfirst($roleNormalized) }}</span>
            </div>

            {{-- ══ Upload Context ══ --}}
            @if($latestData)
            <div class="px-8 py-3 bg-slate-50 border-b border-slate-100 flex items-center gap-6 text-xs text-slate-500 font-semibold">
                <span>Periode: <strong class="text-slate-700">{{ $latestData->periode ? \Carbon\Carbon::parse($latestData->periode)->format('M Y') : '-' }}</strong></span>
                <span>File: <strong class="text-slate-700">{{ $latestData->file_name }}</strong></span>
                <span>Total Baris: <strong class="text-slate-700">{{ $totalRows }}</strong></span>
                <span>Upload: <strong class="text-slate-700">{{ $latestData->created_at->format('d M Y, H:i') }}</strong></span>
            </div>
            @endif

            @if($progressData->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Baris Selesai</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Baris</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Completion %</th>
                            <th class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Last Update</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($progressData as $progress)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $progress->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-slate-400">{{ $progress->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-black text-slate-700">
                                {{ $progress->checked }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                {{ $progress->total }}
                            </td>
                            <td class="px-6 py-4">
                                @if($progress->pct >= 100)
                                    <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 rounded-md px-2.5 py-1">Completed</span>
                                @elseif($progress->pct > 0)
                                    <span class="text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-2.5 py-1">In Progress</span>
                                @else
                                    <span class="text-xs font-bold text-slate-500 bg-slate-50 border border-slate-200 rounded-md px-2.5 py-1">Not Started</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2.5">
                                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 max-w-[120px]">
                                        <div class="h-1.5 rounded-full {{ $progress->pct >= 100 ? 'bg-green-500' : 'bg-red-500' }}"
                                             style="width: {{ $progress->pct }}%"></div>
                                    </div>
                                    <span class="text-xs font-black text-slate-500">{{ $progress->pct }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-400">
                                {{ $progress->last_update ? $progress->last_update->diffForHumans() : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            <div class="text-center py-16">
                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-sm font-bold text-slate-400">Tidak Ada Progress</p>
                <p class="text-xs text-slate-300 mt-1">Belum ada user yang mengupdate progress untuk LOP ini</p>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
