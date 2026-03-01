<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RisingStarType extends Model
{
    protected $fillable = [
        'type',
        'name',
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

    

    public function risingStars()
    {
        return $this->hasMany(RisingStar::class, 'type_id');
    }
}
