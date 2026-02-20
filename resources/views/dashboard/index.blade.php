@extends('layouts.app')

@section('title', 'Dashboard ' . ucfirst($role))

@section('content')
<style>
    /* Funnel Table Styles */
    .funnel-table-wrapper {
      overflow-x: auto;
      background: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .funnel-table {
      border-collapse: collapse;
      min-width: max-content;
      font-size: 10px;
    }

    .funnel-table th, .funnel-table td {
      border: 1px solid #888;
      padding: 4px 6px;
      text-align: center;
      vertical-align: middle;
      line-height: 1.3;
    }

    /* HEADER COLOURS */
    .bg-gov     { background: #1F3864; color: #fff; font-weight: bold; font-size: 11px; text-align: left; }
    .bg-funnel  { background: #375623; color: #fff; font-weight: bold; font-size: 11px; }
    .bg-empty-r1{ background: #fff; border: none; }
    .bg-static  { background: #2E75B6; color: #fff; font-weight: bold; }

    /* F0 - Initiate (purple) */
    .bg-f0      { background: #7030A0; color: #fff; font-weight: bold; }
    .bg-f0-sub  { background: #C9A0DC; color: #fff; font-weight: bold; }

    /* F1 - Initiate (light blue) */
    .bg-f1      { background: #00B0F0; color: #fff; font-weight: bold; }
    .bg-f1-sub  { background: #9DC3E6; color: #000; font-weight: bold; }

    /* F2 - Initiate (yellow) */
    .bg-f2      { background: #FFC000; color: #000; font-weight: bold; }
    .bg-f2-sub  { background: #FFE699; color: #000; font-weight: bold; }
    .bg-f2-col  { background: #FFF2CC; color: #000; }

    /* F3 - Qualified (green light) */
    .bg-f3      { background: #92D050; color: #000; font-weight: bold; }
    .bg-f3-sub  { background: #A9D18E; color: #000; font-weight: bold; }
    .bg-f3-col  { background: #E2EFDA; color: #000; }

    /* F4 - Qualified (medium green) */
    .bg-f4      { background: #00B050; color: #fff; font-weight: bold; }
    .bg-f4-sub  { background: #70AD47; color: #fff; font-weight: bold; }
    .bg-f4-col  { background: #C6EFCE; color: #000; }

    /* F5 - On Hand (dark green) */
    .bg-f5      { background: #375623; color: #fff; font-weight: bold; }
    .bg-f5-sub  { background: #548235; color: #fff; font-weight: bold; }
    .bg-f5-col  { background: #A9D18E; color: #000; }

    /* DELIVERY */
    .bg-delivery    { background: #C00000; color: #fff; font-weight: bold; }
    .bg-del-col     { background: #FFCCCC; color: #000; }

    /* BILLING COMPLETE */
    .bg-billing { background: #833C00; color: #fff; font-weight: bold; }

    /* Ket */
    .bg-ket     { background: #404040; color: #fff; font-weight: bold; }

    /* DATA ROWS */
    .funnel-table tbody tr:nth-child(odd)  td { background: #FFFFFF; color: #222; }
    .funnel-table tbody tr:nth-child(even) td { background: #DDEEFF; color: #222; }

    /* FALSE cell style */
    .false-cell { color: #C00000; font-weight: bold; }
    .dash-cell  { color: #888; }

    /* Column widths */
    .w-no      { min-width: 32px;  }
    .w-project { min-width: 140px; text-align: left; }
    .w-idlop   { min-width: 75px;  }
    .w-cc      { min-width: 50px;  }
    .w-nipnas  { min-width: 75px;  }
    .w-am      { min-width: 55px;  }
    .w-mitra   { min-width: 80px;  }
    .w-phn     { min-width: 65px;  }
    .w-estnilai{ min-width: 85px;  }
    .w-normal  { min-width: 70px;  }
    .w-wide    { min-width: 95px;  }
    .w-xwide   { min-width: 115px; }

    /* Tab Styles */
    .tab-button {
        padding: 12px 24px;
        border: none;
        background: #e0e0e0;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        border-radius: 8px 8px 0 0;
        margin-right: 4px;
    }
    .tab-button.active {
        background: #2E75B6;
        color: white;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard {{ ucfirst($role) }}</h1>
                    <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="toggleAddModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <span class="text-lg">+ </span> Tambah Data
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Section -->
            <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Project</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama project..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300">
                        Filter
                    </button>
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white rounded-t-lg shadow-md px-6 pt-4">
            <div class="flex border-b-0">
                <button class="tab-button active" onclick="switchTab('scalling')">SCALLING</button>
                <button class="tab-button" onclick="switchTab('psak')">PSAK</button>
            </div>
        </div>

        <!-- Tab Content: SCALLING -->
        <div id="tab-scalling" class="tab-content active bg-white rounded-b-lg shadow-md p-6">
            <div class="funnel-table-wrapper">
                <table class="funnel-table">
                    <thead>
                        <!-- ROW 1: Stage labels -->
                        <tr>
                            <th class="bg-static w-no" rowspan="4">NO</th>
                            <th class="bg-static w-project" rowspan="4">PROJECT</th>
                            <th class="bg-static w-idlop" rowspan="4">ID LOP</th>
                            <th class="bg-static w-cc" rowspan="4">CC</th>
                            <th class="bg-static w-nipnas" rowspan="4">NIPNAS</th>
                            <th class="bg-static w-am" rowspan="4">AM</th>
                            <th class="bg-static w-mitra" rowspan="4">Mitra</th>
                            <th class="bg-static w-phn" rowspan="4">Phn Bulan<br>Billcomp<br>2025</th>
                            <th class="bg-static w-estnilai" rowspan="4">Est Nilai BC</th>

                            <th class="bg-f0" colspan="1">F0 (Initiate)</th>
                            <th class="bg-f1" colspan="1">F1 (Initiate)</th>
                            <th class="bg-f2" colspan="6">F2 (Initiate)</th>
                            <th class="bg-f3" colspan="3">F3 (Qualified)</th>
                            <th class="bg-f4" colspan="1">F4(Qualified)</th>
                            <th class="bg-f5" colspan="3">F5 (On Hand)</th>
                            <th class="bg-delivery" colspan="3">DELIVERY</th>
                            <th class="bg-billing" rowspan="4">BILLING<br>COMPLETE</th>
                            <th class="bg-ket" rowspan="4">Ket</th>
                        </tr>

                        <!-- ROW 2: Sub-group labels -->
                        <tr>
                            <th class="bg-f0-sub">Lead</th>
                            <th class="bg-f1-sub">Opportunity</th>
                            <th class="bg-f2-sub" colspan="6">Self Assessment &amp; Management Solution</th>
                            <th class="bg-f3-sub" colspan="3">Project Assessment (RPA)</th>
                            <th class="bg-f4-sub">Negosiasi</th>
                            <th class="bg-f5-sub" colspan="3">Win</th>
                            <th class="bg-del-col" colspan="3"></th>
                        </tr>

                        <!-- ROW 3: Column names -->
                        <tr>
                            <th class="bg-f0-sub w-wide">Inisiasi<br>Solusi</th>
                            <th class="bg-f1-sub w-wide">Technical &amp;<br>budget<br>discussion</th>
                            <th class="bg-f2-col w-wide">P0/P1. Jukbok<br>barang / jasa</th>
                            <th class="bg-f2-col w-wide">P2. Evaluasi<br>bakal calon<br>Mitra</th>
                            <th class="bg-f2-col w-wide">P3.<br>Permintaan<br>Penawaran<br>Harga</th>
                            <th class="bg-f2-col w-wide">P4. Rapat<br>Penjelasan</th>
                            <th class="bg-f2-col w-wide">Offering<br>Harga Mitra</th>
                            <th class="bg-f2-col w-wide">P5. Evaluasi<br>SPH Mitra</th>
                            <th class="bg-f3-col w-wide">P6. Klarifikasi<br>&amp; Negosiasi</th>
                            <th class="bg-f3-col w-wide">P7. Penetapan<br>Calon Mitra</th>
                            <th class="bg-f3-col w-xwide">Submit proposal<br>penawaran /<br>SPH ke<br>pelanggan</th>
                            <th class="bg-f4-col w-wide">Negosiasi</th>
                            <th class="bg-f5-col w-wide">Surat<br>Kesanggupan<br>Mitra</th>
                            <th class="bg-f5-col w-wide">Tanda<br>Tangan<br>Kontrak</th>
                            <th class="bg-f5-col w-wide">P8. Surat<br>Penetapan<br>Mitra</th>
                            <th class="bg-del-col w-xwide">Kontrak Layanan<br>(KL) dengan<br>Mitra</th>
                            <th class="bg-del-col w-wide">BAUT &amp;<br>BAST</th>
                            <th class="bg-del-col w-normal">BASO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $index => $project)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="w-project">{{ $project->project_name }}</td>
                                <td>{{ $project->id_lop }}</td>
                                <td>{{ $project->cc }}</td>
                                <td>{{ $project->nipnas }}</td>
                                <td>{{ $project->am }}</td>
                                <td>{{ $project->mitra }}</td>
                                <td>{{ $project->phn_bulan_billcomp }}</td>
                                <td>{{ $project->est_nilai_bc }}</td>
                                <!-- F0 -->
                                <td class="{{ $project->f0_inisiasi_solusi ? '' : 'dash-cell' }}">{{ $project->f0_inisiasi_solusi ? '✓' : '-' }}</td>
                                <!-- F1 -->
                                <td class="{{ $project->f1_technical_budget ? '' : 'dash-cell' }}">{{ $project->f1_technical_budget ? '✓' : '-' }}</td>
                                <!-- F2 -->
                                <td class="{{ $project->f2_p0_p1_jukbok ? '' : 'dash-cell' }}">{{ $project->f2_p0_p1_jukbok ?: '-' }}</td>
                                <td class="{{ $project->p2_evaluasi_bakal_calon ? '' : 'dash-cell' }}">{{ $project->p2_evaluasi_bakal_calon ?: '-' }}</td>
                                <td class="{{ $project->f2_p3_permintaan_penawaran ? '' : 'dash-cell' }}">{{ $project->f2_p3_permintaan_penawaran ?: '-' }}</td>
                                <td class="{{ $project->f2_p4_rapat_penjelasan ? '' : 'dash-cell' }}">{{ $project->f2_p4_rapat_penjelasan ?: '-' }}</td>
                                <td class="{{ $project->offering_harga_final ? '' : 'dash-cell' }}">{{ $project->offering_harga_final ?: '-' }}</td>
                                <td class="{{ $project->f2_p5_evaluasi_sph ? '' : 'dash-cell' }}">{{ $project->f2_p5_evaluasi_sph ? '✓' : '-' }}</td>
                                <!-- F3 -->
                                <td class="{{ $project->f3_p6_klarifikasi_negosiasi ? '' : 'dash-cell' }}">{{ $project->f3_p6_klarifikasi_negosiasi ?: '-' }}</td>
                                <td class="{{ $project->f3_p7_penetapan_mitra ? '' : 'dash-cell' }}">{{ $project->f3_p7_penetapan_mitra ?: '-' }}</td>
                                <td>{{ $project->f3_submit_proposal }}</td>
                                <!-- F4 -->
                                <td>{{ $project->negosiasi ? '✓' : '-' }}</td>
                                <!-- F5 -->
                                <td class="{{ strtoupper($project->surat) === 'FALSE' ? 'false-cell' : '' }}">{{ $project->surat }}</td>
                                <td class="{{ strtoupper($project->tanda) === 'FALSE' ? 'false-cell' : '' }}">{{ $project->tanda }}</td>
                                <td>{{ $project->f5_p8_surat_penetapan ? '✓' : '-' }}</td>
                                <!-- DELIVERY -->
                                <td class="{{ $project->del_kontrak_layanan ? '' : 'dash-cell' }}">{{ $project->del_kontrak_layanan ?: '-' }}</td>
                                <td class="{{ $project->baut ? '' : 'dash-cell' }}">{{ $project->baut ?: '-' }}</td>
                                <td class="{{ $project->del_baso ? '' : 'dash-cell' }}">{{ $project->del_baso ?: '-' }}</td>
                                <!-- BILLING -->
                                <td class="{{ strtoupper($project->billing_complete) === 'FALSE' ? 'false-cell' : '' }}">{{ $project->billing_complete }}</td>
                                <!-- Ket -->
                                <td>{{ $project->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="29" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada data. Klik "Tambah Data" untuk menambahkan data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content: PSAK -->
        <div id="tab-psak" class="tab-content bg-white rounded-b-lg shadow-md p-6">
            <div class="text-center py-12">
                <h3 class="text-2xl font-bold text-gray-600 mb-4">PSAK View</h3>
                <p class="text-gray-500">Tampilan PSAK sedang dalam pengembangan</p>
            </div>
        </div>
    </div>
</div>

<!-- Add Data Modal -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-lg p-8 max-w-6xl w-full mx-4 my-8 max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold mb-6">Tambah Data Project</h2>
        <form action="{{ route('project.store') }}" method="POST">
            @csrf
            
            <h3 class="text-lg font-semibold mb-3 text-blue-700">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Project *</label>
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phn Bulan Billcomp</label>
                    <input type="text" name="phn_bulan_billcomp" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Est Nilai BC</label>
                    <input type="text" name="est_nilai_bc" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-purple-700">F0 - Lead (Initiate)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="f0_inisiasi_solusi" value="1" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-sm font-medium text-gray-700">Inisiasi Solusi</span>
                    </label>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-cyan-700">F1 - Opportunity (Initiate)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="f1_technical_budget" value="1" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-sm font-medium text-gray-700">Technical & Budget Discussion</span>
                    </label>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-yellow-700">F2 - Self Assessment (Initiate)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">P0/P1 Jukbok Barang/Jasa</label>
                    <input type="text" name="f2_p0_p1_jukbok" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">P2 Evaluasi Bakal Calon</label>
                    <input type="text" name="p2_evaluasi_bakal_calon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">P3 Permintaan Penawaran Harga</label>
                    <input type="text" name="f2_p3_permintaan_penawaran" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">P4 Rapat Penjelasan</label>
                    <input type="text" name="f2_p4_rapat_penjelasan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Offering Harga Mitra</label>
                    <input type="text" name="offering_harga_final" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="f2_p5_evaluasi_sph" value="1" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-sm font-medium text-gray-700">P5 Evaluasi SPH Mitra</span>
                    </label>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-green-600">F3 - Project Assessment (Qualified)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">P6 Klarifikasi & Negosiasi</label>
                    <input type="text" name="f3_p6_klarifikasi_negosiasi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">P7 Penetapan Calon Mitra</label>
                    <input type="text" name="f3_p7_penetapan_mitra" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Submit Proposal ke Pelanggan</label>
                    <input type="text" name="f3_submit_proposal" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-green-700">F4 - Negosiasi (Qualified)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="negosiasi" value="1" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-sm font-medium text-gray-700">Negosiasi</span>
                    </label>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-green-800">F5 - Win (On Hand)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Surat Kesanggupan Mitra</label>
                    <input type="text" name="surat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanda Tangan Kontrak</label>
                    <input type="text" name="tanda" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="f5_p8_surat_penetapan" value="1" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-sm font-medium text-gray-700">P8 Surat Penetapan Mitra</span>
                    </label>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-red-700">DELIVERY</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kontrak Layanan (KL) dengan Mitra</label>
                    <input type="text" name="del_kontrak_layanan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">BAUT & BAST</label>
                    <input type="text" name="baut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">BASO</label>
                    <input type="text" name="del_baso" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-3 text-orange-900">BILLING & KETERANGAN</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Billing Complete</label>
                    <input type="text" name="billing_complete" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="toggleAddModal()" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition duration-300">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAddModal() {
    document.getElementById('addModal').classList.toggle('hidden');
}

function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById('tab-' + tabName).classList.add('active');
    event.target.classList.add('active');
}
</script>
@endsection
