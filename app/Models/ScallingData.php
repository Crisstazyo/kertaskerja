<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScallingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'project',
        'id_lop',
        'cc',
        'nipnas',
        'am',
        'mitra',
        'plan_bulan_billcomp_2025',
        'est_nilai_bc',
        'import_log_id',
    ];

    protected $casts = [
        'est_nilai_bc' => 'decimal:2',
        'plan_bulan_billcomp_2025' => 'integer',
        'no' => 'integer',
    ];

    public function scallingImport()
    {
        return $this->belongsTo(ScallingImport::class, 'import_log_id');
    }
}