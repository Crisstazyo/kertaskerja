@extends('layouts.app')

@section('title', 'Riwayat - ' . ucfirst($role))

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
    .bg-static  { background: #2E75B6; color: #fff; font-weight: bold; }
    .bg-f0      { background: #7030A0; color: #fff; font-weight: bold; }
    .bg-f0-sub  { background: #C9A0DC; color: #fff; font-weight: bold; }
    .bg-f1      { background: #00B0F0; color: #fff; font-weight: bold; }
    .bg-f1-sub  { background: #9DC3E6; color: #000; font-weight: bold; }
    .bg-f2      { background: #FFC000; color: #000; font-weight: bold; }
    .bg-f2-sub  { background: #FFE699; color: #000; font-weight: bold; }
    .bg-f2-col  { background: #FFF2CC; color: #000; }
    .bg-f3      { background: #92D050; color: #000; font-weight: bold; }
    .bg-f3-sub  { background: #A9D18E; color: #000; font-weight: bold; }
    .bg-f3-col  { background: #E2EFDA; color: #000; }
    .bg-f4      { background: #00B050; color: #fff; font-weight: bold; }
    .bg-f4-sub  { background: #70AD47; color: #fff; font-weight: bold; }
    .bg-f4-col  { background: #C6EFCE; color: #000; }
    .bg-f5      { background: #375623; color: #fff; font-weight: bold; }
    .bg-f5-sub  { background: #548235; color: #fff; font-weight: bold; }
    .bg-f5-col  { background: #A9D18E; color: #000; }
    .bg-delivery    { background: #C00000; color: #fff; font-weight: bold; }
    .bg-del-col     { background: #FFCCCC; color: #000; }
    .bg-billing { background: #833C00; color: #fff; font-weight: bold; }
    .bg-ket     { background: #404040; color: #fff; font-weight: bold; }

    /* DATA ROWS */
    .funnel-table tbody tr:nth-child(odd)  td { background: #FFFFFF; color: #222; }
    .funnel-table tbody tr:nth-child(even) td { background: #DDEEFF; color: #222; }

    .w-no      { min-width: 32px;  }
    .w-project { min-width: 140px; text-align: left; }
    .w-normal  { min-width: 70px;  }
    .w-wide    { min-width: 95px;  }
</style>

<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <a href="{{ route('admin.lop-manage', [$role, $type, $lopCategory]) }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                ← Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-800">
                📜 Riwayat Semua Worksheet
            </h1>
            <p class="text-gray-600 mt-2">
                {{ ucfirst($role) }} - {{ $type === 'scalling' ? 'Scalling' : 'PSAK' }}
                @if($lopCategory !== 'none')
                    - {{ str_replace('_', ' ', ucwords($lopCategory)) }}
                @endif
            </p>
        </div>

        <!-- Worksheets with Full Funnel Tables -->
        @forelse($worksheets as $worksheet)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="bg-gradient-to-r 
                {{ $role === 'government' ? 'from-green-500 to-green-600' : '' }}
                {{ $role === 'private' ? 'from-yellow-500 to-yellow-600' : '' }}
                {{ $role === 'soe' ? 'from-purple-500 to-purple-600' : '' }} 
                text-white px-6 py-4 rounded-t-lg -mx-6 -mt-6 mb-6">
                <h2 class="text-2xl font-bold">{{ $worksheet->full_name }}</h2>
                <div class="text-sm opacity-90 mt-1">
                    Dibuat: {{ $worksheet->created_at->format('d M Y H:i') }} | 
                    Projects: {{ $worksheet->projects->count() }} | 
                    User Added: {{ $worksheet->projects->where('is_user_added', true)->count() }}
                </div>
            </div>

            <div class="funnel-table-wrapper">
                <table class="funnel-table">
                    <thead>
                        <!-- ROW 1: Stage labels -->
                        <tr>
                            <th class="bg-static w-no" rowspan="3">NO</th>
                            <th class="bg-static w-project" rowspan="3">PROJECT</th>
                            <th class="bg-static w-normal" rowspan="3">ID LOP</th>
                            <th class="bg-static w-normal" rowspan="3">CC</th>
                            <th class="bg-static w-normal" rowspan="3">AM</th>
                            <th class="bg-static w-normal" rowspan="3">Mitra</th>
                            <th class="bg-static w-normal" rowspan="3">PHN Bulan</th>
                            <th class="bg-static w-normal" rowspan="3">Est Nilai BC</th>

                            <th class="bg-f0" colspan="1">F0</th>
                            <th class="bg-f1" colspan="1">F1</th>
                            <th class="bg-f2" colspan="6">F2</th>
                            <th class="bg-f3" colspan="3">F3</th>
                            <th class="bg-f4" colspan="1">F4</th>
                            <th class="bg-f5" colspan="3">F5</th>
                            <th class="bg-delivery" colspan="3">DELIVERY</th>
                            <th class="bg-billing" colspan="2">BILLING</th>
                            <th class="bg-static" rowspan="3">Last Update</th>
                            <th class="bg-ket" rowspan="3">Ket</th>
                        </tr>

                        <!-- ROW 2: Sub-group labels -->
                        <tr>
                            <th class="bg-f0-sub">Lead</th>
                            <th class="bg-f1-sub">Opportunity</th>
                            <th class="bg-f2-sub" colspan="6">Self Assessment</th>
                            <th class="bg-f3-sub" colspan="3">Project Assessment</th>
                            <th class="bg-f4-sub">Negosiasi</th>
                            <th class="bg-f5-sub" colspan="3">Win</th>
                            <th class="bg-del-col" colspan="3"></th>
                            <th class="bg-billing" colspan="2"></th>
                        </tr>

                        <!-- ROW 3: Column names -->
                        <tr>
                            <th class="bg-f0-sub w-wide">Inisiasi</th>
                            <th class="bg-f1-sub w-wide">Technical</th>
                            <th class="bg-f2-col w-wide">P0/P1</th>
                            <th class="bg-f2-col w-wide">P2 Evaluasi</th>
                            <th class="bg-f2-col w-wide">P3 Penawaran</th>
                            <th class="bg-f2-col w-wide">P4 Rapat</th>
                            <th class="bg-f2-col w-wide">Offering</th>
                            <th class="bg-f2-col w-wide">P5 Evaluasi</th>
                            <th class="bg-f3-col w-wide">P6 Klarifikasi</th>
                            <th class="bg-f3-col w-wide">P7 SKKM</th>
                            <th class="bg-f3-col w-wide">P8 Memo</th>
                            <th class="bg-f4-col w-wide">P9 Penetapan</th>
                            <th class="bg-f5-col w-wide">P10 Perintah</th>
                            <th class="bg-f5-col w-wide">P11 PO/SPK</th>
                            <th class="bg-f5-col w-wide">Kontrak</th>
                            <th class="bg-del-col w-wide">KL Mitra</th>
                            <th class="bg-del-col w-wide">BAUT/BAST</th>
                            <th class="bg-del-col w-wide">BASO</th>
                            <th class="bg-billing w-normal">Invoice</th>
                            <th class="bg-billing w-normal">AR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($worksheet->projects as $index => $project)
                        <tr>
                            <td>{{ $project->is_user_added ? '★' : '' }} {{ $index + 1 }}</td>
                            <td class="w-project">{{ $project->project_name ?: '(Empty)' }}</td>
                            <td>{{ $project->id_lop }}</td>
                            <td>{{ $project->cc }}</td>
                            <td>{{ $project->am }}</td>
                            <td>{{ $project->mitra }}</td>
                            <td>{{ $project->phn_bulan }}</td>
                            <td>{{ $project->est_nilai_bc }}</td>
                            <!-- F0 -->
                            <td>{{ $project->f0 ? '✓' : '-' }}</td>
                            <!-- F1 -->
                            <td>{{ $project->f1 ? '✓' : '-' }}</td>
                            <!-- F2 -->
                            <td>{{ $project->f2_p0_p1_jukbok }}</td>
                            <td>{{ $project->p2_evaluasi_bakal_calon }}</td>
                            <td>{{ $project->f2_p3_permintaan_penawaran }}</td>
                            <td>{{ $project->f2_p4_rapat_penjelasan }}</td>
                            <td>{{ $project->offering_harga_final }}</td>
                            <td>{{ $project->f2_p5_evaluasi_sph ? '✓' : '-' }}</td>
                            <!-- F3 -->
                            <td>{{ $project->f3_p6_klarifikasi }}</td>
                            <td>{{ $project->f3_p7_skkm }}</td>
                            <td>{{ $project->f3_p8_memorandum ? '✓' : '-' }}</td>
                            <!-- F4 -->
                            <td>{{ $project->f4_p9_penetapan ? '✓' : '-' }}</td>
                            <!-- F5 -->
                            <td>{{ $project->f5_p10_perintah }}</td>
                            <td>{{ $project->f5_p11_po_spk }}</td>
                            <td>{{ $project->kontrak_layanan }}</td>
                            <!-- DELIVERY -->
                            <td>{{ $project->del_kontrak_layanan }}</td>
                            <td>{{ $project->baut_bast }}</td>
                            <td>{{ $project->baso }}</td>
                            <!-- BILLING -->
                            <td>{{ $project->invoice }}</td>
                            <td>{{ $project->ar }}</td>
                            <!-- Timestamp -->
                            <td class="text-xs">{{ $project->updated_at->format('d/m/y H:i') }}</td>
                            <!-- Ket -->
                            <td>{{ $project->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="32" class="px-4 py-8 text-center text-gray-500">
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
            <p class="text-xl">Belum ada riwayat worksheet</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
