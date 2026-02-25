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
        'jml_asodomoro',
        'nilai_bc',
        'keterangan',
        'description',
        'month',
        'year',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'jml_asodomoro' => 'integer',
        'nilai_bc' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
