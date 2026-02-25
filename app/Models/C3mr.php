<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class C3mr extends Model
{
    use HasFactory;

    protected $table = 'c3mr';

    protected $fillable = [
        'user_id',
        'entry_date',
        'type', // 'komitmen' or 'realisasi'
        'ratio',
        'keterangan',
        'description',
        'month',
        'year',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
        'ratio' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
