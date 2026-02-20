<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Worksheet;
use Illuminate\Http\Request;

class ScallingController extends Controller
{
    public function index(Request $request)
    {
        $role = auth()->user()->role;
        
        // Only show scalling worksheets
        $query = Worksheet::with(['projects' => function($q) {
            $q->orderBy('is_user_added', 'asc')->orderBy('created_at', 'asc');
        }])->where('type', 'scalling');
        
        if ($role !== 'admin') {
            $query->where('role', $role);
        }
        
        $worksheets = $query->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('lop_category', 'asc')
            ->get();
        
        // Group by LOP category
        $worksheetsByLop = $worksheets->groupBy('lop_category');
        
        return view('scalling.index', compact('worksheetsByLop', 'role'));
    }
}
