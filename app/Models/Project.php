<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'worksheet_id',
        'is_user_added',
        'role',
        'project_name',
        'id_lop',
        'cc',
        'oc',
        'nipnas',
        'am',
        'mitra',
        'phn_bulan_billcomp',
        'est_nilai_bc',
        'pra_bahan_eskplorasi',
        'est_nilai_rkp',
        'project_health',
        'tender_budget_description',
        'kop_m_vendor',
        'p2_evaluasi_tender',
        'p2_evaluasi_bakal_calon',
        'p2_penawaran_harga',
        'p4_hasil_pejelasan',
        'offering_harga_final',
        'p5_evaluasi_bill_mix',
        'p6_notifikasi',
        'p7_negosiasi',
        'p7_negosiasi_dokumen_penawaran',
        'p7_negosiasi_addendum',
        'negosiasi',
        'persiapan_kontrak',
        'surat',
        'tanda',
        'pr_surat',
        'kontrak_tanda_tangan_baut',
        'baut',
        'rabo',
        'keterangan',
        'custom_fields',
        // Funnel columns
        'f0_inisiasi_solusi',
        'f1_technical_budget',
        'f2_p0_p1_jukbok',
        'f2_p3_permintaan_penawaran',
        'f2_p4_rapat_penjelasan',
        'f2_p5_evaluasi_sph',
        'f3_p6_klarifikasi_negosiasi',
        'f3_p7_penetapan_mitra',
        'f3_submit_proposal',
        'f5_p8_surat_penetapan',
        'del_kontrak_layanan',
        'del_baso',
        'billing_complete',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        // Boolean casts for checkbox fields
        'f0_inisiasi_solusi' => 'boolean',
        'f1_technical_budget' => 'boolean',
        'f2_p5_evaluasi_sph' => 'boolean',
        'negosiasi' => 'boolean',
        'f5_p8_surat_penetapan' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }
}
