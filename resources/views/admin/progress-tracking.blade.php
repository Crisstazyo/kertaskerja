@extends('layouts.app')

@section('title', 'Admin - Progress Tracking')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-blue-100">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.scalling') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">Progress Tracking</h1>
                        <p class="text-gray-600 mt-1">Monitor and track all data progress</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-2xl shadow-lg mb-8 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Tracked Items -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-blue-100 hover:shadow-xl transition duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Items</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $progressData->total() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Recently Updated -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-green-100 hover:shadow-xl transition duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Last 24h</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $recentlyUpdated ?? 0 }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-full p-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Items -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-100 hover:shadow-xl transition duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingItems ?? 0 }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full p-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Items -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-purple-100 hover:shadow-xl transition duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completed</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $completedItems ?? 0 }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-full p-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-blue-100">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter Options
            </h2>
            <form method="GET" action="{{ route('admin.progress-tracking') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- User Filter -->
                    <div>
                        <label for="user_filter" class="block text-sm font-semibold text-gray-700 mb-2">User</label>
                        <select name="user_filter" id="user_filter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_filter') == $user->id ? 'selected' : '' }}>
                                    {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Data Type Filter -->
                    <div>
                        <label for="data_type_filter" class="block text-sm font-semibold text-gray-700 mb-2">Data Type</label>
                        <select name="data_type_filter" id="data_type_filter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            <option value="all" {{ request('data_type_filter') == 'all' ? 'selected' : '' }}>All Types</option>
                            <option value="on_hand" {{ request('data_type_filter') == 'on_hand' ? 'selected' : '' }}>On Hand</option>
                            <option value="qualified" {{ request('data_type_filter') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="koreksi" {{ request('data_type_filter') == 'koreksi' ? 'selected' : '' }}>Koreksi</option>
                            <option value="initiate" {{ request('data_type_filter') == 'initiate' ? 'selected' : '' }}>Initiate</option>
                        </select>
                    </div>

                    <!-- Date From Filter -->
                    <div>
                        <label for="date_from" class="block text-sm font-semibold text-gray-700 mb-2">Date From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                    </div>

                    <!-- Date To Filter -->
                    <div>
                        <label for="date_to" class="block text-sm font-semibold text-gray-700 mb-2">Date To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Apply Filter
                    </button>
                    <a href="{{ route('admin.progress-tracking') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- Progress Tracking Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-blue-100">
            <div class="overflow-x-auto">
                @if($progressData->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-green-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Data Type
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Project Name
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                ID LOP
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Last Updated At
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Updated By
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($progressData as $item)
                        <tr class="hover:bg-blue-50 transition duration-200">
                            <!-- Data Type Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $badgeColors = [
                                        'on_hand' => 'bg-gradient-to-r from-blue-500 to-blue-600',
                                        'qualified' => 'bg-gradient-to-r from-green-500 to-green-600',
                                        'koreksi' => 'bg-gradient-to-r from-yellow-500 to-yellow-600',
                                        'initiate' => 'bg-gradient-to-r from-purple-500 to-purple-600',
                                    ];
                                    $badgeClass = $badgeColors[$item->data_type] ?? 'bg-gradient-to-r from-gray-500 to-gray-600';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white {{ $badgeClass }} shadow-md">
                                    {{ ucfirst(str_replace('_', ' ', $item->data_type)) }}
                                </span>
                            </td>

                            <!-- Project Name -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $item->relatedData->project_name ?? 'N/A' }}
                                </div>
                            </td>

                            <!-- ID LOP -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-semibold">
                                    {{ $item->relatedData->id_lop ?? 'N/A' }}
                                </div>
                            </td>

                            <!-- Last Updated At -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $item->updated_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $item->updated_at->format('H:i:s') }}
                                </div>
                            </td>

                            <!-- Updated By -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $item->updatedBy->email ?? 'System' }}
                                </div>
                            </td>

                            <!-- Status Indicator -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->is_completed)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 shadow-md">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-gradient-to-r from-yellow-500 to-yellow-600 shadow-md">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.progress-tracking.detail', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="bg-gradient-to-r from-blue-50 to-green-50 px-6 py-4 border-t border-gray-200">
                    {{ $progressData->links() }}
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-xl font-bold text-gray-900">No Progress Data Found</h3>
                    <p class="mt-2 text-gray-600">There are currently no progress tracking records to display.</p>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or check back later.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection
