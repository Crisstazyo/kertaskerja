<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ScallingController;
use App\Http\Controllers\PsakController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Role Selection Page
Route::get('/roles', [HomeController::class, 'roles'])->name('roles');

// Authentication Routes
Route::get('/login/{role}', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard & Project Management (Protected Routes)
Route::middleware('auth')->group(function () {
    // Main Dashboard Menu (redirect admin to admin panel)
    Route::get('/dashboard', function() {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return app(ProjectController::class)->menu();
    })->name('dashboard');
    
    // SCALLING Routes
    Route::get('/scalling', [ScallingController::class, 'index'])->name('scalling.index');
    
    // PSAK Routes
    Route::get('/psak', [PsakController::class, 'index'])->name('psak.index');
    
    // Project Management
    Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
    Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');
    Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
    
    // Custom Columns
    Route::post('/column/add', [ProjectController::class, 'addColumn'])->name('column.add');
    Route::delete('/column/{column}', [ProjectController::class, 'deleteColumn'])->name('column.delete');
    
    // Admin Routes
    Route::middleware('admin')->group(function () {
        // Step 1: Role Selection (Landing page)
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Step 2: Type Selection (Scalling/PSAK)
        Route::get('/admin/{role}', [AdminController::class, 'selectRole'])->name('admin.select-role');
        
        // Step 3: LOP Category Selection (for Scalling)
        Route::get('/admin/{role}/{type}', [AdminController::class, 'selectType'])->name('admin.select-type');
        
        // Step 4: LOP Management (Tambah/Lihat/Riwayat)
        Route::get('/admin/{role}/{type}/{lopCategory}', [AdminController::class, 'manageLop'])->name('admin.lop-manage');
        
        // Actions
        Route::get('/admin/{role}/{type}/{lopCategory}/data', [AdminController::class, 'viewData'])->name('admin.view-data');
        Route::get('/admin/{role}/{type}/{lopCategory}/history', [AdminController::class, 'viewHistory'])->name('admin.view-history');
        Route::post('/admin/create-worksheet', [AdminController::class, 'createWorksheet'])->name('admin.create-worksheet');
        Route::post('/admin/add-project', [AdminController::class, 'addProject'])->name('admin.add-project');
        Route::put('/admin/project/{project}', [AdminController::class, 'updateProject'])->name('admin.update-project');
        
        // Recap
        Route::get('/admin/recap/{role}/all', [AdminController::class, 'recap'])->name('admin.recap');
    });
});
