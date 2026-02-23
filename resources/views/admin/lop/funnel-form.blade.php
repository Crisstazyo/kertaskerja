@extends('layouts.app')

@section('title', 'Update Funnel Tracking')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <a href="javascript:history.back()" class="mr-4 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">📊 Update Funnel Tracking</h1>
                        <p class="text-gray-600">{{ $data->project ?? 'Project' }} - {{ $denganMitra ? 'Dengan Mitra' : 'Tanpa Mitra' }}</p>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full"></div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <!-- Funnel Form -->
        <form action="{{ route('admin.lop.funnel.update', [$dataType, $dataId]) }}" method="POST">
            @csrf
            <div class="bg-white rounded-xl shadow-lg overflow-x-auto border-2 border-indigo-100">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-bold border-r border-indigo-400">F0<br>Lead</th>
                            <th class="px-4 py-3 text-left text-sm font-bold border-r border-indigo-400">F1<br>Opportunity</th>
                            <th class="px-4 py-3 text-left text-sm font-bold border-r border-indigo-400">F2<br>Self Assessment & Management Solution</th>
                            <th class="px-4 py-3 text-left text-sm font-bold border-r border-indigo-400">F3<br>Project Assessment (RPA)</th>
                            <th class="px-4 py-3 text-left text-sm font-bold border-r border-indigo-400">F4<br>Negosiasi</th>
                            <th class="px-4 py-3 text-left text-sm font-bold border-r border-indigo-400">F5<br>Win</th>
                            <th class="px-4 py-3 text-left text-sm font-bold">DELIVERY</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <!-- F0 -->
                            <td class="px-4 py-3 border-r border-gray-200 align-top">
                                <div class="space-y-2">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f0_lead" value="1" {{ $funnel->f0_lead ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Lead</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f0_inisiasi_solusi" value="1" {{ $funnel->f0_inisiasi_solusi ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Inisiasi Solusi</span>
                                    </label>
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f0_technical_proposal" value="1" {{ $funnel->f0_technical_proposal ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Technical & Proposal discussion jasa</span>
                                    </label>
                                </div>
                            </td>
                            
                            <!-- F1 -->
                            <td class="px-4 py-3 border-r border-gray-200 align-top">
                                @if($denganMitra)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="f1_p0_p1_juskeb" value="1" {{ $funnel->f1_p0_p1_juskeb ? 'checked' : '' }} 
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm">P0/P1. Juskeb bahwa calon mitra</span>
                                </label>
                                @else
                                <span class="text-gray-400 text-center block">-</span>
                                @endif
                            </td>
                            
                            <!-- F2 -->
                            <td class="px-4 py-3 border-r border-gray-200 align-top">
                                <div class="space-y-2">
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f2_p2_evaluasi" value="1" {{ $funnel->f2_p2_evaluasi ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo600 focus:ring-indigo-500">
                                        <span class="text-sm">P2. Evaluasi Bakal</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- P2. Evaluasi Bakal</span>
                                    @endif
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f2_p3_permintaan_harga" value="1" {{ $funnel->f2_p3_permintaan_harga ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">P3. Permintaan Harga</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- P3. Permintaan Harga</span>
                                    @endif
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f2_p4_rapat_penjelasan" value="1" {{ $funnel->f2_p4_rapat_penjelasan ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">P4. Rapat Penjelasan</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- P4. Rapat Penjelasan</span>
                                    @endif
                                    
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f2_offering_harga" value="1" {{ $funnel->f2_offering_harga ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Offering Harga</span>
                                    </label>
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f2_p5_evaluasi_sph" value="1" {{ $funnel->f2_p5_evaluasi_sph ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">P5. Evaluasi SPH Mitra</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- P5. Evaluasi SPH Mitra</span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- F3 -->
                            <td class="px-4 py-3 border-r border-gray-200 align-top">
                                <div class="space-y-2">
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f3_propos_al" value="1" {{ $funnel->f3_propos_al ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Propos al</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- Propos al</span>
                                    @endif
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f3_p6_klarifikasi" value="1" {{ $funnel->f3_p6_klarifikasi ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">P6.Klari fikasi & Negosiasi</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- P6.Klari fikasi & Negosiasi</span>
                                    @endif
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f3_p7_penetapan" value="1" {{ $funnel->f3_p7_penetapan ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">P7. Penetapan Pemenang Mitra</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- P7. Penetapan Pemenang Mitra</span>
                                    @endif
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f3_submit_proposal" value="1" {{ $funnel->f3_submit_proposal ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Submit proposal pemenang/ SPH ke pign</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- Submit proposal pemenang/ SPH ke pign</span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- F4 -->
                            <td class="px-4 py-3 border-r border-gray-200 align-top">
                                <div class="space-y-2">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f4_negosiasi" value="1" {{ $funnel->f4_negosiasi ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Negosiasi</span>
                                    </label>
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f4_surat_kesanggupan" value="1" {{ $funnel->f4_surat_kesanggupan ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">Surat Kesang gupan Tanda Tangan Kontrak</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- Surat Kesang gupan Tanda Tangan Kontrak</span>
                                    @endif
                                    
                                    @if($denganMitra)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="f4_p8_surat_pemenang" value="1" {{ $funnel->f4_p8_surat_pemenang ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm">P8. Surat Pemenang/ n Mitra</span>
                                    </label>
                                    @else
                                    <span class="text-gray-400">- P8. Surat Pemenang/ n Mitra</span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- F5 -->
                            <td class="px-4 py-3 border-r border-gray-200 align-top">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="f5_kontrak_layanan" value="1" {{ $funnel->f5_kontrak_layanan ? 'checked' : '' }} 
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm">Kontrak Layanan (KLI) BAST dengan Mitra</span>
                                </label>
                            </td>
                            
                            <!-- DELIVERY -->
                            <td class="px-4 py-3 align-top">
                                <div class="space-y-3">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="delivery_billing_complete" value="1" {{ $funnel->delivery_billing_complete ? 'checked' : '' }} 
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-sm font-semibold">BILLING COMPLETE</span>
                                    </label>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">BAUT & BASO</label>
                                        <input type="text" name="delivery_baso" value="{{ $funnel->delivery_baso ?? '' }}" 
                                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                            placeholder="BAUT & BASO">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">NILAI BILLCOMP</label>
                                        <input type="text" name="delivery_nilai_billcomp" value="{{ $funnel->delivery_nilai_billcomp ?? '' }}" 
                                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                            placeholder="Nilai Billcomp">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="javascript:history.back()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-lg font-semibold transition-all duration-300">
                    Batal
                </a>
                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md">
                    💾 Simpan Funnel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
