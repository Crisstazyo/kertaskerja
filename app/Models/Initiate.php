<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Initiate extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'no',
        'project',
        'id_lop',
        'cc',
        'nipnas',
        'am',
        'mitra',
        'plan_bulan_billcomp_2025',
        'est_nilai_bc',
        // 'imports_log_id',
    ];

    protected $casts = [
        'est_nilai_bc' => 'decimal:2',
        'plan_bulan_billcomp_2025' => 'integer',
        // 'no' => 'integer',
    ];

    public function funnel()
    {
        return $this->hasOne(\App\Models\FunnelTracking::class, 'data_id');
    }
}
