@extends('layouts.app')

@section('title', 'Admin - Progress ' . ucfirst(str_replace('_', ' ', $category)))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-8">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.role.menu', $role) }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Menu
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Progress LOP {{ ucfirst(str_replace('_', ' ', $category)) }}</h1>
                <p class="text-gray-600 mt-1">{{ ucfirst($role) }} - Monitoring real-time update dari user</p>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent mt-6"></div>
        </div>

        <!-- Toggle: Current Month vs History -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg p-2 inline-flex gap-2">
                <a href="{{ route('admin.progress.category', [$role, $category]) }}" 
                   class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 {{ !request('view') || request('view') == 'current' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    Progress Bulan Ini
                </a>
                <a href="{{ route('admin.progress.category', [$role, $category]) }}?view=history" 
                   class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 {{ request('view') == 'history' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    Riwayat
                </a>
            </div>
        </div>

        <!-- Toggle: Current Month vs History -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg p-2 inline-flex gap-2">
                <a href="{{ route('admin.progress.category', [$role, $category]) }}" 
                   class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 {{ !request('view') || request('view') == 'current' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    Progress Bulan Ini
                </a>
                <a href="{{ route('admin.progress.category', [$role, $category]) }}?view=history" 
                   class="px-6 py-3 rounded-lg font-semibold transition-all duration-300 {{ request('view') == 'history' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    Riwayat
                </a>
            </div>
        </div>

        @if(!request('view') || request('view') == 'current')
            <!-- CURRENT MONTH Progress View -->
            @if($currentMonthData)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-emerald-600 to-green-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Data Bulan Ini</h2>
                            <p class="text-gray-100 text-sm">
                                {{ date('F Y', mktime(0, 0, 0, $currentMonthData->month, 1, $currentMonthData->year)) }} 
                                - {{ $currentMonthData->file_name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-emerald-100 text-sm">Total Rows</p>
                            <p class="text-3xl font-bold text-white">{{ $currentMonthData->total_rows }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Filters -->
                    <div class="mb-6 flex gap-4">
                        <form method="GET" class="flex gap-4 flex-1">
                            <input type="hidden" name="view" value="current">
                            <div class="flex-1">
                                <select name="user" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">Semua User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-all">
                                Filter
                            </button>
                            @if(request('user'))
                            <a href="{{ route('admin.progress.category', [$role, $category]) }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold transition-all">
                                Reset
                            </a>
                            @endif
                        </form>
                    </div>

                    <!-- Data Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">
                                        @if($category === 'on_hand')
                                            Project
                                        @elseif($category === 'qualified')
                                            Company Name
                                        @else
                                            Project
                                        @endif
                                    </th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">ID LOP</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Last Updated By</th>
                                    <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Last Update</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($currentMonthData->data as $index => $data)
                                    @if(!request('user') || ($data->funnel && $data->funnel->updated_by == request('user')))
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-gray-700 font-semibold">
                                            @if($category === 'on_hand')
                                                {{ $data->project ?? 'N/A' }}
                                            @elseif($category === 'qualified')
                                                {{ $data->company_name ?? 'N/A' }}
                                            @else
                                                {{ $data->project ?? $data->company_name ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">{{ $data->id_lop ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($data->funnel && $data->funnel->updated_by)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold text-xs">
                                                    Updated
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full font-bold text-xs">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">
                                            @if($data->funnel && $data->funnel->updatedByUser)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                                        <span class="text-emerald-700 font-bold text-xs">
                                                            {{ strtoupper(substr($data->funnel->updatedByUser->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    <span class="font-semibold">{{ $data->funnel->updatedByUser->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">Belum ada update</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">
                                            @if($data->funnel && $data->funnel->last_updated_at)
                                                <div class="flex flex-col">
                                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($data->funnel->last_updated_at)->format('d M Y') }}</span>
                                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($data->funnel->last_updated_at)->format('H:i') }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                            <p class="font-semibold text-lg">Belum ada data untuk bulan ini</p>
                                            <p class="text-sm mt-1">Upload file untuk melihat data</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
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
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Data Bulan Ini</h3>
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

        @else
            <!-- HISTORY View -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-slate-700 to-gray-800 p-6">
                    <h2 class="text-2xl font-bold text-white">Riwayat Upload</h2>
                    <p class="text-gray-300 text-sm">Pilih periode untuk melihat progress detail</p>
                </div>

                <div class="p-6">
                    @forelse($uploads as $upload)
                    <div class="mb-4 last:mb-0">
                        <a href="{{ route('admin.progress.category', [$role, $category]) }}?month={{ $upload->month }}&year={{ $upload->year }}" 
                           class="block bg-gradient-to-r from-gray-50 to-slate-50 hover:from-gray-100 hover:to-slate-100 border-2 border-gray-200 hover:border-emerald-400 rounded-xl p-6 transition-all duration-300 transform hover:scale-[1.02]">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-2">
                                        <div class="bg-emerald-100 px-4 py-2 rounded-lg">
                                            <span class="font-bold text-emerald-700">
                                                {{ date('F Y', mktime(0, 0, 0, $upload->month, 1, $upload->year)) }}
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-lg">{{ $upload->file_name }}</h3>
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
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
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
        @endif
    </div>
</div>
@endsection
