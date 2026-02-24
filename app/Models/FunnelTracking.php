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
        'f1_p0_p1',
        'f1_juskeb',
        'f1_bod_dm',
        'f1_p0_p1_juskeb',
        'f2_p2',
        'f2_evaluasi',
        'f2_taf',
        'f2_juskeb',
        'f2_bod_dm',
        'f2_p2_evaluasi',
        'f2_p3_permintaan_harga',
        'f2_p4_rapat_penjelasan',
        'f2_offering_harga',
        'f2_p5_evaluasi_sph',
        'f3_p3_1',
        'f3_sph',
        'f3_juskeb',
        'f3_bod_dm',
        'f3_propos_al',
        'f3_p6_klarifikasi',
        'f3_p7_penetapan',
        'f3_submit_proposal',
        'f4_p3_2',
        'f4_pks',
        'f4_bast',
        'f4_negosiasi',
        'f4_surat_kesanggupan',
        'f4_p8_surat_pemenang',
        'f5_p4',
        'f5_p5',
        'f5_kontrak_layanan',
        'delivery_billing_complete',
        'delivery_nilai_billcomp',
        'delivery_baso',
        'updated_by',
        'last_updated_at',
    ];

    protected $casts = [
        'f0_lead' => 'boolean',
        'f0_inisiasi_solusi' => 'boolean',
        'f0_technical_proposal' => 'boolean',
        'f1_p0_p1' => 'boolean',
        'f1_juskeb' => 'boolean',
        'f1_bod_dm' => 'boolean',
        'f1_p0_p1_juskeb' => 'boolean',
        'f2_p2' => 'boolean',
        'f2_evaluasi' => 'boolean',
        'f2_taf' => 'boolean',
        'f2_juskeb' => 'boolean',
        'f2_bod_dm' => 'boolean',
        'f2_p2_evaluasi' => 'boolean',
        'f2_p3_permintaan_harga' => 'boolean',
        'f2_p4_rapat_penjelasan' => 'boolean',
        'f2_offering_harga' => 'boolean',
        'f2_p5_evaluasi_sph' => 'boolean',
        'f3_p3_1' => 'boolean',
        'f3_sph' => 'boolean',
        'f3_juskeb' => 'boolean',
        'f3_bod_dm' => 'boolean',
        'f3_propos_al' => 'boolean',
        'f3_p6_klarifikasi' => 'boolean',
        'f3_p7_penetapan' => 'boolean',
        'f3_submit_proposal' => 'boolean',
        'f4_p3_2' => 'boolean',
        'f4_pks' => 'boolean',
        'f4_bast' => 'boolean',
        'f4_negosiasi' => 'boolean',
        'f4_surat_kesanggupan' => 'boolean',
        'f4_p8_surat_pemenang' => 'boolean',
        'f5_p4' => 'boolean',
        'f5_p5' => 'boolean',
        'f5_kontrak_layanan' => 'boolean',
        'delivery_billing_complete' => 'boolean',
        'delivery_nilai_billcomp' => 'decimal:2',
        'last_updated_at' => 'datetime',
    ];

    /**
     * Relationship to user who last updated this funnel
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
