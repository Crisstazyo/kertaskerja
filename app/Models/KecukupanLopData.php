<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KecukupanLopData extends Model
{
    protected $table = 'kecukupan_lop_data';
    
    protected $fillable = [
        'user_id',
        'type',
        'month',
        'year',
        'entry_date',
        'target_ratio',
        'ratio_aktual',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
