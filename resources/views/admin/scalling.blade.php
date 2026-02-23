@extends('layouts.app')

@section('title', 'Admin - Scalling Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">← Back to Dashboard</a>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📊 Scalling Management</h1>
                    <p class="text-gray-600 text-lg">Government Data - Upload & View</p>
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

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Upload Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-2 border-blue-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="text-3xl mr-3">📤</span>
                Upload Excel File
            </h2>
            <form action="{{ route('admin.scalling.upload', $role) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Excel File (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    @error('file')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    Upload File
                </button>
            </form>
        </div>

        <!-- Uploaded Data Display -->
        <div class="space-y-6">
            @forelse($scallingData as $data)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-gray-100">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">📄 {{ $data->file_name }}</h3>
                            <p class="text-sm text-green-100 mt-1">Uploaded by {{ $data->uploaded_by }} on {{ $data->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="bg-white bg-opacity-20 px-4 py-2 rounded-lg font-semibold">
                            {{ count($data->data) }} rows
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @if(isset($data->data[0]))
                                        @foreach($data->data[0] as $index => $header)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ $header ?? "Column " . ($index + 1) }}
                                        </th>
                                        @endforeach
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Gov Status
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(array_slice($data->data, 1) as $rowIndex => $row)
                                <tr class="hover:bg-gray-50">
                                    @foreach($row as $cell)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $cell }}
                                    </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $responseCount = $data->responses->where('row_index', $rowIndex)->count();
                                        @endphp
                                        @if($responseCount > 0)
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            ✓ {{ $responseCount }} Response(s)
                                        </span>
                                        @else
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">
                                            Pending
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📊</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Data Yet</h3>
                <p class="text-gray-600">Upload an Excel file to get started</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
