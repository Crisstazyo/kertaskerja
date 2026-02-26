@extends('layouts.app')

@section('title', 'Current Progress - ' . ucfirst($roleNormalized))

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
                        Progress Saat Ini - {{ ucfirst($roleNormalized) }}
                    </h1>
                    <p class="text-gray-600">
                        Data upload untuk periode: {{ \Carbon\Carbon::parse($currentMonth)->format('F Y') }}
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Upload Bulan Ini</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalUploads }}</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Data Rows</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($totalRows) }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Month Data -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center space-x-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Data Upload Details</span>
            </h2>

            @if($currentData->count() > 0)
                @foreach($currentData as $data)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>{{ $data->file_name }}</span>
                                </h3>
                                <p class="text-sm text-blue-100 mt-1">
                                    Uploaded by {{ $data->uploaded_by }} on {{ $data->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <span class="bg-white bg-opacity-20 px-4 py-2 rounded-md font-medium">
                                {{ is_array($data->data) ? count($data->data) - 1 : 0 }} rows
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            @if(is_array($data->data) && count($data->data) > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @if(isset($data->data[0]) && is_array($data->data[0]))
                                            @foreach($data->data[0] as $index => $header)
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ $header ?? "Column " . ($index + 1) }}
                                            </th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(array_slice($data->data, 1, 5) as $rowIndex => $row)
                                    <tr class="hover:bg-gray-50">
                                        @if(is_array($row))
                                            @foreach($row as $cell)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $cell }}
                                            </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(count($data->data) > 6)
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Showing first 5 rows of {{ count($data->data) - 1 }} total data rows</p>
                            </div>
                            @endif
                            @else
                            <p class="text-gray-600 text-center py-4">No data available in this upload</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">No Data Yet</h3>
                <p class="mt-2 text-gray-600">Tidak ada upload untuk bulan ini</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
