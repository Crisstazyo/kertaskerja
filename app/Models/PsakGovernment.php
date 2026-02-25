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
        'tanggal',
        'commitment_ssl',
        'real_ssl',
        'commitment_rp',
        'real_rp',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'commitment_ssl' => 'decimal:2',
        'real_ssl' => 'decimal:2',
        'commitment_rp' => 'decimal:2',
        'real_rp' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
