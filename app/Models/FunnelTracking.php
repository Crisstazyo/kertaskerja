<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunnelTracking extends Model
{
    use HasFactory;

    protected $table = 'funnel_tracking';

    protected $fillable = [
        'data_type',
        'data_id',
        'f0_lead',
        'f0_inisiasi_solusi',
        'f0_technical_proposal',
        'f1_p0_p1_juskeb',
        'f2_p2_evaluasi',
        'f2_p3_permintaan_harga',
        'f2_p4_rapat_penjelasan',
        'f2_offering_harga',
        'f2_p5_evaluasi_sph',
        'f3_propos_al',
        'f3_p6_klarifikasi',
        'f3_p7_penetapan',
        'f3_submit_proposal',
        'f4_negosiasi',
        'f4_surat_kesanggupan',
        'f4_p8_surat_pemenang',
        'f5_kontrak_layanan',
        'delivery_billing_complete',
        'delivery_nilai_billcomp',
        'delivery_baso',
    ];

    protected $casts = [
        'f0_lead' => 'boolean',
        'f0_inisiasi_solusi' => 'boolean',
        'f0_technical_proposal' => 'boolean',
        'f1_p0_p1_juskeb' => 'boolean',
        'f2_p2_evaluasi' => 'boolean',
        'f2_p3_permintaan_harga' => 'boolean',
        'f2_p4_rapat_penjelasan' => 'boolean',
        'f2_offering_harga' => 'boolean',
        'f2_p5_evaluasi_sph' => 'boolean',
        'f3_propos_al' => 'boolean',
        'f3_p6_klarifikasi' => 'boolean',
        'f3_p7_penetapan' => 'boolean',
        'f3_submit_proposal' => 'boolean',
        'f4_negosiasi' => 'boolean',
        'f4_surat_kesanggupan' => 'boolean',
        'f4_p8_surat_pemenang' => 'boolean',
        'f5_kontrak_layanan' => 'boolean',
        'delivery_billing_complete' => 'boolean',
    ];
}
