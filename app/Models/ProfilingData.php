<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilingData extends Model
{
    protected $table = 'profiling_data';
    
    protected $fillable = [
        'user_id',
        'type',
        'month',
        'year',
        'entry_date',
        'category',
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
