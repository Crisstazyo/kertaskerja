<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopAdminNote extends Model
{
    use HasFactory;

    protected $table = 'lop_admin_notes';

    protected $fillable = [
        'entity_type',
        'category',
        'month',
        'year',
        'note',
        'created_by',
    ];
}
