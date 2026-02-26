<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsakGovernment extends Model
{
    use HasFactory;

    protected $table = 'psak_government';

    protected $fillable = [
        'user_id',
        'periode',
        'segment',
        'tanggal',
        'commitment_order',
        'real_order',
        'commitment_rp',
        'real_rp',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'commitment_order' => 'decimal:2',
        'real_order' => 'decimal:2',
        'commitment_rp' => 'decimal:2',
        'real_rp' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
