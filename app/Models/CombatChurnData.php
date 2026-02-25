<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CombatChurnData extends Model
{
    protected $table = 'combat_churn_data';
    
    protected $fillable = [
        'user_id',
        'type',
        'month',
        'year',
        'entry_date',
        'category',
        'region',
        'quantity',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
