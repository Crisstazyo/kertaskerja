<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koreksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'nama_pelanggan',
        'nilai_komitmen',
        'progress',
        'realisasi',
        'is_manual',
        'imports_log_id',
    ];

    // protected $casts = [
    //     'nilai_komitmen' => 'boolean',
    // ];

    public function scallingImport()
    {
        // column name from migration: imports_log_id
        return $this->belongsTo(ScallingImport::class, 'imports_log_id');
    }
}
