@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">🛠️ Admin Panel</h1>
                    <p class="text-gray-600">Kelola kertas kerja dan pengguna</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        Logout
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Recap Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <a href="{{ route('admin.recap', 'government') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-4 rounded-lg shadow-md transition duration-300 text-center">
                <div class="text-2xl font-bold">📊 Rekap Government</div>
                <div class="text-sm opacity-90">Lihat semua worksheet Government</div>
            </a>
            <a href="{{ route('admin.recap', 'private') }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-6 py-4 rounded-lg shadow-md transition duration-300 text-center">
                <div class="text-2xl font-bold">📊 Rekap Private</div>
                <div class="text-sm opacity-90">Lihat semua worksheet Private</div>
            </a>
            <a href="{{ route('admin.recap', 'soe') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-6 py-4 rounded-lg shadow-md transition duration-300 text-center">
                <div class="text-2xl font-bold">📊 Rekap SOE</div>
                <div class="text-sm opacity-90">Lihat semua worksheet SOE</div>
            </a>
        </div>

        <!-- Create Worksheet Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📅 Buat Kertas Kerja Bulanan Baru</h2>
            <p class="text-gray-600 mb-6">Pilih role, tipe, dan kategori LOP untuk membuat worksheet baru (8 rows per worksheet)</p>
            
            <form action="{{ route('admin.create-worksheet') }}" method="POST" id="createWorksheetForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                    <!-- Month -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                        <select name="month" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    
                    <!-- Year -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <input type="number" name="year" value="{{ date('Y') }}" min="2024" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role" id="roleSelect" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Role</option>
                            <option value="government">Government</option>
                            <option value="private">Private</option>
                            <option value="soe">SOE</option>
                        </select>
                    </div>
                    
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                        <select name="type" id="typeSelect" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Tipe</option>
                            <option value="scalling">Scalling</option>
                            <option value="psak">PSAK</option>
                        </select>
                    </div>
                    
                    <!-- LOP Category -->
                    <div id="lopCategoryDiv" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori LOP</label>
                        <select name="lop_category" id="lopCategorySelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih LOP</option>
                            <option value="on_hand">LOP On Hand</option>
                            <option value="qualified">LOP Qualified</option>
                            <option value="initiate" id="initiateOption">LOP Initiate</option>
                            <option value="koreksi">LOP Koreksi</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-3 rounded-lg transition duration-300 font-semibold text-lg">
                    ✨ Buat Worksheet Baru (8 Rows)
                </button>
            </form>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">Total Worksheets</div>
                <div class="text-3xl font-bold text-purple-600">{{ $worksheets->count() ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">Government Projects</div>
                <div class="text-3xl font-bold text-green-600">{{ $govProjects ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">Private Projects</div>
                <div class="text-3xl font-bold text-yellow-600">{{ $privateProjects ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">SOE Projects</div>
                <div class="text-3xl font-bold text-purple-600">{{ $soeProjects ?? 0 }}</div>
            </div>
        </div>

        <!-- Worksheets List -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📋 Semua Worksheets</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Worksheet</th>
                            <th class="px-4 py-2 text-left">Role</th>
                            <th class="px-4 py-2 text-left">Tipe</th>
                            <th class="px-4 py-2 text-left">LOP Category</th>
                            <th class="px-4 py-2 text-left">Jumlah Rows</th>
                            <th class="px-4 py-2 text-left">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($worksheets ?? [] as $index => $worksheet)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 font-medium">{{ $worksheet->full_name }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $worksheet->role === 'government' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $worksheet->role === 'private' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $worksheet->role === 'soe' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ ucfirst($worksheet->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $worksheet->type === 'scalling' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $worksheet->type_name }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($worksheet->lop_category)
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $worksheet->lop_category_name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $worksheet->projects->count() }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $worksheet->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                Belum ada worksheet. Buat worksheet baru di form di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- All Projects List -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📋 Semua Projects</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Project Name</th>
                            <th class="px-4 py-2 text-left">Role</th>
                            <th class="px-4 py-2 text-left">CC</th>
                            <th class="px-4 py-2 text-left">AM</th>
                            <th class="px-4 py-2 text-left">Created</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allProjects ?? [] as $index => $project)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 font-medium">
                                <button onclick="editProjectName({{ $project->id }}, '{{ addslashes($project->project_name) }}')" 
                                        class="text-blue-600 hover:text-blue-800 hover:underline text-left">
                                    {{ $project->project_name ?: '(Empty)' }}
                                </button>
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $project->role === 'government' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $project->role === 'private' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $project->role === 'soe' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ ucfirst($project->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $project->cc }}</td>
                            <td class="px-4 py-2">{{ $project->am }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $project->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('project.destroy', $project->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus project ini?')" 
                                            class="text-red-600 hover:text-red-800 text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data project
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Project Name Modal -->
<div id="editProjectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <h3 class="text-xl font-bold mb-4">Edit Project Name</h3>
        <form id="editProjectForm" method="POST">
            @csrf
            @method('PUT')
            <input type="text" id="editProjectName" name="project_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 mb-4" placeholder="Project Name" required>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition duration-300">
                    Simpan
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Show/hide LOP category based on type selection
document.getElementById('typeSelect').addEventListener('change', function() {
    const lopDiv = document.getElementById('lopCategoryDiv');
    const lopSelect = document.getElementById('lopCategorySelect');
    
    if (this.value === 'scalling') {
        lopDiv.style.display = 'block';
        lopSelect.required = true;
    } else {
        lopDiv.style.display = 'none';
        lopSelect.required = false;
        lopSelect.value = '';
    }
});

// Hide/show LOP Initiate based on role
document.getElementById('roleSelect').addEventListener('change', function() {
    const initiateOption = document.getElementById('initiateOption');
    const lopSelect = document.getElementById('lopCategorySelect');
    
    if (this.value === 'government') {
        initiateOption.style.display = 'none';
        if (lopSelect.value === 'initiate') {
            lopSelect.value = '';
        }
    } else {
        initiateOption.style.display = 'block';
    }
});

// Edit project name
function editProjectName(projectId, currentName) {
    const modal = document.getElementById('editProjectModal');
    const form = document.getElementById('editProjectForm');
    const input = document.getElementById('editProjectName');
    
    form.action = `/admin/project/${projectId}`;
    input.value = currentName;
    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editProjectModal').classList.add('hidden');
}
</script>
@endsection
