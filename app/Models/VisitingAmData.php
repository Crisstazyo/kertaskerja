<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitingAmData extends Model
{
    protected $table = 'visiting_am_data';
    
    protected $fillable = [
        'user_id',
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
