<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopQualifiedImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'uploaded_by',
        'file_name',
        'total_rows',
        'entity_type',
        'month',
        'year',
    ];

    public function data()
    {
        return $this->hasMany(LopQualifiedData::class, 'import_id');
    }
}
