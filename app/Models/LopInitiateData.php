<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopInitiateData extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_type',
        'created_by',
        'month',
        'year',
        'no',
        'project',
        'id_lop',
        'cc',
        'nipnas',
        'am',
        'mitra',
        'plan_bulan_billcom_p_2025',
        'est_nilai_bc',
    ];
    
    public function funnel()
    {
        return $this->morphOne(FunnelTracking::class, 'data', 'data_type', 'data_id');
    }
}
