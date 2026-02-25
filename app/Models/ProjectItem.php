<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectItem extends Model
{
    use HasFactory;

    protected $table = 'project_items';

    protected $fillable = [
        'number',
        'unit_scope',
        'indicator',
        'denom',
        'commitment_amount',
        'commitment_rp_million',
        'real_amount',
        'real_rp_amount',
        'fairness',
        'ach',
        'score',
    ];

    protected $casts = [
        'commitment_amount' => 'integer',
        'commitment_rp_million' => 'float',
        'real_amount' => 'integer',
        'real_rp_amount' => 'float',
        'fairness' => 'float',
        'ach' => 'float',
        'score' => 'float',
    ];
}
