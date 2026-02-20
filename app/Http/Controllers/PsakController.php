<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PsakController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        
        return view('psak.index', compact('role'));
    }
}
