<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'column_name',
        'column_label',
        'column_type',
        'order',
    ];
}
