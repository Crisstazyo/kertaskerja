@extends('layouts.app')

@section('title', 'Admin - Progress ' . ucfirst(str_replace('_', ' ', $category)))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-8">
    <div class="max-w-[98%] mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.role.menu', $role) }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Menu
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Progress LOP {{ ucfirst(str_replace('_', ' ', $category)) }}</h1>
                <p class="text-gray-600 mt-1">{{ ucfirst($role) }} - Monitoring funnel progress</p>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent mt-4"></div>
        </div>

        <!-- Toggle: Current Month vs History -->
        <div class="mb-6 flex items-center gap-4">
            <div class="bg-white rounded-xl shadow-lg p-2 inline-flex gap-2">
                <a href="{{ route('admin.progress.category', [$role, $category]) }}" 
                   class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 {{ !request('view') || request('view') == 'current' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    Progress Bulan Ini
                </a>
                <a href="{{ route('admin.progress.category', [$role, $category]) }}?view=history" 
                   class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 {{ request('view') == 'history' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    Riwayat
                </a>
                <a href="{{ route('admin.progress.category', [$role, $category]) }}?view=full" 
                   class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 {{ request('view') == 'full' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    Laporan Lengkap
                </a>
            </div>
            
            @if(request('view') == 'full')
            <!-- Month Filter -->
            <div class="bg-white rounded-xl shadow-lg p-2 inline-flex items-center gap-3 px-4">
                <label class="text-sm font-semibold text-gray-700">Bulan:</label>
                <select onchange="updateFilters('month', this.value)" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none font-medium text-sm">
                    @foreach($availableMonths as $month)
                        <option value="{{ $month['value'] }}" {{ $selectedMonth == $month['value'] ? 'selected' : '' }}>
                            {{ $month['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>

        <script>
        function updateFilters(param, value) {
            const url = new URL(window.location.href);
            if (value) {
                url.searchParams.set(param, value);
            } else {
                url.searchParams.delete(param);
            }
            window.location.href = url.toString();
        }
        </script>

        @if(request('view') == 'history')
            <!-- HISTORY View - Manage Visible Periods -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-slate-700 to-gray-800 p-6">
                    <h2 class="text-2xl font-bold text-white">Kelola Riwayat yang Ditampilkan</h2>
                    <p class="text-gray-300 text-sm">Pilih periode mana yang ingin ditampilkan di halaman progress</p>
                </div>

                <div class="p-6">
                    @forelse($allUploads as $upload)
                    <div class="mb-4 last:mb-0">
                        <div class="bg-gradient-to-r from-gray-50 to-slate-50 border-2 border-gray-200 rounded-xl p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-2">
                                        <div class="bg-emerald-100 px-4 py-2 rounded-lg">
                                            <span class="font-bold text-emerald-700">
                                                {{ date('F Y', mktime(0, 0, 0, $upload->month, 1, $upload->year)) }}
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-lg">{{ $upload->file_name }}</h3>
                                        
                                        @php
                                            $isCurrentMonth = ($upload->month == date('n') && $upload->year == date('Y'));
                                            $isVisible = in_array($upload->id, session('visible_uploads', []));
                                        @endphp
                                        
                                        @if($isCurrentMonth)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-bold text-xs">
                                                Bulan Saat Ini
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-6 text-sm text-gray-600">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="font-semibold">{{ $upload->total_rows }} rows</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $upload->uploaded_by }}</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $upload->created_at->format('d M Y, H:i') }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    @if(!$isCurrentMonth)
                                        <form action="{{ route('admin.progress.toggle-visibility', [$role, $category]) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="upload_id" value="{{ $upload->id }}">
                                            <button type="submit" class="px-6 py-2 rounded-lg font-semibold transition-all {{ $isVisible ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' }}">
                                                {{ $isVisible ? 'Sembunyikan' : 'Tampilkan' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-6 py-2 bg-gray-100 text-gray-500 rounded-lg font-semibold cursor-not-allowed">
                                            Selalu Tampil
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center text-gray-500">
                        <div class="text-6xl mb-4 text-gray-300">
                            <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="font-bold text-xl mb-2">Belum Ada Riwayat</p>
                        <p class="text-sm">Upload file untuk melihat riwayat</p>
                    </div>
                    @endforelse
                </div>
            </div>
        @elseif(!request('view') || request('view') == 'current')
            <!-- CURRENT PROGRESS View - Horizontal Table -->
            @if($visibleData && count($visibleData) > 0)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-emerald-600 to-green-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Data Progress</h2>
                            <p class="text-gray-100 text-sm">{{ date('F Y') }} - Real-time funnel tracking</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Funnel Progress Table -->
                    <div class="overflow-x-auto rounded-lg border-2 border-gray-200">
                        <table class="min-w-full text-xs border-collapse">
                            <thead>
                                <tr class="bg-white border-b-2 border-gray-300">
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300 sticky left-0 bg-white z-10">NO</th>
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300 min-w-[150px]">PROJECT</th>
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300">ID LOP</th>
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300">CC</th>
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300">AM</th>
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300">MITRA</th>
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300">PLAN<br>BULAN</th>
                                    <th rowspan="2" class="px-3 py-3 text-center font-bold text-gray-700 border-r-2 border-gray-300">EST NILAI BC</th>
                                    
                                    <!-- F0 -->
                                    <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-blue-600 border-r-2 border-gray-300">F0<br><span class="text-[10px] font-normal">Inisiasi</span></th>
                                    
                                    <!-- F1 -->
                                    <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-purple-600 border-r-2 border-gray-300">F1<br><span class="text-[10px] font-normal">Tech &<br>Budget</span></th>
                                    
                                    <!-- F2 -->
                                    <th colspan="7" class="px-3 py-2 text-center font-bold text-white bg-pink-600 border-r-2 border-gray-300">F2</th>
                                    
                                    <!-- F3 -->
                                    <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-orange-600 border-r-2 border-gray-300">F3</th>
                                    
                                    <!-- F4 -->
                                    <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-green-600 border-r-2 border-gray-300">F4<br><span class="text-[10px] font-normal">Negosiasi</span></th>
                                    
                                    <!-- F5 -->
                                    <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-teal-600 border-r-2 border-gray-300">F5</th>
                                    
                                    <!-- DELIVERY -->
                                    <th colspan="4" class="px-3 py-2 text-center font-bold text-white bg-indigo-600 border-r-2 border-gray-300">DELIVERY</th>
                                    
                                    <!-- BILLING COMPLETE -->
                                    <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-purple-700 border-r-2 border-gray-300">BILLING<br>COMPLETE</th>
                                    
                                    <!-- NILAI BILL COMP -->
                                    <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-purple-800">NILAI<br>BILL<br>COMP</th>
                                </tr>
                                <tr class="bg-gray-50 border-b-2 border-gray-300">
                                    <!-- F2 Sub -->
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P0/P1</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P2</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P3</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P4</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">Offering</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-pink-50 border-r border-gray-200">P5</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-pink-50 border-r-2 border-gray-300">Proposal</th>
                                    
                                    <!-- F3 Sub -->
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-orange-50 border-r border-gray-200">P6</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-orange-50 border-r border-gray-200">P7</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-orange-50 border-r-2 border-gray-300">Submit</th>
                                    
                                    <!-- F5 Sub -->
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-teal-50 border-r border-gray-200">SK<br>Mitra</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-teal-50 border-r border-gray-200">TTD<br>Kontrak</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-teal-50 border-r-2 border-gray-300">P8</th>
                                    
                                    <!-- DELIVERY Sub -->
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-indigo-50 border-r border-gray-200">Kontrak</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-indigo-50 border-r border-gray-200">BAUT/<br>BAST</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-indigo-50 border-r border-gray-200">BASO</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-indigo-50 border-r-2 border-gray-300">Billing</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-indigo-50 border-r border-gray-200">BAUT &<br>BASO</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-indigo-50 border-r border-gray-200">Billing</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-semibold text-gray-700 bg-indigo-50">Nilai<br>BILLCOMP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $totalBillcomp = 0;
                                    
                                    // Helper function to get checkbox state
                                    $getCheckboxState = function($data, $field) use ($selectedUserId) {
                                        if (!$data->funnel) return ['checked' => false, 'count' => 0, 'users' => []];
                                        
                                        if ($selectedUserId) {
                                            // Show specific user's progress
                                            $userProgress = $data->funnel->progress->where('user_id', $selectedUserId)->first();
                                            return [
                                                'checked' => $userProgress && $userProgress->{$field},
                                                'count' => $userProgress && $userProgress->{$field} ? 1 : 0,
                                                'users' => []
                                            ];
                                        } else {
                                            // Aggregate: show if ANY user completed it
                                            $completedProgress = $data->funnel->progress->filter(function($p) use ($field) {
                                                return $p->{$field};
                                            });
                                            
                                            return [
                                                'checked' => $completedProgress->count() > 0,
                                                'count' => $completedProgress->count(),
                                                'users' => $completedProgress->pluck('user.name')->take(3)->toArray()
                                            ];
                                        }
                                    };
                                @endphp
                                @foreach($visibleData as $index => $data)
                                @php
                                    $denganMitra = stripos($data->mitra ?? '', 'dengan') !== false || stripos($data->mitra ?? '', 'with') !== false;
                                    
                                    // Calculate total from task_progress
                                    if ($data->funnel && $data->funnel->progress) {
                                        if ($selectedUserId) {
                                            $userProgress = $data->funnel->progress->where('user_id', $selectedUserId)->first();
                                            if ($userProgress && $userProgress->delivery_billing_complete && $userProgress->delivery_nilai_billcomp) {
                                                $totalBillcomp += floatval($userProgress->delivery_nilai_billcomp);
                                            }
                                        } else {
                                            // Aggregate: sum all users' billcomp
                                            foreach ($data->funnel->progress as $progress) {
                                                if ($progress->delivery_billing_complete && $progress->delivery_nilai_billcomp) {
                                                    $totalBillcomp += floatval($progress->delivery_nilai_billcomp);
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-3 py-2 text-center border-r-2 border-gray-300 font-medium sticky left-0 bg-white">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2 border-r-2 border-gray-300 font-semibold text-gray-900">{{ $data->project ?? $data->company_name ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 text-center border-r-2 border-gray-300">{{ $data->id_lop ?? '-' }}</td>
                                    <td class="px-3 py-2 text-center border-r-2 border-gray-300">{{ $data->cc ?? '-' }}</td>
                                    <td class="px-3 py-2 text-center border-r-2 border-gray-300">{{ $data->am ?? '-' }}</td>
                                    <td class="px-3 py-2 text-center border-r-2 border-gray-300 {{ $denganMitra ? 'bg-green-50 text-green-700 font-bold' : 'bg-gray-50' }}">
                                        {{ $denganMitra ? 'Dengan Mitra' : 'Tanpa Mitra' }}
                                    </td>
                                    <td class="px-3 py-2 text-center border-r-2 border-gray-300">{{ $data->plan_bulan ?? '-' }}</td>
                                    <td class="px-3 py-2 text-right border-r-2 border-gray-300 font-semibold">
                                        {{ $data->est_nilai_bc ? 'Rp ' . number_format(floatval(str_replace([',', '.'], ['', ''], $data->est_nilai_bc)), 0, ',', '.') : '-' }}
                                    </td>
                                    
                                    <!-- F0 -->
                                    @php $f0State = $getCheckboxState($data, 'f0_inisiasi_solusi'); @endphp
                                    <td class="px-2 py-2 text-center bg-blue-50 border-r-2 border-gray-300" title="{{ $f0State['count'] > 0 ? $f0State['count'] . ' user(s): ' . implode(', ', $f0State['users']) : 'Belum ada yang complete' }}">
                                        <input type="checkbox" disabled {{ $f0State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f0State['count'] > 0)
                                            <span class="text-[9px] text-blue-600 font-bold">{{ $f0State['count'] }}</span>
                                        @endif
                                    </td>
                                    
                                    <!-- F1 -->
                                    @php $f1State = $getCheckboxState($data, 'f1_tech_budget'); @endphp
                                    <td class="px-2 py-2 text-center bg-purple-50 border-r-2 border-gray-300" title="{{ $f1State['count'] > 0 ? $f1State['count'] . ' user(s): ' . implode(', ', $f1State['users']) : 'Belum ada yang complete' }}">
                                        <input type="checkbox" disabled {{ $f1State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f1State['count'] > 0)
                                            <span class="text-[9px] text-purple-600 font-bold">{{ $f1State['count'] }}</span>
                                        @endif
                                    </td>
                                    
                                    <!-- F2 -->
                                    @php $f2p0State = $getCheckboxState($data, 'f2_p0_p1'); @endphp
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r border-gray-200" title="{{ $f2p0State['count'] > 0 ? implode(', ', $f2p0State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f2p0State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p0State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold">{{ $f2p0State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f2p2State = $getCheckboxState($data, 'f2_p2'); @endphp
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r border-gray-200" title="{{ $f2p2State['count'] > 0 ? implode(', ', $f2p2State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f2p2State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p2State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold">{{ $f2p2State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f2p3State = $getCheckboxState($data, 'f2_p3'); @endphp
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r border-gray-200" title="{{ $f2p3State['count'] > 0 ? implode(', ', $f2p3State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f2p3State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p3State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold">{{ $f2p3State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f2p4State = $getCheckboxState($data, 'f2_p4'); @endphp
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r border-gray-200" title="{{ $f2p4State['count'] > 0 ? implode(', ', $f2p4State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f2p4State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p4State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold">{{ $f2p4State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f2OfferState = $getCheckboxState($data, 'f2_offering'); @endphp
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r border-gray-200" title="{{ $f2OfferState['count'] > 0 ? implode(', ', $f2OfferState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $f2OfferState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f2OfferState['count'] > 0)<span class="text-[9px] text-pink-600 font-bold">{{ $f2OfferState['count'] }}</span>@endif
                                    </td>
                                    @php $f2p5State = $getCheckboxState($data, 'f2_p5'); @endphp
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r border-gray-200" title="{{ $f2p5State['count'] > 0 ? implode(', ', $f2p5State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f2p5State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p5State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold">{{ $f2p5State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f2PropState = $getCheckboxState($data, 'f2_proposal'); @endphp
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r-2 border-gray-300" title="{{ $f2PropState['count'] > 0 ? implode(', ', $f2PropState['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f2PropState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2PropState['count'] > 0)<span class="text-[9px] text-pink-600 font-bold">{{ $f2PropState['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- F3 -->
                                    @php $f3p6State = $getCheckboxState($data, 'f3_p6'); @endphp
                                    <td class="px-2 py-2 text-center bg-orange-50 border-r border-gray-200" title="{{ $f3p6State['count'] > 0 ? implode(', ', $f3p6State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f3p6State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f3p6State['count'] > 0)<span class="text-[9px] text-orange-600 font-bold">{{ $f3p6State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f3p7State = $getCheckboxState($data, 'f3_p7'); @endphp
                                    <td class="px-2 py-2 text-center bg-orange-50 border-r border-gray-200" title="{{ $f3p7State['count'] > 0 ? implode(', ', $f3p7State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f3p7State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f3p7State['count'] > 0)<span class="text-[9px] text-orange-600 font-bold">{{ $f3p7State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f3SubmitState = $getCheckboxState($data, 'f3_submit'); @endphp
                                    <td class="px-2 py-2 text-center bg-orange-50 border-r-2 border-gray-300" title="{{ $f3SubmitState['count'] > 0 ? implode(', ', $f3SubmitState['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f3SubmitState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f3SubmitState['count'] > 0)<span class="text-[9px] text-orange-600 font-bold">{{ $f3SubmitState['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- F4 -->
                                    @php $f4State = $getCheckboxState($data, 'f4_negosiasi'); @endphp
                                    <td class="px-2 py-2 text-center bg-green-50 border-r-2 border-gray-300" title="{{ $f4State['count'] > 0 ? implode(', ', $f4State['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $f4State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f4State['count'] > 0)<span class="text-[9px] text-green-600 font-bold">{{ $f4State['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- F5 -->
                                    @php $f5SkState = $getCheckboxState($data, 'f5_sk_mitra'); @endphp
                                    <td class="px-2 py-2 text-center bg-teal-50 border-r border-gray-200" title="{{ $f5SkState['count'] > 0 ? implode(', ', $f5SkState['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f5SkState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f5SkState['count'] > 0)<span class="text-[9px] text-teal-600 font-bold">{{ $f5SkState['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    @php $f5TtdState = $getCheckboxState($data, 'f5_ttd_kontrak'); @endphp
                                    <td class="px-2 py-2 text-center bg-teal-50 border-r border-gray-200" title="{{ $f5TtdState['count'] > 0 ? implode(', ', $f5TtdState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $f5TtdState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f5TtdState['count'] > 0)<span class="text-[9px] text-teal-600 font-bold">{{ $f5TtdState['count'] }}</span>@endif
                                    </td>
                                    @php $f5p8State = $getCheckboxState($data, 'f5_p8'); @endphp
                                    <td class="px-2 py-2 text-center bg-teal-50 border-r-2 border-gray-300" title="{{ $f5p8State['count'] > 0 ? implode(', ', $f5p8State['users']) : '' }}">
                                        @if($denganMitra)
                                            <input type="checkbox" disabled {{ $f5p8State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f5p8State['count'] > 0)<span class="text-[9px] text-teal-600 font-bold">{{ $f5p8State['count'] }}</span>@endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- DELIVERY -->
                                    @php 
                                        $delivKontrakState = $getCheckboxState($data, 'delivery_kontrak');
                                        $delivBillState = $getCheckboxState($data, 'delivery_billing_complete');
                                        
                                        // Get BAUT/BAST and BASO from funnel (not task_progress)
                                        $bautBast = $data->funnel && $data->funnel->delivery_baut_bast ? $data->funnel->delivery_baut_bast : '-';
                                        $baso = $data->funnel && $data->funnel->delivery_baso ? $data->funnel->delivery_baso : '-';
                                    @endphp
                                    <td class="px-2 py-2 text-center bg-indigo-50 border-r border-gray-200" title="{{ $delivKontrakState['count'] > 0 ? implode(', ', $delivKontrakState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $delivKontrakState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $delivKontrakState['count'] > 0)<span class="text-[9px] text-indigo-600 font-bold">{{ $delivKontrakState['count'] }}</span>@endif
                                    </td>
                                    <td class="px-2 py-2 text-center bg-indigo-50 border-r border-gray-200">
                                        {{ $bautBast }}
                                    </td>
                                    <td class="px-2 py-2 text-center bg-indigo-50 border-r border-gray-200">
                                        {{ $baso }}
                                    </td>
                                    <td class="px-2 py-2 text-center bg-indigo-50 border-r-2 border-gray-300" title="{{ $delivBillState['count'] > 0 ? implode(', ', $delivBillState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $delivBillState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $delivBillState['count'] > 0)<span class="text-[9px] text-indigo-600 font-bold">{{ $delivBillState['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- BILLING COMPLETE (duplicate of DELIVERY billing) -->
                                    <td class="px-2 py-2 text-center bg-purple-50 border-r-2 border-gray-300" title="{{ $delivBillState['count'] > 0 ? implode(', ', $delivBillState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $delivBillState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $delivBillState['count'] > 0)<span class="text-[9px] text-purple-600 font-bold">{{ $delivBillState['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- NILAI BILL COMP -->
                                    <td class="px-2 py-2 text-right bg-purple-50 font-semibold">
                                        @php
                                            $nilaiDisplay = '-';
                                            if ($data->funnel && $data->funnel->progress) {
                                                if ($selectedUserId) {
                                                    $userProgress = $data->funnel->progress->where('user_id', $selectedUserId)->first();
                                                    if ($userProgress && $userProgress->delivery_billing_complete && $userProgress->delivery_nilai_billcomp) {
                                                        $nilaiDisplay = 'Rp ' . number_format(floatval($userProgress->delivery_nilai_billcomp), 0, ',', '.');
                                                    }
                                                } else {
                                                    // Aggregate: sum all users' billcomp
                                                    $totalNilai = 0;
                                                    foreach ($data->funnel->progress as $progress) {
                                                        if ($progress->delivery_billing_complete && $progress->delivery_nilai_billcomp) {
                                                            $totalNilai += floatval($progress->delivery_nilai_billcomp);
                                                        }
                                                    }
                                                    if ($totalNilai > 0) {
                                                        $nilaiDisplay = 'Rp ' . number_format(floatval($totalNilai), 0, ',', '.');
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $nilaiDisplay }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gradient-to-r from-emerald-100 to-green-100 font-bold border-t-2 border-gray-300">
                                    <td colspan="8" class="px-3 py-3 text-right text-lg border-r-2 border-gray-300">TOTAL:</td>
                                    <td colspan="19" class="px-3 py-3"></td>
                                    <td class="px-3 py-3 text-right text-lg text-green-700">Rp {{ number_format($totalBillcomp, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-xl p-16 text-center border border-gray-200">
                <div class="max-w-md mx-auto">
                    <div class="text-6xl mb-4 text-gray-300">
                        <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Data</h3>
                    <p class="text-gray-500 mb-6">Upload file untuk bulan ini terlebih dahulu</p>
                    <a href="{{ route('admin.upload.category', [$role, $category]) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload File
                    </a>
                </div>
            </div>
            @endif
        @elseif(request('view') == 'full')
            <!-- FULL TABLE VIEW with Original Data + Progress -->
            @if($latestImport && $latestImport->data->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-6">
                    <h2 class="text-2xl font-bold text-white">Laporan Lengkap - {{ $latestImport->file_name }}</h2>
                    <p class="text-emerald-100 text-sm mt-1">
                        {{ date('F Y', mktime(0, 0, 0, $latestImport->month, 1, $latestImport->year)) }} - 
                        {{ $selectedUserId ? 'User: ' . $users->find($selectedUserId)->name : 'Semua User (Aggregate)' }}
                    </p>
                </div>
                
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-xs">
                            <thead class="bg-gradient-to-r from-slate-100 to-gray-200">
                                <tr>
                                    <!-- Original Data Columns -->
                                    <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 sticky left-0 bg-slate-100 z-10">NO</th>
                                    <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-slate-100">PROJECT</th>
                                    <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-emerald-50">ID LOP</th>
                                    <th rowspan="2" class="px-3 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">CC</th>
                                    <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">AM</th>
                                    <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-emerald-50">Mitra</th>
                                    <th rowspan="2" class="px-4 py-2 text-left font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Plan Bulan</th>
                                    <th rowspan="2" class="px-4 py-2 text-right font-bold text-gray-700 uppercase tracking-wider border-r-2 border-gray-400 bg-amber-50">Est Nilai BC</th>
                                    
                                    <!-- Progress Columns -->
                                    <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border-r">F0</th>
                                    <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-purple-600 to-purple-700 border-r">F1</th>
                                    <th colspan="7" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-pink-600 to-pink-700 border-r">F2</th>
                                    <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-orange-600 to-orange-700 border-r">F3</th>
                                    <th class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-teal-600 to-teal-700 border-r">F4</th>
                                    <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-green-600 to-emerald-700 border-r">F5</th>
                                    <th colspan="3" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-800 border-r">DELIVERY</th>
                                    <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 border-r">BILLING<br>COMPLETE</th>
                                    <th rowspan="2" class="px-3 py-2 text-center font-bold text-white bg-gradient-to-r from-violet-600 to-violet-700">NILAI<br>BILL COMP</th>
                                </tr>
                                <tr class="text-xs">
                                    <!-- F0 Sub-header -->
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-blue-50 border-r">Inisiasi</th>
                                    <!-- F1 Sub-header -->
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-purple-50 border-r">Tech &<br>Budget</th>
                                    <!-- F2 Sub-headers -->
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r">P0/P1</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r">P2</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r">P3</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r">P4</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r">Offering</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r">P5</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-pink-50 border-r">Proposal</th>
                                    <!-- F3 Sub-headers -->
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r">P6</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r">P7</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-orange-50 border-r">Submit</th>
                                    <!-- F4 Sub-header -->
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-teal-50 border-r">Negosiasi</th>
                                    <!-- F5 Sub-headers -->
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r">SK<br>Mitra</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r">TTD<br>Kontrak</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-green-50 border-r">P8</th>
                                    <!-- DELIVERY Sub-headers -->
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r">Kontrak</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r">BAUT/<br>BAST</th>
                                    <th class="px-2 py-1.5 text-center text-gray-700 font-semibold bg-emerald-50 border-r">BASO</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php 
                                    $totalEstNilai = 0;
                                    $totalBillcomp = 0;
                                    
                                    // Helper function to get checkbox state
                                    $getCheckboxState = function($data, $field) use ($selectedUserId) {
                                        if (!$data->funnel) return ['checked' => false, 'count' => 0, 'users' => []];
                                        
                                        $todayProgress = $data->funnel->todayProgress;
                                        
                                        if ($selectedUserId) {
                                            // Show specific user's progress
                                            return [
                                                'checked'  => $todayProgress && $todayProgress->{$field},
                                                'count' => $todayProgress && $todayProgress->{$field} ? 1 : 0,
                                                'users' => []
                                            ];
                                        } else {
                                            // Aggregate: show if ANY user completed it
                                            $completedProgress = $data->funnel->progress->filter(function($p) use ($field) {
                                                return $p->{$field};
                                            });
                                            
                                            return [
                                                'checked' => $completedProgress->count() > 0,
                                                'count' => $completedProgress->count(),
                                                'users' => $completedProgress->pluck('user.name')->take(3)->toArray()
                                            ];
                                        }
                                    };
                                @endphp
                                
                                @foreach($latestImport->data as $index => $row)
                                @php
                                    // Skip TOTAL row in body
                                    if (strtoupper(trim($row->no ?? '')) === 'TOTAL') {
                                        continue;
                                    }
                                    
                                    $funnel = $row->funnel;
                                    $denganMitra = stripos($row->mitra ?? '', 'dengan') !== false;
                                    
                                    // Calculate totals
                                    $cleanValue = str_replace(['.', ','], '', $row->est_nilai_bc ?? '0');
                                    $totalEstNilai += (int) $cleanValue;
                                    
                                    // Calculate bill comp total
                                    if ($funnel && $funnel->progress) {
                                        if ($selectedUserId) {
                                            $userProgress = $funnel->progress->where('user_id', $selectedUserId)->first();
                                            if ($userProgress && $userProgress->delivery_billing_complete && $userProgress->delivery_nilai_billcomp) {
                                                $totalBillcomp += floatval($userProgress->delivery_nilai_billcomp);
                                            }
                                        } else {
                                            foreach ($funnel->progress as $progress) {
                                                if ($progress->delivery_billing_complete && $progress->delivery_nilai_billcomp) {
                                                    $totalBillcomp += floatval($progress->delivery_nilai_billcomp);
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Original Data -->
                                    <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 border-r sticky left-0 bg-white z-5">{{ $row->no }}</td>
                                    <td class="px-4 py-2 text-gray-700 border-r bg-white">{{ $row->project }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r bg-emerald-50 font-medium">{{ $row->id_lop }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-gray-700 border-r">{{ $row->cc }}</td>
                                    <td class="px-4 py-2 text-gray-700 border-r">{{ $row->am }}</td>
                                    <td class="px-4 py-2 text-gray-700 border-r bg-emerald-50 font-semibold">{{ $row->mitra }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-700 border-r text-center">{{ $row->plan_bulan_billcom_p_2025 }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap font-semibold text-gray-900 border-r-2 border-gray-400 bg-amber-50 text-right">{{ $row->est_nilai_bc }}</td>
                                    
                                    <!-- Progress Checkboxes - Read-only for admin -->
                                    @php
                                        $f0State = $getCheckboxState($row, 'f0_inisiasi_solusi');
                                        $f1State = $getCheckboxState($row, 'f1_tech_budget');
                                        $f2p0State = $getCheckboxState($row, 'f2_p0_p1');
                                        $f2p2State = $getCheckboxState($row, 'f2_p2');
                                        $f2p3State = $getCheckboxState($row, 'f2_p3');
                                        $f2p4State = $getCheckboxState($row, 'f2_p4');
                                        $f2OfferState = $getCheckboxState($row, 'f2_offering');
                                        $f2p5State = $getCheckboxState($row, 'f2_p5');
                                        $f2PropState = $getCheckboxState($row, 'f2_proposal');
                                        $f3p6State = $getCheckboxState($row, 'f3_p6');
                                        $f3p7State = $getCheckboxState($row, 'f3_p7');
                                        $f3SubmitState = $getCheckboxState($row, 'f3_submit');
                                        $f4State = $getCheckboxState($row, 'f4_negosiasi');
                                        $f5SkState = $getCheckboxState($row, 'f5_sk_mitra');
                                        $f5TtdState = $getCheckboxState($row, 'f5_ttd_kontrak');
                                        $f5p8State = $getCheckboxState($row, 'f5_p8');
                                        $delivKontrakState = $getCheckboxState($row, 'delivery_kontrak');
                                        $delivBillState = $getCheckboxState($row, 'delivery_billing_complete');
                                    @endphp
                                    
                                    <!-- F0 -->
                                    <td class="px-2 py-2 text-center bg-blue-50 border-r" title="{{ $f0State['count'] > 0 ? $f0State['count'] . ' user(s): ' . implode(', ', $f0State['users']) : 'Belum ada yang complete' }}">
                                        <input type="checkbox" disabled {{ $f0State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f0State['count'] > 0)<span class="text-[9px] text-blue-600 font-bold block">{{ $f0State['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- F1 -->
                                    <td class="px-2 py-2 text-center bg-purple-50 border-r" title="{{ $f1State['count'] > 0 ? $f1State['count'] . ' user(s): ' . implode(', ', $f1State['users']) : 'Belum ada yang complete' }}">
                                        <input type="checkbox" disabled {{ $f1State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f1State['count'] > 0)<span class="text-[9px] text-purple-600 font-bold block">{{ $f1State['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- F2 Fields -->
                                    @if($denganMitra)
                                        <td class="px-2 py-2 text-center bg-pink-50 border-r" title="{{ $f2p0State['count'] > 0 ? implode(', ', $f2p0State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f2p0State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p0State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold block">{{ $f2p0State['count'] }}</span>@endif
                                        </td>
                                        <td class="px-2 py-2 text-center bg-pink-50 border-r" title="{{ $f2p2State['count'] > 0 ? implode(', ', $f2p2State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f2p2State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p2State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold block">{{ $f2p2State['count'] }}</span>@endif
                                        </td>
                                        <td class="px-2 py-2 text-center bg-pink-50 border-r" title="{{ $f2p3State['count'] > 0 ? implode(', ', $f2p3State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f2p3State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p3State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold block">{{ $f2p3State['count'] }}</span>@endif
                                        </td>
                                        <td class="px-2 py-2 text-center bg-pink-50 border-r" title="{{ $f2p4State['count'] > 0 ? implode(', ', $f2p4State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f2p4State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p4State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold block">{{ $f2p4State['count'] }}</span>@endif
                                        </td>
                                        <td class="px-2 py-2 text-center bg-pink-50 border-r" title="{{ $f2OfferState['count'] > 0 ? implode(', ', $f2OfferState['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f2OfferState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2OfferState['count'] > 0)<span class="text-[9px] text-pink-600 font-bold block">{{ $f2OfferState['count'] }}</span>@endif
                                        </td>
                                        <td class="px-2 py-2 text-center bg-pink-50 border-r" title="{{ $f2p5State['count'] > 0 ? implode(', ', $f2p5State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f2p5State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f2p5State['count'] > 0)<span class="text-[9px] text-pink-600 font-bold block">{{ $f2p5State['count'] }}</span>@endif
                                        </td>
                                    @else
                                        <td colspan="6" class="px-2 py-2 text-center bg-pink-50 border-r text-gray-400">-</td>
                                    @endif
                                    <td class="px-2 py-2 text-center bg-pink-50 border-r" title="{{ $f2PropState['count'] > 0 ? implode(', ', $f2PropState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $f2PropState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f2PropState['count'] > 0)<span class="text-[9px] text-pink-600 font-bold block">{{ $f2PropState['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- F3 Fields -->
                                    @if($denganMitra)
                                        <td class="px-2 py-2 text-center bg-orange-50 border-r" title="{{ $f3p6State['count'] > 0 ? implode(', ', $f3p6State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f3p6State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f3p6State['count'] > 0)<span class="text-[9px] text-orange-600 font-bold block">{{ $f3p6State['count'] }}</span>@endif
                                        </td>
                                        <td class="px-2 py-2 text-center bg-orange-50 border-r" title="{{ $f3p7State['count'] > 0 ? implode(', ', $f3p7State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f3p7State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f3p7State['count'] > 0)<span class="text-[9px] text-orange-600 font-bold block">{{ $f3p7State['count'] }}</span>@endif
                                        </td>
                                    @else
                                        <td colspan="2" class="px-2 py-2 text-center bg-orange-50 border-r text-gray-400">-</td>
                                    @endif
                                    <td class="px-2 py-2 text-center bg-orange-50 border-r" title="{{ $f3SubmitState['count'] > 0 ? implode(', ', $f3SubmitState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $f3SubmitState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f3SubmitState['count'] > 0)<span class="text-[9px] text-orange-600 font-bold block">{{ $f3SubmitState['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- F4 -->
                                    <td class="px-2 py-2 text-center bg-teal-50 border-r" title="{{ $f4State['count'] > 0 ? implode(', ', $f4State['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $f4State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f4State['count'] > 0)<span class="text-[9px] text-teal-600 font-bold block">{{ $f4State['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- F5 Fields -->
                                    @if($denganMitra)
                                        <td class="px-2 py-2 text-center bg-green-50 border-r" title="{{ $f5SkState['count'] > 0 ? implode(', ', $f5SkState['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f5SkState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f5SkState['count'] > 0)<span class="text-[9px] text-green-600 font-bold block">{{ $f5SkState['count'] }}</span>@endif
                                        </td>
                                    @else
                                        <td class="px-2 py-2 text-center bg-green-50 border-r text-gray-400">-</td>
                                    @endif
                                    <td class="px-2 py-2 text-center bg-green-50 border-r" title="{{ $f5TtdState['count'] > 0 ? implode(', ', $f5TtdState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $f5TtdState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $f5TtdState['count'] > 0)<span class="text-[9px] text-green-600 font-bold block">{{ $f5TtdState['count'] }}</span>@endif
                                    </td>
                                    @if($denganMitra)
                                        <td class="px-2 py-2 text-center bg-green-50 border-r" title="{{ $f5p8State['count'] > 0 ? implode(', ', $f5p8State['users']) : '' }}">
                                            <input type="checkbox" disabled {{ $f5p8State['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                            @if(!$selectedUserId && $f5p8State['count'] > 0)<span class="text-[9px] text-green-600 font-bold block">{{ $f5p8State['count'] }}</span>@endif
                                        </td>
                                    @else
                                        <td class="px-2 py-2 text-center bg-green-50 border-r text-gray-400">-</td>
                                    @endif
                                    
                                    <!-- DELIVERY -->
                                    <td class="px-2 py-2 text-center bg-emerald-50 border-r" title="{{ $delivKontrakState['count'] > 0 ? implode(', ', $delivKontrakState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $delivKontrakState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $delivKontrakState['count'] > 0)<span class="text-[9px] text-emerald-600 font-bold block">{{ $delivKontrakState['count'] }}</span>@endif
                                    </td>
                                    <td class="px-2 py-2 text-center bg-emerald-50 border-r">
                                        <span class="text-xs {{ $funnel && $funnel->delivery_baut_bast ? 'text-emerald-700 font-semibold' : 'text-gray-400' }}">
                                            {{ $funnel && $funnel->delivery_baut_bast ? $funnel->delivery_baut_bast : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 text-center bg-emerald-50 border-r">
                                        <span class="text-xs {{ $funnel && $funnel->delivery_baso ? 'text-emerald-700 font-semibold' : 'text-gray-400' }}">
                                            {{ $funnel && $funnel->delivery_baso ? $funnel->delivery_baso : '-' }}
                                        </span>
                                    </td>
                                    
                                    <!-- BILLING COMPLETE -->
                                    <td class="px-2 py-2 text-center bg-indigo-50 border-r" title="{{ $delivBillState['count'] > 0 ? implode(', ', $delivBillState['users']) : '' }}">
                                        <input type="checkbox" disabled {{ $delivBillState['checked'] ? 'checked' : '' }} class="w-4 h-4">
                                        @if(!$selectedUserId && $delivBillState['count'] > 0)<span class="text-[9px] text-indigo-600 font-bold block">{{ $delivBillState['count'] }}</span>@endif
                                    </td>
                                    
                                    <!-- NILAI BILL COMP -->
                                    <td class="px-2 py-2 text-right bg-violet-50 font-semibold">
                                        @php
                                            $nilaiDisplay = '-';
                                            if ($funnel && $funnel->progress) {
                                                if ($selectedUserId) {
                                                    $userProgress = $funnel->progress->where('user_id', $selectedUserId)->first();
                                                    if ($userProgress && $userProgress->delivery_billing_complete && $userProgress->delivery_nilai_billcomp) {
                                                        $nilaiDisplay = number_format(floatval($userProgress->delivery_nilai_billcomp), 0, ',', '.');
                                                    }
                                                } else {
                                                    $totalNilai = 0;
                                                    foreach ($funnel->progress as $progress) {
                                                        if ($progress->delivery_billing_complete && $progress->delivery_nilai_billcomp) {
                                                            $totalNilai += floatval($progress->delivery_nilai_billcomp);
                                                        }
                                                    }
                                                    if ($totalNilai > 0) {
                                                        $nilaiDisplay = number_format(floatval($totalNilai), 0, ',', '.');
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $nilaiDisplay }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr class="border-t-2 border-emerald-500">
                                    <td colspan="7" class="px-4 py-4 text-right font-bold text-gray-900 border-r">TOTAL:</td>
                                    <td class="px-4 py-4 text-right font-bold text-emerald-700 text-lg border-r-2 border-gray-400 bg-emerald-50">
                                        {{ number_format($totalEstNilai, 0, ',', '.') }}
                                    </td>
                                    <td colspan="20" class="border-r"></td>
                                    <td class="px-4 py-4 text-right font-bold text-violet-700 text-lg bg-violet-50">
                                        {{ number_format($totalBillcomp, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-xl p-16 text-center border border-gray-200">
                <div class="max-w-md mx-auto">
                    <div class="text-6xl mb-4 text-gray-300">
                        <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Data</h3>
                    <p class="text-gray-500 mb-6">Upload file untuk bulan yang dipilih terlebih dahulu</p>
                    <a href="{{ route('admin.upload.category', [$role, $category]) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload File
                    </a>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
