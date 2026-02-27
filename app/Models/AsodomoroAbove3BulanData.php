<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsodomoroAbove3BulanData extends Model
{
    use HasFactory;

    protected $table = 'asodomoro_above_3_bulan_data';

    protected $fillable = [
        'user_id',
        'entry_date',
        'type',
        'month',
        'year',
        'realisasi',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'month' => 'integer',
        'year' => 'integer',
        'realisasi' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
