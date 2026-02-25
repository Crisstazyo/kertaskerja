<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopCtcInitiatedData extends Model
{
    use HasFactory;

    protected $table = 'lop_ctc_initiated_data';

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
        return $this->belongsTo(LopCtcOnHandImport::class, 'import_id');
    }
    
    public function funnel()
    {
        return $this->hasOne(FunnelTracking::class, 'data_id', 'id')
                    ->where('data_type', 'ctc_initiate');
    }
}
