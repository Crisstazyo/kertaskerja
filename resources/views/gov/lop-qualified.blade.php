@extends('layouts.app')

@section('title', 'Government - LOP Qualified')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-12">
    <div class="max-w-[98%] mx-auto px-6">
        <!-- Professional Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-6">
                    <a href="{{ route('gov.dashboard') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Dashboard
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">LOP Qualified</h1>
                            <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-xs font-semibold rounded-full shadow-sm">GOVERNMENT</span>
                        </div>
                        <p class="text-sm text-gray-500">Qualified Lead Opportunity Pipeline</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Data Display -->
        @if($latestImport)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="p-8">

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                            <tr>
                                <!-- Original Columns -->
                                <th class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NO</th>
                                <th class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">PROJECT</th>
                                <th class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-purple-100">ID LOP</th>
                                <th class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">CC</th>
                                <th class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NIPNAS</th>
                                <th class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">AM</th>
                                <th class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-purple-100">Mitra</th>
                                <th class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Plan Bulan</th>
                                <th class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Est Nilai BC</th>
                                
                                <!-- Funnel Tracking Columns -->
                                <th colspan="2" class="px-4 py-2 text-center font-bold text-white bg-blue-600 border-r border-gray-300">F0</th>
                                <th colspan="3" class="px-4 py-2 text-center font-bold text-white bg-purple-600 border-r border-gray-300">F1</th>
                                <th colspan="5" class="px-4 py-2 text-center font-bold text-white bg-pink-600 border-r border-gray-300">F2</th>
                                <th colspan="4" class="px-4 py-2 text-center font-bold text-white bg-orange-600 border-r border-gray-300">F3</th>
                                <th colspan="3" class="px-4 py-2 text-center font-bold text-white bg-teal-600 border-r border-gray-300">F4</th>
                                <th colspan="2" class="px-4 py-2 text-center font-bold text-white bg-indigo-600 border-r border-gray-300">F5</th>
                                <th colspan="2" class="px-4 py-2 text-center font-bold text-white bg-green-700 border-r border-gray-300">DELIVERY</th>
                                
                                <!-- Action Column -->
                                <th class="px-4 py-2 text-center font-bold text-gray-700 uppercase tracking-wider bg-yellow-100">Action</th>
                            </tr>
                            <tr>
                                <th colspan="9" class="border-r border-gray-300"></th>
                                <!-- F0 Sub-headers -->
                                <th class="px-2 py-1 text-center text-gray-700 bg-blue-100 border-r">Lead</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-blue-100 border-r">Inisiasi</th>
                                <!-- F1 Sub-headers -->
                                <th class="px-2 py-1 text-center text-gray-700 bg-purple-100 border-r">P0/P1</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-purple-100 border-r">Juskeb</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-purple-100 border-r">BoD DM</th>
                                <!-- F2 Sub-headers -->
                                <th class="px-2 py-1 text-center text-gray-700 bg-pink-100 border-r">P2</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-pink-100 border-r">Eval</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-pink-100 border-r">TAF</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-pink-100 border-r">Juskeb</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-pink-100 border-r">BoD DM</th>
                                <!-- F3 Sub-headers -->
                                <th class="px-2 py-1 text-center text-gray-700 bg-orange-100 border-r">P3_1</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-orange-100 border-r">SPH</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-orange-100 border-r">Juskeb</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-orange-100 border-r">BoD DM</th>
                                <!-- F4 Sub-headers -->
                                <th class="px-2 py-1 text-center text-gray-700 bg-teal-100 border-r">P3_2</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-teal-100 border-r">PKS</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-teal-100 border-r">BAST</th>
                                <!-- F5 Sub-headers -->
                                <th class="px-2 py-1 text-center text-gray-700 bg-indigo-100 border-r">P4</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-indigo-100 border-r">P5</th>
                                <!-- DELIVERY Sub-headers -->
                                <th class="px-2 py-1 text-center text-gray-700 bg-green-100 border-r">BC</th>
                                <th class="px-2 py-1 text-center text-gray-700 bg-green-100 border-r">BASO</th>
                                <th class="border-r"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestImport->data as $row)
                            @php
                                $funnel = $row->funnel;
                                $denganMitra = strtolower(trim($row->mitra ?? '')) === 'dengan mitra';
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Original Data -->
                                <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 border-r">{{ $row->no }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->project }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r bg-purple-50 font-medium">{{ $row->id_lop }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->cc }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->nipnas }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r">{{ $row->am }}</td>
                                <td class="px-4 py-2 text-gray-700 border-r bg-purple-50 font-semibold">{{ $row->mitra }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r text-center">{{ $row->plan_bulan_billcom_p_2025 }}</td>
                                <td class="px-4 py-2 whitespace-nowrap font-semibold text-gray-900 border-r">{{ $row->est_nilai_bc }}</td>
                                
                                <!-- Funnel Data -->
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f0_lead ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f0_inisiasi_solusi ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f1_p0_p1 ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f1_juskeb ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f1_bod_dm ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f2_p2 ? '✅' : '⬜' !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f2_evaluasi ? '✅' : '⬜' !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f2_taf ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f2_juskeb ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f2_bod_dm ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f3_p3_1 ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f3_sph ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f3_juskeb ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f3_bod_dm ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f4_p3_2 ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f4_pks ? '✅' : ($denganMitra ? '⬜' : '<span class="text-gray-400">-</span>') !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f4_bast ? '✅' : '⬜' !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f5_p4 ? '✅' : '⬜' !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->f5_p5 ? '✅' : '⬜' !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->delivery_nilai_billcomp ? '✅' : '⬜' !!}
                                </td>
                                <td class="px-2 py-2 text-center border-r">
                                    {!! $funnel && $funnel->delivery_baso ? '✅' : '⬜' !!}
                                </td>
                                
                                <!-- Action -->
                                <td class="px-4 py-2 text-center border-r">
                                    <a href="{{ route('admin.lop.funnel.show', ['qualified', $row->id]) }}" 
                                       class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all shadow-sm hover:shadow-md">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Update
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Admin Notes Section -->
                @if($adminNote)
                <div class="mt-8 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-400 rounded-xl p-6 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-2 text-sm">Administrator Notes</h4>
                            <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $adminNote->note }}</div>
                            <p class="text-xs text-gray-500 mt-3 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Updated {{ $adminNote->updated_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl p-16 text-center border border-gray-200">
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Data Available</h3>
            <p class="text-gray-500">LOP Qualified data has not been uploaded yet</p>
        </div>
        @endif
    </div>
</div>
@endsection
