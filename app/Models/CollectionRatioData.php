<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionRatioData extends Model
{
    use HasFactory;

    protected $table = 'collection_ratio_data';

    protected $fillable = [
        'user_id',
        'entry_date',
        'type',
        'segment',
        'ratio',
        'target_ratio',
        'ratio_aktual',
        'keterangan',
        'description',
        'month',
        'year',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'ratio' => 'decimal:2',
        'target_ratio' => 'decimal:2',
        'ratio_aktual' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
