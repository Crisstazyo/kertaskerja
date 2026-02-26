<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScallingTelda extends Model
{
    use HasFactory;

    protected $table = 'scalling_telda';

    protected $fillable = [
        'user_id',
        'periode',
        'commitment',
        'real',
    ];

    protected $casts = [
        'periode' => 'date',
        'commitment' => 'decimal:2',
        'real' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
