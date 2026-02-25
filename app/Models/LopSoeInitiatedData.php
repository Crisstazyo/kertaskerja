<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopSoeInitiatedData extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_id',
        'added_by_user_id',
        'is_user_added',
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
        return $this->belongsTo(LopSoeInitiatedImport::class, 'import_id');
    }
    
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by_user_id');
    }
    
    public function funnel()
    {
        return $this->hasOne(FunnelTracking::class, 'data_id', 'id')
                    ->where('data_type', 'soe_initiated');
    }
}
