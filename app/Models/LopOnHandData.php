<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopOnHandData extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_id',
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

    public function import()
    {
        return $this->belongsTo(LopOnHandImport::class, 'import_id');
    }
    
    public function funnel()
    {
        return $this->morphOne(FunnelTracking::class, 'data', 'data_type', 'data_id');
    }
}
