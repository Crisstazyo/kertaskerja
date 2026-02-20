@extends('layouts.app')

@section('title', 'Lihat Data - ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('admin.lop-manage', [$role, $type, $lopCategory]) }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Kembali
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">
                        📋 Data Worksheet Aktif
                    </h1>
                    <p class="text-gray-600 mt-2">
                        {{ ucfirst($role) }} - {{ $type === 'scalling' ? 'Scalling' : 'PSAK' }}
                        @if($lopCategory !== 'none')
                            - {{ str_replace('_', ' ', ucwords($lopCategory)) }}
                        @endif
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Worksheets -->
        @forelse($worksheets as $worksheet)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="bg-gradient-to-r 
                {{ $role === 'government' ? 'from-green-500 to-green-600' : '' }}
                {{ $role === 'private' ? 'from-yellow-500 to-yellow-600' : '' }}
                {{ $role === 'soe' ? 'from-purple-500 to-purple-600' : '' }} 
                text-white px-6 py-4 rounded-t-lg -mx-6 -mt-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $worksheet->full_name }}</h2>
                        <div class="text-sm opacity-90">{{ $worksheet->projects->count() }} projects</div>
                    </div>
                    <button onclick="showAddRowModal({{ $worksheet->id }})" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-300">
                        <span class="text-lg">+ </span> Tambah Baris
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left">No</th>
                            <th class="px-3 py-2 text-left">Project Name</th>
                            <th class="px-3 py-2 text-left">CC</th>
                            <th class="px-3 py-2 text-left">AM</th>
                            <th class="px-3 py-2 text-left">Mitra</th>
                            <th class="px-3 py-2 text-center">F1</th>
                            <th class="px-3 py-2 text-center">F2</th>
                            <th class="px-3 py-2 text-left">Delivery</th>
                            <th class="px-3 py-2 text-left">Last Update</th>
                            <th class="px-3 py-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($worksheet->projects as $index => $project)
                        <tr class="border-b hover:bg-gray-50 {{ $project->is_user_added ? 'bg-yellow-50' : '' }}">
                            <td class="px-3 py-2">{{ $project->is_user_added ? '★' : '' }} {{ $index + 1 }}</td>
                            <td class="px-3 py-2 font-medium">{{ $project->project_name ?: '(Empty)' }}</td>
                            <td class="px-3 py-2">{{ $project->cc }}</td>
                            <td class="px-3 py-2">{{ $project->am }}</td>
                            <td class="px-3 py-2">{{ $project->mitra }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f1 ? '✓' : '-' }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f2_p0_p1_jukbok }}</td>
                            <td class="px-3 py-2">{{ $project->kontrak_layanan }}</td>
                            <td class="px-3 py-2 text-xs text-gray-600">{{ $project->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="px-3 py-2">
                                <button onclick="editProject({{ $project->id }}, {{ json_encode($project) }})" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs mr-1">
                                    Edit
                                </button>
                                <form action="{{ route('project.destroy', $project->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus project ini?')" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-3 py-8 text-center text-gray-500">
                                Belum ada project dalam worksheet ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-500">
            <p class="text-xl">Belum ada worksheet</p>
            <p class="mt-2">Buat worksheet baru untuk melihat data</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Edit Project Modal -->
<div id="editProjectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-6xl max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold">Edit Project Data</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="editProjectForm" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Basic Info -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Informasi Dasar</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
                            <input type="text" name="project_name" id="edit_project_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID LOP</label>
                            <input type="text" name="id_lop" id="edit_id_lop" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CC</label>
                            <input type="text" name="cc" id="edit_cc" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIPNAS</label>
                            <input type="text" name="nipnas" id="edit_nipnas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">AM</label>
                            <input type="text" name="am" id="edit_am" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mitra</label>
                            <input type="text" name="mitra" id="edit_mitra" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PHN Bulan</label>
                            <input type="text" name="phn_bulan" id="edit_phn_bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Est Nilai BC</label>
                            <input type="text" name="est_nilai_bc" id="edit_est_nilai_bc" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Funnel Stages -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Funnel Stages</h4>
                    
                    <!-- F0-F1 Checkboxes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="f0" id="edit_f0" value="1" class="w-5 h-5 text-blue-600">
                                <span class="ml-2 text-sm font-medium text-gray-700">F0 - Inisiasi Solusi</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="f1" id="edit_f1" value="1" class="w-5 h-5 text-blue-600">
                                <span class="ml-2 text-sm font-medium text-gray-700">F1 - Technical Budget</span>
                            </label>
                        </div>
                    </div>

                    <!-- F2 Details -->
                    <h5 class="font-semibold text-sm text-gray-600 mb-2">F2 - Self Assessment</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">P0/P1 Jukbok</label>
                            <input type="text" name="f2_p0_p1_jukbok" id="edit_f2_p0_p1_jukbok" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">P2 Evaluasi Bakal Calon</label>
                            <input type="text" name="p2_evaluasi_bakal_calon" id="edit_p2_evaluasi_bakal_calon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">P3 Permintaan Penawaran</label>
                            <input type="text" name="f2_p3_permintaan_penawaran" id="edit_f2_p3_permintaan_penawaran" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">P4 Rapat Penjelasan</label>
                            <input type="text" name="f2_p4_rapat_penjelasan" id="edit_f2_p4_rapat_penjelasan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Offering Harga Final</label>
                            <input type="text" name="offering_harga_final" id="edit_offering_harga_final" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="f2_p5_evaluasi_sph" id="edit_f2_p5_evaluasi_sph" value="1" class="w-5 h-5 text-blue-600">
                                <span class="ml-2 text-sm font-medium text-gray-700">P5 Evaluasi SPH</span>
                            </label>
                        </div>
                    </div>

                    <!-- F3 Details -->
                    <h5 class="font-semibold text-sm text-gray-600 mb-2">F3 - Qualified</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">P6 Klarifikasi</label>
                            <input type="text" name="f3_p6_klarifikasi_negosiasi" id="edit_f3_p6_klarifikasi_negosiasi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">P7 Penetapan Mitra</label>
                            <input type="text" name="f3_p7_penetapan_mitra" id="edit_f3_p7_penetapan_mitra" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Submit Proposal</label>
                            <input type="text" name="f3_submit_proposal" id="edit_f3_submit_proposal" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- F4-F5 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="negosiasi" id="edit_negosiasi" value="1" class="w-5 h-5 text-blue-600">
                                <span class="ml-2 text-sm font-medium text-gray-700">F4 - Negosiasi</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">F5 - Surat Kesanggupan</label>
                            <input type="text" name="surat" id="edit_surat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">F5 - Tanda Tangan</label>
                            <input type="text" name="tanda" id="edit_tanda" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="f5_p8_surat_penetapan" id="edit_f5_p8_surat_penetapan" value="1" class="w-5 h-5 text-blue-600">
                                <span class="ml-2 text-sm font-medium text-gray-700">F5 P8 - Surat Penetapan</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Delivery & Billing -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Delivery & Billing</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kontrak Layanan</label>
                            <input type="text" name="kontrak_layanan" id="edit_kontrak_layanan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">BAUT & BAST</label>
                            <input type="text" name="baut_bast" id="edit_baut_bast" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">BASO</label>
                            <input type="text" name="baso" id="edit_baso" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Invoice</label>
                            <input type="text" name="invoice" id="edit_invoice" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">AR</label>
                            <input type="text" name="ar" id="edit_ar" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                            <textarea name="keterangan" id="edit_keterangan" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 border-t pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300 font-semibold">
                        💾 Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg transition duration-300 font-semibold">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editProject(projectId, projectData) {
    const modal = document.getElementById('editProjectModal');
    const form = document.getElementById('editProjectForm');
    
    // Set form action
    form.action = `/admin/project/${projectId}`;
    
    // Populate form fields
    document.getElementById('edit_project_name').value = projectData.project_name || '';
    document.getElementById('edit_id_lop').value = projectData.id_lop || '';
    document.getElementById('edit_cc').value = projectData.cc || '';
    document.getElementById('edit_nipnas').value = projectData.nipnas || '';
    document.getElementById('edit_am').value = projectData.am || '';
    document.getElementById('edit_mitra').value = projectData.mitra || '';
    document.getElementById('edit_phn_bulan').value = projectData.phn_bulan || '';
    document.getElementById('edit_est_nilai_bc').value = projectData.est_nilai_bc || '';
    
    // Funnel stages - Checkboxes
    document.getElementById('edit_f0').checked = projectData.f0_inisiasi_solusi ? true : false;
    document.getElementById('edit_f1').checked = projectData.f1_technical_budget ? true : false;
    document.getElementById('edit_f2_p5_evaluasi_sph').checked = projectData.f2_p5_evaluasi_sph ? true : false;
    document.getElementById('edit_negosiasi').checked = projectData.negosiasi ? true : false;
    document.getElementById('edit_f5_p8_surat_penetapan').checked = projectData.f5_p8_surat_penetapan ? true : false;
    
    // Funnel stages - Text fields
    document.getElementById('edit_f2_p0_p1_jukbok').value = projectData.f2_p0_p1_jukbok || '';
    document.getElementById('edit_p2_evaluasi_bakal_calon').value = projectData.p2_evaluasi_bakal_calon || '';
    document.getElementById('edit_f2_p3_permintaan_penawaran').value = projectData.f2_p3_permintaan_penawaran || '';
    document.getElementById('edit_f2_p4_rapat_penjelasan').value = projectData.f2_p4_rapat_penjelasan || '';
    document.getElementById('edit_offering_harga_final').value = projectData.offering_harga_final || '';
    document.getElementById('edit_f3_p6_klarifikasi_negosiasi').value = projectData.f3_p6_klarifikasi_negosiasi || '';
    document.getElementById('edit_f3_p7_penetapan_mitra').value = projectData.f3_p7_penetapan_mitra || '';
    document.getElementById('edit_f3_submit_proposal').value = projectData.f3_submit_proposal || '';
    document.getElementById('edit_surat').value = projectData.surat || '';
    document.getElementById('edit_tanda').value = projectData.tanda || '';
    
    // Delivery & Billing
    document.getElementById('edit_kontrak_layanan').value = projectData.kontrak_layanan || '';
    document.getElementById('edit_baut_bast').value = projectData.baut_bast || '';
    document.getElementById('edit_baso').value = projectData.baso || '';
    document.getElementById('edit_invoice').value = projectData.invoice || '';
    document.getElementById('edit_ar').value = projectData.ar || '';
    document.getElementById('edit_keterangan').value = projectData.keterangan || '';
    
    // Show modal
    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editProjectModal').classList.add('hidden');
}

function showAddRowModal(worksheetId) {
    document.getElementById('addRowWorksheetId').value = worksheetId;
    document.getElementById('addRowModal').classList.remove('hidden');
}

function closeAddRowModal() {
    document.getElementById('addRowModal').classList.add('hidden');
}
</script>

<!-- Add Row Modal -->
<div id="addRowModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-4xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold">Tambah Baris Project</h3>
                <button onclick="closeAddRowModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('admin.add-project') }}" method="POST">
                @csrf
                <input type="hidden" name="worksheet_id" id="addRowWorksheetId">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Project Name *</label>
                        <input type="text" name="project_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID LOP</label>
                        <input type="text" name="id_lop" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">CC</label>
                        <input type="text" name="cc" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIPNAS</label>
                        <input type="text" name="nipnas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">AM</label>
                        <input type="text" name="am" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mitra</label>
                        <input type="text" name="mitra" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">PHN Bulan</label>
                        <input type="text" name="phn_bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Est Nilai BC</label>
                        <input type="text" name="est_nilai_bc" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition duration-300 font-semibold">
                        💾 Simpan Baris
                    </button>
                    <button type="button" onclick="closeAddRowModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg transition duration-300 font-semibold">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
