<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RisingStar extends Model
{
    protected $fillable = [
        'user_id',
        'type_id',
        'status',
        'commitment',
        'real_ratio',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function scopeMainType($query, $typeNumber)
    {
        return $query->whereHas('type', function ($q) use ($typeNumber) {
            $q->where('type', $typeNumber);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function type()
    {
        return $this->belongsTo(RisingStarType::class, 'type_id');
    }
}
