<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScallingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'uploaded_by',
        'file_name',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function responses()
    {
        return $this->hasMany(ScallingGovResponse::class);
    }
}
