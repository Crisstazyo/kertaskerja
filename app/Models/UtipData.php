<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtipData extends Model
{
    use HasFactory;

    protected $table = 'utip_data';

    protected $fillable = [
        'user_id',
        'entry_date',
        'type', // 'new' or 'corrective'
        'category', // 'plan', 'komitmen', 'realisasi'
        'value',
        'keterangan',
        'description',
        'month',
        'year',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
        'value' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
