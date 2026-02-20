<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'role',
        'type',
        'lop_category',
        'name',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getMonthNameAttribute()
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $months[$this->month] ?? '';
    }

    public function getLopCategoryNameAttribute()
    {
        $categories = [
            'on_hand' => 'LOP On Hand',
            'qualified' => 'LOP Qualified',
            'initiate' => 'LOP Initiate',
            'koreksi' => 'LOP Koreksi'
        ];
        return $categories[$this->lop_category] ?? '';
    }

    public function getTypeNameAttribute()
    {
        return $this->type === 'scalling' ? 'Scalling' : 'PSAK';
    }

    public function getFullNameAttribute()
    {
        if ($this->name) {
            return $this->name;
        }
        
        $parts = [$this->month_name, $this->year];
        
        if ($this->type) {
            $parts[] = $this->type_name;
        }
        
        if ($this->lop_category) {
            $parts[] = $this->lop_category_name;
        }
        
        return implode(' - ', $parts);
    }
}
