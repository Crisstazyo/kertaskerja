<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScallingImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_filename',
        'status',
        'total_rows_imported',
        'notes',
        'uploaded_by',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function scallingdata()
    {
        return $this->hasMany(ScallingData::class, 'import_log_id');
    }
}