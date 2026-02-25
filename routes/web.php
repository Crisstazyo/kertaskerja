<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GovController;
use App\Http\Controllers\PrivateController;
use App\Http\Controllers\SoeController;
use App\Http\Controllers\SmeController;

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
    // If user is already authenticated, redirect to their dashboard
    if (auth()->check()) {
        $role = auth()->user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'government') {
            return redirect()->route('government.dashboard');
        }
        if ($role === 'gov') {
            return redirect()->route('gov.dashboard');
        }
        if ($role === 'private') {
            return redirect()->route('private.dashboard');
        }
        if ($role === 'soe') {
            return redirect()->route('soe.dashboard');
        }
        if ($role === 'sme') {
            return redirect()->route('sme.dashboard');
        }
    }
    
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Government Routes (Protected) - using 'gov' prefix for backward compatibility
Route::middleware(['auth'])->prefix('gov')->name('gov.')->group(function () {
    Route::get('/dashboard', [GovController::class, 'dashboard'])->name('dashboard');
    Route::get('/scalling', [GovController::class, 'scalling'])->name('scalling');
    Route::get('/psak', [GovController::class, 'psak'])->name('psak');
    Route::get('/lop-on-hand', [GovController::class, 'lopOnHand'])->name('lop-on-hand');
    Route::get('/lop-qualified', [GovController::class, 'lopQualified'])->name('lop-qualified');
    Route::get('/lop-koreksi', [GovController::class, 'lopKoreksi'])->name('lop-koreksi');
    Route::get('/lop-initiate', [GovController::class, 'lopInitiate'])->name('lop-initiate');
    
    // Funnel Tracking Update (AJAX)
    Route::post('/funnel/update', [GovController::class, 'updateFunnelCheckbox'])->name('funnel.update');
    
    // PSAK AJAX
    Route::post('/psak/save', [GovController::class, 'savePsak'])->name('psak.save');
});

// Government Routes (Protected) - using 'government' prefix (alternative)
Route::middleware(['auth'])->prefix('government')->name('government.')->group(function () {
    Route::get('/dashboard', [GovController::class, 'dashboard'])->name('dashboard');
    Route::get('/scalling', [GovController::class, 'scalling'])->name('scalling');
    Route::get('/psak', [GovController::class, 'psak'])->name('psak');
    Route::get('/lop-on-hand', [GovController::class, 'lopOnHand'])->name('lop-on-hand');
    Route::get('/lop-qualified', [GovController::class, 'lopQualified'])->name('lop-qualified');
    Route::get('/lop-koreksi', [GovController::class, 'lopKoreksi'])->name('lop-koreksi');
    Route::get('/lop-initiate', [GovController::class, 'lopInitiate'])->name('lop-initiate');
    
    // Funnel Tracking Update (AJAX)
    Route::post('/funnel/update', [GovController::class, 'updateFunnelCheckbox'])->name('funnel.update');
    
    // PSAK AJAX
    Route::post('/psak/save', [GovController::class, 'savePsak'])->name('psak.save');
});

// Private Routes (Protected)
Route::middleware(['auth'])->prefix('private')->name('private.')->group(function () {
    Route::get('/dashboard', [PrivateController::class, 'dashboard'])->name('dashboard');
    Route::get('/scalling', [PrivateController::class, 'scalling'])->name('scalling');
    Route::get('/psak', [PrivateController::class, 'psak'])->name('psak');
    Route::get('/lop-on-hand', [PrivateController::class, 'lopOnHand'])->name('lop-on-hand');
    Route::get('/lop-qualified', [PrivateController::class, 'lopQualified'])->name('lop-qualified');
    Route::get('/lop-koreksi', [PrivateController::class, 'lopKoreksi'])->name('lop-koreksi');
    Route::get('/lop-initiate', [PrivateController::class, 'lopInitiate'])->name('lop-initiate');
    Route::get('/lop-initiated', [PrivateController::class, 'lopInitiated'])->name('lop-initiated');
    Route::get('/lop-correction', [PrivateController::class, 'lopCorrection'])->name('lop-correction');
    
    // Funnel Tracking Update (AJAX)
    Route::post('/funnel/update', [PrivateController::class, 'updateFunnelCheckbox'])->name('funnel.update');
    
    // PSAK AJAX
    Route::post('/psak/save', [PrivateController::class, 'savePsak'])->name('psak.save');
});

// SOE Routes (Protected)
Route::middleware(['auth'])->prefix('soe')->name('soe.')->group(function () {
    Route::get('/dashboard', [SoeController::class, 'dashboard'])->name('dashboard');
    Route::get('/scalling', [SoeController::class, 'scalling'])->name('scalling');
    Route::get('/psak', [SoeController::class, 'psak'])->name('psak');
    Route::get('/lop-on-hand', [SoeController::class, 'lopOnHand'])->name('lop-on-hand');
    Route::get('/lop-qualified', [SoeController::class, 'lopQualified'])->name('lop-qualified');
    Route::get('/lop-koreksi', [SoeController::class, 'lopKoreksi'])->name('lop-koreksi');
    Route::get('/lop-initiate', [SoeController::class, 'lopInitiate'])->name('lop-initiate');
    Route::get('/lop-initiated', [SoeController::class, 'lopInitiated'])->name('lop-initiated');
    Route::get('/lop-correction', [SoeController::class, 'lopCorrection'])->name('lop-correction');
    
    // Funnel Tracking Update (AJAX)
    Route::post('/funnel/update', [SoeController::class, 'updateFunnelCheckbox'])->name('funnel.update');
    
    // PSAK AJAX
    Route::post('/psak/save', [SoeController::class, 'savePsak'])->name('psak.save');
});

// SME Routes (Protected)
Route::middleware(['auth'])->prefix('sme')->name('sme.')->group(function () {
    Route::get('/dashboard', [SmeController::class, 'dashboard'])->name('dashboard');
    Route::get('/scalling', [SmeController::class, 'scalling'])->name('scalling');
    Route::get('/psak', [SmeController::class, 'psak'])->name('psak');
    Route::get('/lop-on-hand', [SmeController::class, 'lopOnHand'])->name('lop-on-hand');
    Route::get('/lop-qualified', [SmeController::class, 'lopQualified'])->name('lop-qualified');
    Route::get('/lop-koreksi', [SmeController::class, 'lopKoreksi'])->name('lop-koreksi');
    Route::get('/lop-initiate', [SmeController::class, 'lopInitiate'])->name('lop-initiate');
    Route::get('/lop-initiated', [SmeController::class, 'lopInitiated'])->name('lop-initiated');
    Route::get('/lop-correction', [SmeController::class, 'lopCorrection'])->name('lop-correction');
    
    // Funnel Tracking Update (AJAX)
    Route::post('/funnel/update', [SmeController::class, 'updateFunnelCheckbox'])->name('funnel.update');
    
    // PSAK AJAX
    Route::post('/psak/save', [SmeController::class, 'savePsak'])->name('psak.save');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // NEW SIMPLIFIED FLOW - Role Selection and Actions
    Route::get('/admin/role/{role}', [AdminController::class, 'roleMenu'])->name('admin.role.menu');
    
    // Category-specific Upload and Progress Routes
    Route::get('/admin/role/{role}/upload/{category}', [AdminController::class, 'uploadCategoryPage'])->name('admin.upload.category');
    Route::get('/admin/role/{role}/progress/{category}', [AdminController::class, 'progressCategoryPage'])->name('admin.progress.category');
    Route::post('/admin/role/{role}/progress/{category}/toggle-visibility', [AdminController::class, 'toggleUploadVisibility'])->name('admin.progress.toggle-visibility');
    
    // OLD Routes (deprecated)
    Route::get('/admin/role/{role}/upload', [AdminController::class, 'uploadPage'])->name('admin.upload.page');
    Route::get('/admin/role/{role}/progress', [AdminController::class, 'progressPage'])->name('admin.progress.page');
    Route::get('/admin/role/{role}/progress/{category}/{month}/{year}', [AdminController::class, 'progressDetail'])->name('admin.progress.detail');
    
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
    
    // LOP Progress Tracking
    Route::get('/admin/lop/progress-tracking', [AdminController::class, 'lopProgressTracking'])->name('admin.lop.progress-tracking');
    
    // Step 2: Select Type (Scalling/PSAK)
    Route::get('/admin/lop/{entity}', [AdminController::class, 'lopTypeSelect'])->name('admin.lop.type-select');
    
    // Step 3: Select LOP Category (for Scalling)
    Route::get('/admin/lop/{entity}/{type}', [AdminController::class, 'lopCategorySelect'])->name('admin.lop.category-select');
    
    // Scalling Management for Gov (OLD - keeping for backward compatibility)
    Route::get('/admin/{role}/scalling', [AdminController::class, 'scalling'])->name('admin.scalling');
    Route::post('/admin/{role}/scalling/upload', [AdminController::class, 'uploadScalling'])->name('admin.scalling.upload');
    Route::get('/admin/{role}/scalling/data', [AdminController::class, 'scallingData'])->name('admin.scalling.data');
    
    // Upload History and Progress Tracking for all roles
    Route::get('/admin/{role}/upload-history', [AdminController::class, 'uploadHistory'])->name('admin.upload-history');
    Route::get('/admin/{role}/progress-tracking', [AdminController::class, 'progressTracking'])->name('admin.progress-tracking');
    
    // PSAK Management for Gov (OLD - keeping for backward compatibility)
    Route::get('/admin/{role}/psak', [AdminController::class, 'psak'])->name('admin.psak');
});
