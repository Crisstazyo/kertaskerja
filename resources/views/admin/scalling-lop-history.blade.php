@extends('layouts.app')

@section('title', 'Riwayat - LOP ' . ucfirst($lopTypeDisplay) . ' - ' . ucfirst($roleNormalized))

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
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">Riwayat <span class="text-red-600">LOP {{ $lopTypeDisplay }}</span></h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Historical Progress · {{ ucfirst($roleNormalized) }}</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ STATS CARDS ══ --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            {{-- Total Historical Data --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-[0.06]" style="background:#dc2626;"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-13 h-13 rounded-xl flex items-center justify-center shadow-sm border-2"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:52px; height:52px;">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5 uppercase">Total</span>
                </div>
                <p class="text-3xl font-black text-slate-900 mb-1">{{ $historyData->total() }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Historical Data</p>
            </div>

            {{-- Unique Users --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-[0.06]" style="background:#dc2626;"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="rounded-xl flex items-center justify-center shadow-sm border-2"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:52px; height:52px;">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5 uppercase">Users</span>
                </div>
                <p class="text-3xl font-black text-slate-900 mb-1">{{ $uniqueUsers }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Unique Users</p>
            </div>

            {{-- Completed Tasks --}}
            <div class="bg-white rounded-2xl border-2 border-slate-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full opacity-[0.06]" style="background:#dc2626;"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="rounded-xl flex items-center justify-center shadow-sm border-2"
                        style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:52px; height:52px;">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-2 py-0.5 uppercase">Done</span>
                </div>
                <p class="text-3xl font-black text-slate-900 mb-1">{{ $completedTasks }}</p>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Completed Tasks</p>
            </div>
        </div>

        {{-- ══ HISTORY TABLE ══ --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                    <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Tabel Riwayat Progres</h2>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">LOP {{ ucfirst($lopTypeDisplay) }} · {{ ucfirst($roleNormalized) }}</span>
            </div>

            @if($historyData->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($historyData as $progress)
                <div class="p-6 hover:bg-slate-50 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="rounded-xl flex items-center justify-center border-2 flex-shrink-0"
                                style="background: linear-gradient(135deg, #fff1f2, #ffe4e6); border-color: #fecdd3; width:48px; height:48px;">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-slate-900">{{ $progress->user->name ?? 'Unknown User' }}</h3>
                                <p class="text-xs font-semibold text-slate-400 mt-0.5">{{ $progress->user->email ?? '-' }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Tanggal: <span class="font-bold text-slate-600">{{ \Carbon\Carbon::parse($progress->tanggal)->format('d M Y') }}</span>
                                    &nbsp;·&nbsp; Updated: <span class="font-bold text-slate-600">{{ $progress->updated_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        </div>
                        <div>
                            @if($progress->is_completed)
                                <span class="flex items-center space-x-1.5 text-xs font-bold rounded-md px-3 py-1.5 text-green-700 bg-green-50 border border-green-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Completed</span>
                                </span>
                            @else
                                <span class="flex items-center space-x-1.5 text-xs font-bold rounded-md px-3 py-1.5 text-amber-700 bg-amber-50 border border-amber-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>In Progress</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4 pt-4 border-t border-slate-100">
                        <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Data ID</p>
                            <p class="text-sm font-black text-slate-900 font-mono">#{{ $progress->task->data_id ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Data Type</p>
                            <p class="text-sm font-black text-slate-900">{{ $progress->task->data_type ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Progress</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <div class="flex-1 bg-slate-200 rounded-full h-1.5">
                                    <div class="bg-red-600 h-1.5 rounded-full transition-all" style="width: {{ $progress->is_completed ? 100 : 50 }}%"></div>
                                </div>
                                <span class="text-xs font-black text-slate-600">{{ $progress->is_completed ? 100 : 50 }}%</span>
                            </div>
                        </div>
                    </div>

                    @if($progress->notes)
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Notes</p>
                        <p class="text-sm text-slate-600 font-semibold bg-slate-50 border border-slate-100 rounded-xl px-4 py-3">{{ $progress->notes }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            @if($historyData->hasPages())
            <div class="px-8 py-4 border-t border-slate-100 bg-slate-50">
                {{ $historyData->links() }}
            </div>
            @endif

            @else
            <div class="py-16 text-center">
                <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-bold text-slate-400">Tidak Ada Riwayat</p>
                <p class="text-xs text-slate-300 mt-1">Belum ada riwayat progress untuk LOP ini</p>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
