@extends('layouts.app')

@section('title', 'SCALLING - ' . ucfirst($role))

@section('content')
<style>
    /* Funnel Table Styles */
    .funnel-table-wrapper {
      overflow-x: auto;
      background: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      margin-bottom: 30px;
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

    /* F4 - Qualified (green medium) */
    .bg-f4      { background: #92D050; color: #000; font-weight: bold; }
    .bg-f4-sub  { background: #A9D18E; color: #000; font-weight: bold; }

    /* F5 - On Hand (green dark) */
    .bg-f5      { background: #92D050; color: #000; font-weight: bold; }
    .bg-f5-sub  { background: #A9D18E; color: #000; font-weight: bold; }
    .bg-f5-col  { background: #E2EFDA; color: #000; }

    /* DELIVERY (red) */
    .bg-delivery     { background: #C00000; color: #fff; font-weight: bold; }
    .bg-delivery-sub { background: #E7999B; color: #000; font-weight: bold; }
    .bg-delivery-col { background: #FFEBEE; color: #000; }

    /* BILLING (brown) */
    .bg-billing     { background: #843C0C; color: #fff; font-weight: bold; }
    .bg-billing-col { background: #F4CCCC; color: #000; }

    /* KET */
    .bg-ket      { background: #2E75B6; color: #fff; font-weight: bold; }
    .bg-ket-col  { background: #DDEBF7; color: #000; }

    /* Column Widths */
    .w-no      { min-width: 30px;  }
    .w-project { min-width: 155px; }
    .w-idlop   { min-width: 65px;  }
    .w-cc      { min-width: 65px;  }
    .w-nipnas  { min-width: 65px;  }
    .w-am      { min-width: 65px;  }
    .w-mitra   { min-width: 65px;  }
    .w-phn     { min-width: 65px;  }
    .w-estnilai{ min-width: 85px;  }
    .w-normal  { min-width: 70px;  }
    .w-wide    { min-width: 95px;  }
    .w-xwide   { min-width: 115px; }
    
    .lop-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin: 30px 0 20px 0;
    }
    
    .worksheet-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin-top: 15px;
    }
</style>

<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">SCALLING - {{ ucfirst($role) }}</h1>
                    <p class="text-gray-600">Kertas Kerja Scalling per LOP Category</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        ← Kembali ke Menu
                    </a>
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
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Worksheets Grouped by LOP Category -->
        @php
            $lopOrder = ['on_hand', 'qualified', 'initiate', 'koreksi'];
            $lopNames = [
                'on_hand' => 'LOP On Hand',
                'qualified' => 'LOP Qualified',
                'initiate' => 'LOP Initiate',
                'koreksi' => 'LOP Koreksi'
            ];
        @endphp

        @forelse($lopOrder as $lopCategory)
            @if(isset($worksheetsByLop[$lopCategory]) && $worksheetsByLop[$lopCategory]->count() > 0)
                <!-- LOP Category Header -->
                <div class="lop-header">
                    <h2 class="text-3xl font-bold">{{ $lopNames[$lopCategory] }}</h2>
                    <p class="text-sm opacity-90 mt-1">{{ $worksheetsByLop[$lopCategory]->count() }} worksheet(s)</p>
                </div>

                <!-- Worksheets in this LOP Category -->
                @foreach($worksheetsByLop[$lopCategory] as $worksheet)
                    <div class="bg-white rounded-lg shadow-md mb-8">
                        <div class="worksheet-header flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-bold">{{ $worksheet->full_name }}</h3>
                                <p class="text-sm opacity-90">{{ ucfirst($worksheet->role) }} - {{ $worksheet->projects->count() }} rows</p>
                            </div>
                            @if(auth()->user()->role !== 'admin')
                            <button onclick="toggleAddRowModal({{ $worksheet->id }})" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-300">
                                + Tambah Baris Baru
                            </button>
                            @endif
                        </div>

                        <div class="p-6">
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

                                        <!-- ROW 2: Sub-stage labels -->
                                        <tr>
                                            <th class="bg-f0-sub w-normal">Data Kandidat Prospect</th>
                                            <th class="bg-f1-sub w-normal">Analisa Evaluasi Kandidat</th>

                                            <th class="bg-f2-sub w-normal">P0/P1 Jukbok Barang/Jasa</th>
                                            <th class="bg-f2-sub w-normal">P2 Evaluasi Bakal Calon</th>
                                            <th class="bg-f2-sub w-normal">P3 Permintaan Penawaran Harga</th>
                                            <th class="bg-f2-sub w-normal">P4 Rapat Penjelasan</th>
                                            <th class="bg-f2-sub w-normal">Offering Harga Mitra</th>
                                            <th class="bg-f2-sub w-normal">P5 Evaluasi SPH Mitra</th>

                                            <th class="bg-f3-sub w-normal">P6 Klarifikasi Negosiasi</th>
                                            <th class="bg-f3-sub w-normal">P7 SKKM, Justifikasi, SIPP</th>
                                            <th class="bg-f3-sub w-normal">P8 Memorandum Pengadaan</th>

                                            <th class="bg-f4-sub w-normal">P9 Penetapan Pemenang</th>

                                            <th class="bg-f5-sub w-normal">P10 Perintah Proses Pekerjaan</th>
                                            <th class="bg-f5-sub w-normal">P11 PO/SPK</th>
                                            <th class="bg-f5-sub w-normal">Kontrak Layanan</th>

                                            <th class="bg-delivery-sub w-wide">Kontrak Layanan</th>
                                            <th class="bg-delivery-sub w-normal">Baut & Bast</th>
                                            <th class="bg-delivery-sub w-normal">Baso</th>
                                        </tr>

                                        <!-- ROW 3: Detailed column headers -->
                                        <tr>
                                            <th class="bg-f0-sub w-normal">NPWP<br>NIB Segmen<br>Regulasi</th>
                                            <th class="bg-f1-sub w-normal">Hasil Analisa<br>Visit<br>Sales Plan<br>Tanggal</th>

                                            <th class="bg-f2-sub w-normal">Tanggal</th>
                                            <th class="bg-f2-sub w-normal">Tanggal</th>
                                            <th class="bg-f2-sub w-normal">Tanggal</th>
                                            <th class="bg-f2-sub w-normal">Tanggal</th>
                                            <th class="bg-f2-sub w-normal">Tanggal<br>No. Surat</th>
                                            <th class="bg-f2-sub w-normal">Tanggal</th>

                                            <th class="bg-f3-sub w-normal">Tanggal</th>
                                            <th class="bg-f3-sub w-normal">Tanggal</th>
                                            <th class="bg-f3-sub w-normal">Tanggal</th>

                                            <th class="bg-f4-sub w-normal">Tanggal</th>

                                            <th class="bg-f5-sub w-normal">Tanggal<br>No. Penugasan</th>
                                            <th class="bg-f5-sub w-normal">Tanggal<br>No. PO/SPK</th>
                                            <th class="bg-f5-sub w-wide">Tanggal<br>No. Kontrak<br>Nilai<br>Durasi Kontrak</th>

                                            <th class="bg-delivery-sub w-wide">Tanggal<br>No. Kontrak<br>Nilai<br>Durasi Kontrak</th>
                                            <th class="bg-delivery-sub w-normal">Tanggal<br>No. BAUT<br>No. BAST</th>
                                            <th class="bg-delivery-sub w-normal">Tanggal<br>No. BASO</th>
                                        </tr>

                                        <!-- ROW 4: Final Detail Fields -->
                                        <tr>
                                            <th class="bg-f0-sub">Status</th>
                                            <th class="bg-f1-sub">Status</th>

                                            <th class="bg-f2-sub">Status</th>
                                            <th class="bg-f2-sub">Status</th>
                                            <th class="bg-f2-sub">Status</th>
                                            <th class="bg-f2-sub">Status</th>
                                            <th class="bg-f2-sub">Status</th>
                                            <th class="bg-f2-sub">Status</th>

                                            <th class="bg-f3-sub">Status</th>
                                            <th class="bg-f3-sub">Status</th>
                                            <th class="bg-f3-sub">Status</th>

                                            <th class="bg-f4-sub">Status</th>

                                            <th class="bg-f5-sub">Status</th>
                                            <th class="bg-f5-sub">Status</th>
                                            <th class="bg-f5-sub">Status</th>

                                            <th class="bg-delivery-sub">Status</th>
                                            <th class="bg-delivery-sub">Status</th>
                                            <th class="bg-delivery-sub">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($worksheet->projects as $index => $project)
                                        <tr class="{{ $project->is_user_added ? 'bg-yellow-100' : 'hover:bg-gray-50' }}">
                                            <td>{{ $project->is_user_added ? '★' : '' }} {{ $index + 1 }}</td>
                                            <td class="text-left">{{ $project->project_name }}</td>
                                            <td>{{ $project->id_lop }}</td>
                                            <td>{{ $project->cc }}</td>
                                            <td>{{ $project->nipnas }}</td>
                                            <td>{{ $project->am }}</td>
                                            <td>{{ $project->mitra }}</td>
                                            <td>{{ $project->phn_bulan }}</td>
                                            <td>{{ $project->est_nilai_bc }}</td>
                                            
                                            <!-- F0 -->
                                            <td class="bg-f0-col">{{ $project->f0 }}</td>
                                            
                                            <!-- F1 -->
                                            <td class="bg-f1-col">{{ $project->f1 }}</td>
                                            
                                            <!-- F2 -->
                                            <td class="bg-f2-col">{{ $project->f2_p0_p1_jukbok }}</td>
                                            <td class="bg-f2-col">{{ $project->p2_evaluasi_bakal_calon }}</td>
                                            <td class="bg-f2-col">{{ $project->f2_p3_permintaan_penawaran }}</td>
                                            <td class="bg-f2-col">{{ $project->f2_p4_rapat_penjelasan }}</td>
                                            <td class="bg-f2-col">{{ $project->offering_harga_final }}</td>
                                            <td class="bg-f2-col">{{ $project->f2_p5_evaluasi_sph }}</td>
                                            
                                            <!-- F3 -->
                                            <td class="bg-f3-col">{{ $project->f3_p6_klarifikasi }}</td>
                                            <td class="bg-f3-col">{{ $project->f3_p7_skkm }}</td>
                                            <td class="bg-f3-col">{{ $project->f3_p8_memorandum }}</td>
                                            
                                            <!-- F4 -->
                                            <td class="bg-f4-col">{{ $project->f4_p9_penetapan }}</td>
                                            
                                            <!-- F5 -->
                                            <td class="bg-f5-col">{{ $project->f5_p10_perintah }}</td>
                                            <td class="bg-f5-col">{{ $project->f5_p11_po_spk }}</td>
                                            <td class="bg-f5-col">{{ $project->kontrak_layanan }}</td>
                                            
                                            <!-- DELIVERY -->
                                            <td class="bg-delivery-col">{{ $project->kontrak_layanan }}</td>
                                            <td class="bg-delivery-col">{{ $project->baut_bast }}</td>
                                            <td class="bg-delivery-col">{{ $project->baso }}</td>
                                            
                                            <!-- BILLING -->
                                            <td class="bg-billing-col">{{ $project->invoice }}<br>{{ $project->ar }}</td>
                                            
                                            <!-- KET -->
                                            <td class="bg-ket-col text-left">{{ $project->keterangan }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="30" class="py-8 text-gray-500">Belum ada data project dalam worksheet ini</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @empty
        <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-500">
            <p class="text-xl">Belum ada worksheet SCALLING</p>
            <p class="mt-2">Worksheet akan dibuat oleh Admin</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Row Modal -->
@if(auth()->user()->role !== 'admin')
<div id="addRowModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-4xl max-h-screen overflow-y-auto">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Baris Baru (F1-F2 Only)</h2>
            
            <form action="{{ route('project.store') }}" method="POST">
                @csrf
                <input type="hidden" name="worksheet_id" id="modal_worksheet_id">
                <input type="hidden" name="is_user_added" value="1">
                
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
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
                </div>

                <!-- F1 - Analisa Evaluasi Kandidat -->
                <h3 class="text-lg font-semibold mb-3 text-blue-700">F1 - Analisa Evaluasi Kandidat (Initiate)</h3>
                <div class="grid grid-cols-1 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Analisa / Visit / Sales Plan / Tanggal</label>
                        <textarea name="f1" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <!-- F2 - Self Assessment -->
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">P5 Evaluasi SPH Mitra</label>
                        <input type="text" name="f2_p5_evaluasi_sph" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleAddRowModal()" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
function toggleAddRowModal(worksheetId = null) {
    const modal = document.getElementById('addRowModal');
    modal.classList.toggle('hidden');
    
    if (worksheetId) {
        document.getElementById('modal_worksheet_id').value = worksheetId;
    }
}
</script>
@endsection
