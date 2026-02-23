@extends('layouts.app')

@section('title', 'Government - Scalling Data')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('gov.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">← Back to Dashboard</a>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📊 Scalling Data</h1>
                    <p class="text-gray-600 text-lg">View & Fill Forms</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        🚪 Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-green-500 to-teal-500 rounded-full"></div>
        </div>

        <!-- Data Display -->
        <div class="space-y-8">
            @forelse($scallingData as $data)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-gray-100">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">📄 {{ $data->file_name }}</h3>
                            <p class="text-sm text-blue-100 mt-1">Uploaded on {{ $data->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg font-semibold">
                            {{ count($data->data) }} rows
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">🔒 Admin Data (Read Only)</h4>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
                            <thead class="bg-blue-50">
                                <tr>
                                    @if(isset($data->data[0]))
                                        @foreach($data->data[0] as $index => $header)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                                            {{ $header ?? "Column " . ($index + 1) }}
                                        </th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(array_slice($data->data, 1) as $rowIndex => $row)
                                <tr class="hover:bg-gray-50">
                                    @foreach($row as $cell)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 border-r border-gray-200">
                                        {{ $cell }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Gov Response Format Table -->
                    <div class="border-t-4 border-green-500 pt-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">✍️ Your Response Form (Editable)</h4>
                        <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6">
                            <p class="text-sm text-gray-600 mb-4">
                                <span class="font-semibold text-green-700">Auto-Generated Form:</span> Fill in your data for each row below
                            </p>
                            
                            @foreach(array_slice($data->data, 1) as $rowIndex => $row)
                            <div class="bg-white rounded-lg p-4 mb-4 border border-green-300">
                                <div class="flex items-center justify-between mb-3">
                                    <h5 class="font-bold text-gray-800">Row {{ $rowIndex + 1 }}</h5>
                                    @php
                                        $userResponse = $data->responses->where('row_index', $rowIndex)->first();
                                    @endphp
                                    @if($userResponse)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        ✓ Filled
                                    </span>
                                    @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        ⏳ Pending
                                    </span>
                                    @endif
                                </div>
                                
                                <!-- Example Format Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <input type="text" 
                                               value="{{ $userResponse->response_data['status'] ?? '' }}" 
                                               disabled
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                                               placeholder="Auto format field">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                        <input type="text" 
                                               value="{{ $userResponse->response_data['notes'] ?? '' }}" 
                                               disabled
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                                               placeholder="Auto format field">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Progress (%)</label>
                                        <input type="text" 
                                               value="{{ $userResponse->response_data['progress'] ?? '' }}" 
                                               disabled
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                                               placeholder="Auto format field">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                                        <input type="text" 
                                               value="{{ $userResponse->response_data['remarks'] ?? '' }}" 
                                               disabled
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                                               placeholder="Auto format field">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    <span class="font-semibold">ℹ️ Note:</span> Form editing functionality will be enabled in the next update. Currently displayed fields are auto-generated format templates.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📊</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Data Available</h3>
                <p class="text-gray-600">Admin has not uploaded any scalling data yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
