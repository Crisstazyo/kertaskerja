@extends('layouts.app')

@section('title', ($lopType == 'koreksi' ? ucfirst($lopTypeDisplay) : 'LOP ' . ucfirst($lopTypeDisplay)) . ' - ' . ucfirst($roleNormalized))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.scalling', $role) }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">
                        ← Back to Scalling Categories
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ $lopType == 'koreksi' ? ucfirst($lopTypeDisplay) : 'LOP ' . ucfirst($lopTypeDisplay) }} - {{ ucfirst($roleNormalized) }}
                    </h1>
                    <p class="text-gray-600">
                        Upload, manage, dan lihat progress untuk {{ $lopType == 'koreksi' ? ucfirst($lopTypeDisplay) : 'LOP ' . ucfirst($lopTypeDisplay) }}
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

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md">
            <span class="font-semibold">{{ session('error') }}</span>
        </div>
        @endif

        <!-- Action Buttons Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Lihat Progress -->
            <a href="{{ route('admin.scalling.lop.progress', [$role, $lopType]) }}" 
               class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl shadow-md hover:shadow-xl transition-all p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Lihat Progress</h3>
                            <p class="text-sm text-blue-100">Progress yang diupdate user saat ini</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Lihat Riwayat -->
            <a href="{{ route('admin.scalling.lop.history', [$role, $lopType]) }}" 
               class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-xl shadow-md hover:shadow-xl transition-all p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Lihat Riwayat</h3>
                            <p class="text-sm text-green-100">Historical progress data</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Upload File Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center space-x-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span>Upload File</span>
            </h2>

            <form action="{{ route('admin.scalling.lop.upload', [$role, $lopType]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- Periode Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Pilih Periode Upload</span>
                    </label>
                    <input type="month" name="periode" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 font-medium"
                           value="{{ date('Y-m') }}">
                    @error('periode')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Excel File (.xlsx, .xls, .csv)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="sr-only" onchange="displayFileName(this)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">Excel files up to 10MB</p>
                            <p id="file-name" class="text-sm font-medium text-blue-600 mt-2"></p>
                        </div>
                    </div>
                    @error('file')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <span>Upload File</span>
                </button>
            </form>

            <script>
            function displayFileName(input) {
                const fileName = input.files[0]?.name;
                if (fileName) {
                    document.getElementById('file-name').textContent = `Selected: ${fileName}`;
                }
            }
            </script>
        </div>

        <!-- Tabel Riwayat Upload -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Tabel Riwayat Upload</span>
                </div>
                <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">
                    {{ $uploadHistory->total() }} Total Uploads
                </span>
            </h2>

            @if($uploadHistory->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rows</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($uploadHistory as $data)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $data->periode ? \Carbon\Carbon::parse($data->periode)->format('M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="font-medium">{{ $data->file_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <div class="bg-green-100 p-1.5 rounded-full">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $data->uploaded_by }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $data->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ is_array($data->data) ? count($data->data) - 1 : 0 }} rows
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <button onclick="toggleFilePreview({{ $data->id }})" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors inline-flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Lihat File</span>
                                </button>
                            </td>
                        </tr>
                        <!-- Hidden preview row -->
                        <tr id="preview-{{ $data->id }}" class="hidden bg-gray-50">
                            <td colspan="6" class="px-6 py-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-900 mb-3">File Preview</h4>
                                    @if(is_array($data->data) && count($data->data) > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    @if($lopType == 'koreksi')
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Pelanggan</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                    @else
                                                        @if(isset($data->data[0]) && is_array($data->data[0]))
                                                            @foreach($data->data[0] as $index => $header)
                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                                {{ $header ?? "Column " . ($index + 1) }}
                                                            </th>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach(array_slice($data->data, 1, 5) as $row)
                                                <tr class="hover:bg-gray-50">
                                                    @if($lopType == 'koreksi' && is_array($row))
                                                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900">
                                                            {{ $row[0] ?? '-' }}
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-900">
                                                            {{ isset($row[1]) ? 'Rp ' . number_format($row[1], 0, ',', '.') : '-' }}
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-xs">
                                                            @if(isset($row[2]))
                                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                                    {{ strtolower($row[2]) == 'aktif' ? 'bg-green-100 text-green-800' : 
                                                                       (strtolower($row[2]) == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                                       'bg-gray-100 text-gray-800') }}">
                                                                    {{ $row[2] }}
                                                                </span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    @elseif(is_array($row))
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
                                    </div>
                                    @if(count($data->data) > 6)
                                    <p class="text-xs text-gray-500 mt-3 text-center">Showing first 5 rows of {{ count($data->data) - 1 }} total rows</p>
                                    @endif
                                    @else
                                    <p class="text-gray-600 text-center py-4">No data available</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($uploadHistory->hasPages())
            <div class="mt-6">
                {{ $uploadHistory->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">Belum Ada Upload</h3>
                <p class="mt-2 text-gray-600">Upload file Excel untuk memulai</p>
            </div>
            @endif
        </div>

    </div>
</div>

<script>
function toggleFilePreview(id) {
    const previewRow = document.getElementById(`preview-${id}`);
    previewRow.classList.toggle('hidden');
}
</script>
@endsection
