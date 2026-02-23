<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GovController;

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
Route::get('/', function() {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Government Routes (Protected)
Route::middleware(['auth'])->prefix('gov')->name('gov.')->group(function () {
    Route::get('/dashboard', [GovController::class, 'dashboard'])->name('dashboard');
    Route::get('/scalling', [GovController::class, 'scalling'])->name('scalling');
    Route::get('/psak', [GovController::class, 'psak'])->name('psak');
    Route::get('/lop-on-hand', [GovController::class, 'lopOnHand'])->name('lop-on-hand');
    Route::get('/lop-qualified', [GovController::class, 'lopQualified'])->name('lop-qualified');
    Route::get('/lop-koreksi', [GovController::class, 'lopKoreksi'])->name('lop-koreksi');
    Route::get('/lop-initiate', [GovController::class, 'lopInitiate'])->name('lop-initiate');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // NEW LOP Management Routes
    // LOP On Hand Routes
    Route::get('/admin/lop-manage/{entity}/on-hand', [AdminController::class, 'lopOnHandManage'])->name('admin.lop.on_hand');
    Route::get('/admin/lop-manage/{entity}/on-hand/history', [AdminController::class, 'lopOnHandHistory'])->name('admin.lop.on_hand.history');
    
    // LOP Qualified Routes
    Route::get('/admin/lop-manage/{entity}/qualified', [AdminController::class, 'lopQualifiedManage'])->name('admin.lop.qualified');
    Route::get('/admin/lop-manage/{entity}/qualified/history', [AdminController::class, 'lopQualifiedHistory'])->name('admin.lop.qualified.history');
    
    // LOP Koreksi Routes
    Route::get('/admin/lop-manage/{entity}/koreksi', [AdminController::class, 'lopKoreksiManage'])->name('admin.lop.koreksi');
    Route::get('/admin/lop-manage/{entity}/koreksi/history', [AdminController::class, 'lopKoreksiHistory'])->name('admin.lop.koreksi.history');
    
    // LOP Initiate Routes
    Route::get('/admin/lop-manage/{entity}/initiate', [AdminController::class, 'lopInitiateManage'])->name('admin.lop.initiate');
    Route::get('/admin/lop-manage/{entity}/initiate/history', [AdminController::class, 'lopInitiateHistory'])->name('admin.lop.initiate.history');
    Route::post('/admin/lop-manage/{entity}/initiate/store', [AdminController::class, 'lopInitiateStore'])->name('admin.lop.initiate.store');
    Route::delete('/admin/lop-manage/{entity}/initiate/{id}', [AdminController::class, 'lopInitiateDelete'])->name('admin.lop.initiate.delete');
    
    // Upload Excel (untuk On Hand, Qualified, Koreksi)
    Route::post('/admin/lop-manage/{entity}/{category}/upload', [AdminController::class, 'uploadLopData'])->name('admin.lop.upload');
    
    // Funnel Tracking
    Route::get('/admin/lop/funnel/{dataType}/{dataId}', [AdminController::class, 'showFunnelForm'])->name('admin.lop.funnel.show');
    Route::post('/admin/lop/funnel/{dataType}/{dataId}', [AdminController::class, 'updateFunnel'])->name('admin.lop.funnel.update');
    
    // Admin Notes
    Route::post('/admin/lop/note/save', [AdminController::class, 'saveAdminNote'])->name('admin.lop.note.save');
    Route::get('/admin/lop/note/{entity}/{category}/{month}/{year}', [AdminController::class, 'getAdminNote'])->name('admin.lop.note.get');
    
    // Step 2: Select Type (Scalling/PSAK)
    Route::get('/admin/lop/{entity}', [AdminController::class, 'lopTypeSelect'])->name('admin.lop.type-select');
    
    // Step 3: Select LOP Category (for Scalling)
    Route::get('/admin/lop/{entity}/{type}', [AdminController::class, 'lopCategorySelect'])->name('admin.lop.category-select');
    
    // Scalling Management for Gov (OLD - keeping for backward compatibility)
    Route::get('/admin/{role}/scalling', [AdminController::class, 'scalling'])->name('admin.scalling');
    Route::post('/admin/{role}/scalling/upload', [AdminController::class, 'uploadScalling'])->name('admin.scalling.upload');
    Route::get('/admin/{role}/scalling/data', [AdminController::class, 'scallingData'])->name('admin.scalling.data');
    
    // PSAK Management for Gov (OLD - keeping for backward compatibility)
    Route::get('/admin/{role}/psak', [AdminController::class, 'psak'])->name('admin.psak');
});
