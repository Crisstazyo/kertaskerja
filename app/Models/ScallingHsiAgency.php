<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScallingHsiAgency extends Model
{
    use HasFactory;

    protected $table = 'scalling_hsi_agency';

    protected $fillable = [
        'user_id',
        'periode',
        'commitment',
        'real',
    ];

    protected $casts = [
        'periode' => 'date',
        'commitment' => 'integer',
        'real' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
