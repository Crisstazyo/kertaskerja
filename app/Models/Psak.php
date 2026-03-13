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
    'user_id', 'type', 'status', 'periode', 'segment',
    'comm_ssl', 'comm_rp', 'real_ssl', 'real_rp',
    'real_updated_at',
];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    'created_at'      => 'datetime',
    'updated_at'      => 'datetime',
    'real_updated_at' => 'datetime',
];

protected static function booted(): void
{
    static::updating(function ($model) {
        if ($model->isDirty('real_rp') || $model->isDirty('real_ssl')) {
            $model->real_updated_at = now();
        }
    });
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
