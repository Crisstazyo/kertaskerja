<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScallingTelda extends Model
{
    use HasFactory;

    protected $table = 'scalling_telda';
    
    // List of all Telda locations
    public const TELDA_LOCATIONS = [
        'lubuk_pakam' => 'Lubuk Pakam',
        'binjai' => 'Binjai',
        'siantar' => 'Siantar',
        'kisaran' => 'Kisaran',
        'kabanjahe' => 'Kabanjahe',
        'rantau_prapat' => 'Rantau Prapat',
        'toba' => 'Toba',
        'sibolga' => 'Sibolga',
        'padang_sidempuan' => 'Padang Sidempuan',
    ];

    protected $fillable = [
        'user_id',
        'periode',
        'lubuk_pakam_commitment',
        'lubuk_pakam_real',
        'binjai_commitment',
        'binjai_real',
        'siantar_commitment',
        'siantar_real',
        'kisaran_commitment',
        'kisaran_real',
        'kabanjahe_commitment',
        'kabanjahe_real',
        'rantau_prapat_commitment',
        'rantau_prapat_real',
        'toba_commitment',
        'toba_real',
        'sibolga_commitment',
        'sibolga_real',
        'padang_sidempuan_commitment',
        'padang_sidempuan_real',
    ];

    protected $casts = [
        'periode' => 'date',
        'lubuk_pakam_commitment' => 'decimal:2',
        'lubuk_pakam_real' => 'decimal:2',
        'binjai_commitment' => 'decimal:2',
        'binjai_real' => 'decimal:2',
        'siantar_commitment' => 'decimal:2',
        'siantar_real' => 'decimal:2',
        'kisaran_commitment' => 'decimal:2',
        'kisaran_real' => 'decimal:2',
        'kabanjahe_commitment' => 'decimal:2',
        'kabanjahe_real' => 'decimal:2',
        'rantau_prapat_commitment' => 'decimal:2',
        'rantau_prapat_real' => 'decimal:2',
        'toba_commitment' => 'decimal:2',
        'toba_real' => 'decimal:2',
        'sibolga_commitment' => 'decimal:2',
        'sibolga_real' => 'decimal:2',
        'padang_sidempuan_commitment' => 'decimal:2',
        'padang_sidempuan_real' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
