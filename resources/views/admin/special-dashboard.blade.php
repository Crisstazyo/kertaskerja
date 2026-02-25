@extends('layouts.app')

@section('title', ucfirst($role) . ' - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm mb-3 inline-block transition-colors">
                    Back to Admin Dashboard
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    @if($role === 'collection') Collection
                    @elseif($role === 'ctc') CTC
                    @else Rising Star
                    @endif
                    User Activity Dashboard
                </h1>
                <p class="text-gray-600">Monitor and track user activities with detailed timestamps</p>
            </div>
            <div class="h-px bg-gray-200"></div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Activity</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Date From Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" id="dateFrom" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <!-- Date To Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" id="dateTo" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
            </div>

            <div class="mt-4 flex gap-3">
                <button onclick="applyFilter()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                    Apply Filter
                </button>
                <button onclick="resetFilter()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                    Reset
                </button>
            </div>
        </div>

        <!-- Activity Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Activities</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Module</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Data ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Updated At</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($activities as $index => $activity)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ ($activities->currentPage() - 1) * $activities->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr($activity->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $activity->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $activity->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ $activity->module ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $activity->action ?? 'Update' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->data_id ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $activity->created_at->format('d M Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $activity->updated_at->format('d M Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <button onclick="viewDetail({{ $activity->id }})" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                    View Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <div class="w-8 h-8 border-4 border-gray-300 border-t-gray-600 rounded-full"></div>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900 mb-1">No activity data available</p>
                                    <p class="text-sm text-gray-500">User activities will appear here once they start using the system</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $activities->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function applyFilter() {
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    const params = new URLSearchParams();
    if (dateFrom) params.append('date_from', dateFrom);
    if (dateTo) params.append('date_to', dateTo);
    
    const url = `{{ route('admin.special.dashboard', $role) }}` + (params.toString() ? `?${params.toString()}` : '');
    window.location.href = url;
}

function resetFilter() {
    window.location.href = `{{ route('admin.special.dashboard', $role) }}`;
}

function viewDetail(activityId) {
    alert('Detail view for activity ID: ' + activityId + '\n\nThis feature can be implemented to show detailed information about the activity.');
}

// Set default date values from URL params
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('date_from')) {
        document.getElementById('dateFrom').value = urlParams.get('date_from');
    }
    if (urlParams.has('date_to')) {
        document.getElementById('dateTo').value = urlParams.get('date_to');
    }
});
</script>
@endsection
