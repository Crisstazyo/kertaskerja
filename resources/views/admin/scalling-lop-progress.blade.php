@extends('layouts.app')

@section('title', 'Progress - LOP ' . ucfirst($lopTypeDisplay) . ' - ' . ucfirst($roleNormalized))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.scalling.lop', [$role, $lopType]) }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">
                        ← Back to LOP {{ $lopTypeDisplay }}
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        Progress User - LOP {{ $lopTypeDisplay }}
                    </h1>
                    <p class="text-gray-600">
                        Progress yang diupdate oleh user saat ini untuk {{ ucfirst($roleNormalized) }}
                    </p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md font-medium transition-colors">
                        Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-green-500 to-teal-500 rounded-full"></div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Users Active</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $progressData->count() }}</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Progress Updates</p>
                        <p class="text-3xl font-bold text-green-600">{{ $totalUpdates }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Last Update</p>
                        <p class="text-lg font-bold text-purple-600">{{ $lastUpdate }}</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Progress User -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center space-x-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Tabel Progress Update User</span>
            </h2>

            @if($progressData->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Data ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Progress</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Last Update</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($progressData as $progress)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $progress->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ $progress->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($progress->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                #{{ $progress->task->data_id ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($progress->is_completed)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">In Progress</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-xs">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress->is_completed ? 100 : 50 }}%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600">{{ $progress->is_completed ? 100 : 50 }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $progress->updated_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($progressData->hasPages())
            <div class="mt-6">
                {{ $progressData->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">Tidak Ada Progress</h3>
                <p class="mt-2 text-gray-600">Belum ada user yang mengupdate progress untuk LOP ini</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
