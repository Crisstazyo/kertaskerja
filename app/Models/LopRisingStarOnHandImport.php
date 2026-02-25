<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopRisingStarOnHandImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'total_rows',
        'month',
        'year',
        'uploaded_by',
    ];

    public function data()
    {
        return $this->hasMany(LopRisingStarOnHandData::class, 'import_id');
    }
}
