<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psak extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type', // gov, soe, sme, private
        'status',
        'segment', // Not Cose
        'comm_ssl',
        'comm_rp',
        'real_ssl',
        'real_rp',
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
