@extends('layouts.app')

@section('title', 'Admin - LOP On Hand Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-teal-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">← Back to Dashboard</a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">LOP On Hand Management</h1>
                    <p class="text-gray-600">Upload & Manage LOP On Hand Data</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.lop-on-hand.history') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-md font-medium transition-colors">
                        View History
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md font-medium transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-green-500 via-teal-500 to-blue-500 rounded-full"></div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Upload Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                Upload Excel File
            </h2>
            <form action="{{ route('admin.lop-on-hand.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Excel File (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 p-2.5">
                    @error('file')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <p class="text-sm text-blue-800">
                        <span class="font-semibold">Format Excel:</span> NO | PROJECT | ID LOP | CC | NIPNAS | AM | Mitra | Plan Bulan Billcom p 2025 | Est Nilai BC
                    </p>
                </div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                    Upload File
                </button>
            </form>
        </div>

        <!-- Latest Data Display -->
        @if($latestImport)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-green-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $latestImport->file_name }}</h3>
                        <p class="text-sm text-green-100 mt-1">Uploaded by {{ $latestImport->uploaded_by }} on {{ $latestImport->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 px-6 py-3 rounded-md">
                        <p class="text-sm font-medium">Total Rows</p>
                        <p class="text-2xl font-semibold">{{ $latestImport->total_rows }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
                        <thead class="bg-gradient-to-r from-green-50 to-teal-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NO</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">PROJECT</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-green-100">ID LOP</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">CC</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">NIPNAS</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">AM</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300 bg-green-100">Mitra</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-r border-gray-300">Plan Bulan Billcom p 2025</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Est Nilai BC</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestImport->data as $row)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">{{ $row->no }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700 border-r border-gray-200">{{ $row->project }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200 bg-green-50">{{ $row->id_lop }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">{{ $row->cc }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200">{{ $row->nipnas }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700 border-r border-gray-200">{{ $row->am }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700 border-r border-gray-200 bg-green-50">{{ $row->mitra }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200 text-center">{{ $row->plan_bulan_billcom_p_2025 }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    @php
                                        $estVal = $row->est_nilai_bc ?? '0';
                                        $cleanVal = preg_replace('/[^0-9]/', '', $estVal);
                                        $numVal = floatval($cleanVal);
                                    @endphp
                                    {{ $numVal > 0 ? 'Rp ' . number_format($numVal, 0, ',', '.') : 'Rp 0' }}
                                </td>
                            </tr>
                            @endforeach
                            <!-- Total Row -->
                            @if($latestImport->data->isNotEmpty())
                            <tr class="bg-gray-900 text-white font-bold">
                                <td colspan="8" class="px-6 py-4 text-right uppercase tracking-wide">TOTAL</td>
                                <td class="px-6 py-4 whitespace-nowrap text-lg">
                                    {{ $latestImport->data->last()->est_nilai_bc }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Data Yet</h3>
            <p class="text-gray-600">Upload an Excel file to get started</p>
        </div>
        @endif
    </div>
</div>
@endsection
