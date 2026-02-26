<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GovController;
use App\Http\Controllers\PrivateController;
use App\Http\Controllers\SoeController;
use App\Http\Controllers\SmeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CtcController;
use App\Http\Controllers\RisingStarController;

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
        if ($role === 'collection') {
            return redirect()->route('collection.dashboard');
        }
        if ($role === 'ctc') {
            return redirect()->route('ctc.dashboard');
        }
        if ($role === 'rising-star') {
            return redirect()->route('rising-star.dashboard');
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
    //Route::get('/lop-initiate', [GovController::class, 'lopInitiate'])->name('lop-initiate');
    //Route::post('/lop-initiate', [GovController::class, 'storeLopInitiate'])->name('government.lop-initiate.store');
    //Route::post('/lop-initiate', [GovController::class, 'storeLopInitiate'])->name('government.lop-initiate.create');
    
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
    //Route::get('/lop-initiate', [GovController::class, 'lopInitiate'])->name('lop-initiate');
    //Route::get('/lop-initiated', [GovController::class, 'lopInitiated'])->name('lop-initiated');
    //Route::get('/lop-initiate/create', [GovController::class, 'createLopInitiate'])->name('government.lop.initiate.create');
    //Route::post('/lop-initiate/store', [GovController::class, 'storeLopInitiate'])->name('government.lop.initiate.store');
    
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
    //Route::get('/lop-initiate', [PrivateController::class, 'lopInitiate'])->name('lop-initiate');
    //Route::get('/lop-initiate/create', [PrivateController::class, 'createLopInitiate'])->name('lop.initiate.create');
    //Route::post('/lop-initiate/store', [PrivateController::class, 'storeLopInitiate'])->name('lop.initiate.store');
    //Route::get('/lop-initiated', [PrivateController::class, 'lopInitiated'])->name('lop-initiated');
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
    //Route::get('/lop-initiate', [SoeController::class, 'lopInitiate'])->name('lop-initiate');
    //Route::get('/lop-initiate/create', [SoeController::class, 'createLopInitiate'])->name('lop.initiate.create');
    //Route::post('/lop-initiate/store', [SoeController::class, 'storeLopInitiate'])->name('lop.initiate.store');
    //Route::get('/lop-initiated', [SoeController::class, 'lopInitiated'])->name('lop-initiated');
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
    //Route::get('/lop-initiate', [SmeController::class, 'lopInitiate'])->name('lop-initiate');
    //Route::get('/lop-initiate/create', [SmeController::class, 'createLopInitiate'])->name('lop.initiate.create');
    //Route::post('/lop-initiate/store', [SmeController::class, 'storeLopInitiate'])->name('lop.initiate.store');
    //Route::get('/lop-initiated', [SmeController::class, 'lopInitiated'])->name('lop-initiated');
    Route::get('/lop-correction', [SmeController::class, 'lopCorrection'])->name('lop-correction');
    
    // Funnel Tracking Update (AJAX)
    Route::post('/funnel/update', [SmeController::class, 'updateFunnelCheckbox'])->name('funnel.update');
    
    // PSAK AJAX
    Route::post('/psak/save', [SmeController::class, 'savePsak'])->name('psak.save');
});

// Collection Routes (Protected)
Route::middleware(['auth'])->prefix('collection')->name('collection.')->group(function () {
    Route::get('/dashboard', [CollectionController::class, 'dashboard'])->name('dashboard');
    Route::get('/c3mr', [CollectionController::class, 'c3mr'])->name('c3mr');
    Route::get('/billing-perdanan', [CollectionController::class, 'billingPerdanan'])->name('billing-perdanan');
    Route::get('/collection-ratio', [CollectionController::class, 'collectionRatio'])->name('collection-ratio');
    Route::get('/cr-gov', [CollectionController::class, 'crGov'])->name('cr-gov');
    Route::get('/cr-private', [CollectionController::class, 'crPrivate'])->name('cr-private');
    Route::get('/cr-sme', [CollectionController::class, 'crSme'])->name('cr-sme');
    Route::get('/cr-soe', [CollectionController::class, 'crSoe'])->name('cr-soe');
    Route::get('/utip', [CollectionController::class, 'utip'])->name('utip');
    Route::get('/utip-new', [CollectionController::class, 'utipNew'])->name('utip-new');
    Route::get('/utip-corrective', [CollectionController::class, 'utipCorrective'])->name('utip-corrective');
    
    // POST Routes for Data Submission
    Route::post('/utip-new/plan/store', [CollectionController::class, 'storeUtipNewPlan'])->name('utip-new.plan.store');
    Route::post('/utip-new/komitmen/store', [CollectionController::class, 'storeUtipNewKomitmen'])->name('utip-new.komitmen.store');
    Route::post('/utip-new/realisasi/store', [CollectionController::class, 'storeUtipNewRealisasi'])->name('utip-new.realisasi.store');
    Route::post('/utip-corrective/plan/store', [CollectionController::class, 'storeUtipCorrectivePlan'])->name('utip-corrective.plan.store');
    Route::post('/utip-corrective/komitmen/store', [CollectionController::class, 'storeUtipCorrectiveKomitmen'])->name('utip-corrective.komitmen.store');
    Route::post('/utip-corrective/realisasi/store', [CollectionController::class, 'storeUtipCorrectiveRealisasi'])->name('utip-corrective.realisasi.store');
});

// Collection Routes - Additional POST routes (without collection prefix for backwards compatibility)
Route::middleware(['auth'])->group(function () {
    Route::post('/cr-gov/komitmen/store', [CollectionController::class, 'storeCrGovKomitmen'])->name('cr-gov.storeKomitmen');
    Route::post('/cr-gov/realisasi/store', [CollectionController::class, 'storeCrGovRealisasi'])->name('cr-gov.storeRealisasi');
    Route::post('/cr-private/komitmen/store', [CollectionController::class, 'storeCrPrivateKomitmen'])->name('cr-private.storeKomitmen');
    Route::post('/cr-private/realisasi/store', [CollectionController::class, 'storeCrPrivateRealisasi'])->name('cr-private.storeRealisasi');
    Route::post('/cr-sme/komitmen/store', [CollectionController::class, 'storeCrSmeKomitmen'])->name('cr-sme.storeKomitmen');
    Route::post('/cr-sme/realisasi/store', [CollectionController::class, 'storeCrSmeRealisasi'])->name('cr-sme.storeRealisasi');
    Route::post('/cr-soe/komitmen/store', [CollectionController::class, 'storeCrSoeKomitmen'])->name('cr-soe.storeKomitmen');
    Route::post('/cr-soe/realisasi/store', [CollectionController::class, 'storeCrSoeRealisasi'])->name('cr-soe.storeRealisasi');
    Route::post('/c3mr/komitmen/store', [CollectionController::class, 'storeC3mrKomitmen'])->name('c3mr.storeKomitmen');
    Route::post('/c3mr/realisasi/store', [CollectionController::class, 'storeC3mrRealisasi'])->name('c3mr.storeRealisasi');
    Route::post('/billing/komitmen/store', [CollectionController::class, 'storeBillingKomitmen'])->name('billing.storeKomitmen');
    Route::post('/billing/realisasi/store', [CollectionController::class, 'storeBillingRealisasi'])->name('billing.storeRealisasi');
});

// CTC Routes (Protected)
Route::middleware(['auth'])->prefix('ctc')->name('ctc.')->group(function () {
    Route::get('/dashboard', [CtcController::class, 'dashboard'])->name('dashboard');
    Route::get('/paid-ct0', [CtcController::class, 'paidCt0'])->name('paid-ct0');
    Route::get('/combat-the-churn', [CtcController::class, 'combatTheChurn'])->name('combat-the-churn');
    Route::get('/combat-churn-ct0', [CtcController::class, 'combatChurnCt0'])->name('combat-churn-ct0');
    Route::get('/combat-churn-sales-hsi', [CtcController::class, 'combatChurnSalesHsi'])->name('combat-churn-sales-hsi');
    Route::get('/combat-churn-churn', [CtcController::class, 'combatChurnChurn'])->name('combat-churn-churn');
    Route::get('/combat-churn-winback', [CtcController::class, 'combatChurnWinback'])->name('combat-churn-winback');
    
    // POST Routes for Data Submission
    Route::post('/paid-ct0/store', [CtcController::class, 'storePaidCt0'])->name('paid-ct0.store');
    Route::post('/combat-the-churn/store', [CtcController::class, 'storeCombatTheChurn'])->name('combat-the-churn.store');
});

// Rising Star Routes (Protected)
Route::middleware(['auth'])->prefix('rising-star')->name('rising-star.')->group(function () {
    Route::get('/dashboard', [RisingStarController::class, 'dashboard'])->name('dashboard');
    Route::get('/rising-star-1', [RisingStarController::class, 'risingStar1'])->name('rising-star-1');
    Route::get('/rising-star-2', [RisingStarController::class, 'risingStar2'])->name('rising-star-2');
    Route::get('/rising-star-3', [RisingStarController::class, 'risingStar3'])->name('rising-star-3');
    Route::get('/rising-star-4', [RisingStarController::class, 'risingStar4'])->name('rising-star-4');
    Route::get('/visiting-gm', [RisingStarController::class, 'visitingGm'])->name('visiting-gm');
    Route::get('/visiting-am', [RisingStarController::class, 'visitingAm'])->name('visiting-am');
    Route::get('/visiting-hotd', [RisingStarController::class, 'visitingHotd'])->name('visiting-hotd');
    Route::get('/profiling-maps-am', [RisingStarController::class, 'profilingMapsAm'])->name('profiling-maps-am');
    Route::get('/profiling-overall-hotd', [RisingStarController::class, 'profilingOverallHotd'])->name('profiling-overall-hotd');
    Route::get('/kecukupan-lop', [RisingStarController::class, 'kecukupanLop'])->name('kecukupan-lop');
    Route::get('/asodomoro-0-3-bulan', [RisingStarController::class, 'asodomoro03Bulan'])->name('asodomoro-0-3-bulan');
    Route::get('/asodomoro-above-3-bulan', [RisingStarController::class, 'asodomoroAbove3Bulan'])->name('asodomoro-above-3-bulan');
    
    // POST Routes for Data Submission
    Route::post('/visiting-gm/store', [RisingStarController::class, 'storeVisitingGm'])->name('visiting-gm.store');
    Route::post('/visiting-am/store', [RisingStarController::class, 'storeVisitingAm'])->name('visiting-am.store');
    Route::post('/visiting-hotd/store', [RisingStarController::class, 'storeVisitingHotd'])->name('visiting-hotd.store');
        Route::delete('/visiting-gm/{id}', [RisingStarController::class, 'deleteVisitingGm'])->name('visiting-gm.delete');
        Route::delete('/visiting-am/{id}', [RisingStarController::class, 'deleteVisitingAm'])->name('visiting-am.delete');
        Route::delete('/visiting-hotd/{id}', [RisingStarController::class, 'deleteVisitingHotd'])->name('visiting-hotd.delete');
    Route::post('/profiling-maps-am/store', [RisingStarController::class, 'storeProfilingMapsAm'])->name('profiling-maps-am.store');
    Route::post('/profiling-overall-hotd/store', [RisingStarController::class, 'storeProfilingOverallHotd'])->name('profiling-overall-hotd.store');
    Route::post('/kecukupan-lop/store', [RisingStarController::class, 'storeKecukupanLop'])->name('kecukupan-lop.store');
        Route::delete('/profiling-maps-am/{id}', [RisingStarController::class, 'deleteProfilingMapsAm'])->name('profiling-maps-am.delete');
        Route::delete('/profiling-overall-hotd/{id}', [RisingStarController::class, 'deleteProfilingOverallHotd'])->name('profiling-overall-hotd.delete');
        Route::delete('/kecukupan-lop/{id}', [RisingStarController::class, 'deleteKecukupanLop'])->name('kecukupan-lop.delete');
    Route::post('/asodomoro/store', [RisingStarController::class, 'storeAsodomoro'])->name('asodomoro.store');
    Route::post('/asodomoro-0-3-bulan/store', [RisingStarController::class, 'storeAsodomoro03Bulan'])->name('asodomoro-0-3-bulan.store');
    Route::post('/asodomoro-above-3-bulan/store', [RisingStarController::class, 'storeAsodomoroAbove3Bulan'])->name('asodomoro-above-3-bulan.store');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Special Programs Dashboard (Collection, CTC, Rising Star)
    Route::get('/admin/special/{role}', [AdminController::class, 'specialDashboard'])->name('admin.special.dashboard');
    
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
    //Route::get('/admin/lop-manage/{entity}/initiate', [AdminController::class, 'lopInitiateManage'])->name('admin.lop.initiate');
    //Route::get('/admin/lop-manage/{entity}/initiate/history', [AdminController::class, 'lopInitiateHistory'])->name('admin.lop.initiate.history');
    //Route::post('/admin/lop-manage/{entity}/initiate/store', [AdminController::class, 'lopInitiateStore'])->name('admin.lop.initiate.store');
    //Route::delete('/admin/lop-manage/{entity}/initiate/{id}', [AdminController::class, 'lopInitiateDelete'])->name('admin.lop.initiate.delete');
    
    // Upload Excel (untuk On Hand, Qualified, Koreksi)
    Route::post('/admin/lop-manage/{entity}/{category}/upload', [AdminController::class, 'uploadLopData'])->name('admin.lop.upload');
    
    // Funnel Tracking
    Route::get('/admin/lop/funnel/{dataType}/{dataId}', [AdminController::class, 'showFunnelForm'])->name('admin.lop.funnel.show');
    Route::post('/admin/lop/funnel/{dataType}/{dataId}', [AdminController::class, 'updateFunnel'])->name('admin.lop.funnel.update');
    
    // Task Progress Update (AJAX)
    Route::post('/admin/task-progress/update', [AdminController::class, 'updateTaskProgress'])->name('admin.task-progress.update');
    
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
