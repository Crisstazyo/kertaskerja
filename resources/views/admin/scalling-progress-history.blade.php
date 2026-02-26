@extends('layouts.app')

@section('title', 'Progress History - ' . ucfirst($roleNormalized))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.scalling', $role) }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">
                        ← Back to Scalling Management
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        Riwayat Progress - {{ ucfirst($roleNormalized) }}
                    </h1>
                    <p class="text-gray-600">
                        Semua data historis upload dan progress
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

        <!-- Overall Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Upload (All Time)</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalUploads }}</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Unique Periods</p>
                        <p class="text-3xl font-bold text-green-600">{{ $uniquePeriods }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historical Data -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center space-x-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Historical Upload Data</span>
            </h2>

            @if($historyData->count() > 0)
                @foreach($historyData as $data)
                <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-500 overflow-hidden mb-6 hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $data->file_name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="font-medium">Periode:</span> 
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                                            {{ $data->periode ? \Carbon\Carbon::parse($data->periode)->format('F Y') : 'N/A' }}
                                        </span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Uploaded by {{ $data->uploaded_by }} on {{ $data->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">
                                    {{ is_array($data->data) ? count($data->data) - 1 : 0 }} rows
                                </span>
                            </div>
                        </div>
                        
                        <!-- Preview Button or Data Summary -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <details class="group">
                                <summary class="cursor-pointer text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center space-x-2">
                                    <span>Show Data Preview</span>
                                    <svg class="w-4 h-4 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </summary>
                                <div class="mt-4 overflow-x-auto">
                                    @if(is_array($data->data) && count($data->data) > 0)
                                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                @if(isset($data->data[0]) && is_array($data->data[0]))
                                                    @foreach($data->data[0] as $index => $header)
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ $header ?? "Column " . ($index + 1) }}
                                                    </th>
                                                    @endforeach
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach(array_slice($data->data, 1, 3) as $rowIndex => $row)
                                            <tr class="hover:bg-gray-50">
                                                @if(is_array($row))
                                                    @foreach($row as $cell)
                                                    <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900">
                                                        {{ $cell }}
                                                    </td>
                                                    @endforeach
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if(count($data->data) > 4)
                                    <div class="mt-2 text-center">
                                        <p class="text-xs text-gray-500">Showing first 3 rows of {{ count($data->data) - 1 }} total data rows</p>
                                    </div>
                                    @endif
                                    @else
                                    <p class="text-gray-600 text-center py-4 text-sm">No data available</p>
                                    @endif
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                @if($historyData->hasPages())
                <div class="mt-6">
                    {{ $historyData->links() }}
                </div>
                @endif
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">No Historical Data</h3>
                <p class="mt-2 text-gray-600">Belum ada data upload sama sekali</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
