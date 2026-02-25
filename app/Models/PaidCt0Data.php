<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidCt0Data extends Model
{
    protected $table = 'paid_ct0_data';
    
    protected $fillable = [
        'user_id',
        'type',
        'month',
        'year',
        'entry_date',
        'region',
        'nominal',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
