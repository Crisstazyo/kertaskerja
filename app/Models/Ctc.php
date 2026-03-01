<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ctc extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'periode',
        'segment',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
