<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScallingGovResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'scalling_data_id',
        'user_id',
        'row_index',
        'response_data',
        'status',
    ];

    protected $casts = [
        'response_data' => 'array',
    ];

    public function scallingData()
    {
        return $this->belongsTo(ScallingData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
