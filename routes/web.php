<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin2Controller;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScallingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GovController;
use App\Http\Controllers\PrivateController;
use App\Http\Controllers\CollectionController;

Route::get('/', function () {
    return redirect()->route('auth.login.form');
});
// Public routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');

    // Home redirect
    // Route::get('/', function () {
    //     return redirect('/admin');
    // });

    // Admin routes (role: admin)
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        // Colection Ratio routes
        Route::get('/collection-ratio', [AdminController::class, 'collectionRatioTable'])->name('admin.collection-ratio');
        Route::post('/collection-ratio', [AdminController::class, 'collectionRatioStore'])->name('admin.collection-ratio.store');

        // toggle status helper (used by tables)
        Route::patch('/collection/{id}/status', [AdminController::class, 'toggleCollectionStatus'])
            ->name('admin.collection.toggleStatus');

        // C3MR routes
        Route::get('/c3mr', [AdminController::class, 'c3mrTable'])->name('admin.c3mr');
        Route::post('/c3mr', [AdminController::class, 'c3mrStore'])->name('admin.c3mr.store');

        // Billing Perdana routes
        Route::get('/billing', [AdminController::class, 'billingTable'])->name('admin.billing');
        Route::post('/billing', [AdminController::class, 'billingStore'])->name('admin.billing.store');

        // UTIP routes
        Route::get('/utip', [AdminController::class, 'utipTable'])->name('admin.utip');
        Route::post('/utip', [AdminController::class, 'utipStore'])->name('admin.utip.store');

        // CTC routes
        Route::get('/ctc', [AdminController::class, 'ctcTable'])->name('admin.ctc');
        Route::post('/ctc', [AdminController::class, 'ctcStore'])->name('admin.ctc.store');

        // CT0 routes
        Route::get('/ct0', [AdminController::class, 'ct0Table'])->name('admin.ct0');
        Route::post('/ct0', [AdminController::class, 'ct0Store'])->name('admin.ct0.store');

        // PSAK routes
        Route::get('/psak/gov', [AdminController::class, 'psakGov'])->name('admin.psak.gov');
        Route::get('/psak/soe', [AdminController::class, 'psakSoe'])->name('admin.psak.soe');
        Route::get('/psak/sme', [AdminController::class, 'psakSme'])->name('admin.psak.sme');
        Route::get('/psak/private', [AdminController::class, 'psakPrivate'])->name('admin.psak.private');
        Route::post('/psak/gov', [AdminController::class, 'psakGovStore'])->name('admin.psak.gov.store');
        Route::post('/psak/soe', [AdminController::class, 'psakSoeStore'])->name('admin.psak.soe.store');
        Route::post('/psak/sme', [AdminController::class, 'psakSmeStore'])->name('admin.psak.sme.store');
        Route::post('/psak/private', [AdminController::class, 'psakPrivateStore'])->name('admin.psak.private.store');

        // Rising Star routes
        Route::get('/rising-star1', [Admin2Controller::class, 'risingStar1Table'])->name('admin.rising-star1');
        Route::get('/rising-star2', [Admin2Controller::class, 'risingStar2Table'])->name('admin.rising-star2');
        Route::get('/rising-star3', [Admin2Controller::class, 'risingStar3Table'])->name('admin.rising-star3');
        Route::get('/rising-star4', [Admin2Controller::class, 'risingStar4Table'])->name('admin.rising-star4');
        Route::post('/rising-star', [Admin2Controller::class, 'risingStarStore'])->name('admin.rising-star.store');

        // Hsi Agency routes
        Route::get('/hsi-agency', [Admin2Controller::class, 'hsiTable'])->name('admin.hsi-agency');
        Route::post('/hsi-agency', [Admin2Controller::class, 'hsiStore'])->name('admin.hsi-agency.store');

        // Telda routes
        Route::get('/admin/telda', [Admin2Controller::class, 'teldaTable'])->name('admin.telda.index');
        Route::post('/admin/telda', [Admin2Controller::class, 'teldaStore'])->name('admin.telda.store');

        // Scalling routes
        Route::get('/scalling/gov', [ScallingController::class, 'indexGov'])->name('admin.scalling.gov');
        Route::get('/scalling/soe', [ScallingController::class, 'indexSoe'])->name('admin.scalling.soe');
        Route::get('/scalling/sme', [ScallingController::class, 'indexSme'])->name('admin.scalling.sme');
        Route::get('/scalling/private', [ScallingController::class, 'indexPrivate'])->name('admin.scalling.private');

        // Governtment dashboard (role: gov) - admin access
        // on-hand upload listing and actions
        Route::get('/scalling/gov/on-hand', [ScallingController::class, 'onHandGov'])->name('admin.scalling.gov.on-hand');
        Route::post('/scalling/gov/on-hand', [ScallingController::class, 'import'])->name('admin.scalling.gov.on-hand.store');
        Route::get('/scalling/gov/on-hand/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.gov.on-hand.show');
        Route::delete('/scalling/gov/on-hand/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.gov.on-hand.destroy');

        // koreksi upload listing and actions
        Route::get('/scalling/gov/koreksi', [ScallingController::class, 'koreksiGov'])->name('admin.scalling.gov.koreksi');
        Route::post('/scalling/gov/koreksi', [ScallingController::class, 'import'])->name('admin.scalling.gov.koreksi.store');
        Route::get('/scalling/gov/koreksi/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.gov.koreksi.show');
        Route::delete('/scalling/gov/koreksi/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.gov.koreksi.destroy');

        // qualified upload listing and actions
        Route::get('/scalling/gov/qualified', [ScallingController::class, 'qualifiedGov'])->name('admin.scalling.gov.qualified');
        Route::post('/scalling/gov/qualified', [ScallingController::class, 'import'])->name('admin.scalling.gov.qualified.store');
        Route::get('/scalling/gov/qualified/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.gov.qualified.show');
        Route::delete('/scalling/gov/qualified/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.gov.qualified.destroy');

        // Private dashboard (role: private) - admin access
        // on-hand upload listing and actions
        Route::get('/scalling/private/on-hand', [ScallingController::class, 'onHandPrivate'])->name('admin.scalling.private.on-hand');
        Route::post('/scalling/private/on-hand', [ScallingController::class, 'import'])->name('admin.scalling.private.on-hand.store');
        Route::get('/scalling/private/on-hand/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.private.on-hand.show');
        Route::delete('/scalling/private/on-hand/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.private.on-hand.destroy');

        // koreksi upload listing and actions
        Route::get('/scalling/private/koreksi', [ScallingController::class, 'koreksiPrivate'])->name('admin.scalling.private.koreksi');
        Route::post('/scalling/private/koreksi', [ScallingController::class, 'import'])->name('admin.scalling.private.koreksi.store');
        Route::get('/scalling/private/koreksi/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.private.koreksi.show');
        Route::delete('/scalling/private/koreksi/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.private.koreksi.destroy');

        // qualified upload listing and actions
        Route::get('/scalling/private/qualified', [ScallingController::class, 'qualifiedPrivate'])->name('admin.scalling.private.qualified');
        Route::post('/scalling/private/qualified', [ScallingController::class, 'import'])->name('admin.scalling.private.qualified.store');
        Route::get('/scalling/private/qualified/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.private.qualified.show');
        Route::delete('/scalling/private/qualified/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.private.qualified.destroy');

        // SOE dashboard (role: soe) - admin access
        // on-hand upload listing and actions
        Route::get('/scalling/soe/on-hand', [ScallingController::class, 'onHandSoe'])->name('admin.scalling.soe.on-hand');
        Route::post('/scalling/soe/on-hand', [ScallingController::class, 'import'])->name('admin.scalling.soe.on-hand.store');
        Route::get('/scalling/soe/on-hand/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.soe.on-hand.show');
        Route::delete('/scalling/soe/on-hand/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.soe.on-hand.destroy');

        // koreksi upload listing and actions
        Route::get('/scalling/soe/koreksi', [ScallingController::class, 'koreksiSoe'])->name('admin.scalling.soe.koreksi');
        Route::post('/scalling/soe/koreksi', [ScallingController::class, 'import'])->name('admin.scalling.soe.koreksi.store');
        Route::get('/scalling/soe/koreksi/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.soe.koreksi.show');
        Route::delete('/scalling/soe/koreksi/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.soe.koreksi.destroy');

        // qualified upload listing and actions
        Route::get('/scalling/soe/qualified', [ScallingController::class, 'qualifiedSoe'])->name('admin.scalling.soe.qualified');
        Route::post('/scalling/soe/qualified', [ScallingController::class, 'import'])->name('admin.scalling.soe.qualified.store');
        Route::get('/scalling/soe/qualified/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.soe.qualified.show');
        Route::delete('/scalling/soe/qualified/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.soe.qualified.destroy');

        // SME dashboard (role: sme) - admin access
        // on-hand upload listing and actions
        Route::get('/scalling/sme/on-hand', [ScallingController::class, 'onHandSme'])->name('admin.scalling.sme.on-hand');
        Route::post('/scalling/sme/on-hand', [ScallingController::class, 'import'])->name('admin.scalling.sme.on-hand.store');
        Route::get('/scalling/sme/on-hand/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.sme.on-hand.show');
        Route::delete('/scalling/sme/on-hand/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.sme.on-hand.destroy');

        // koreksi upload listing and actions
        Route::get('/scalling/sme/koreksi', [ScallingController::class, 'koreksiSme'])->name('admin.scalling.sme.koreksi');
        Route::post('/scalling/sme/koreksi', [ScallingController::class, 'import'])->name('admin.scalling.sme.koreksi.store');
        Route::get('/scalling/sme/koreksi/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.sme.koreksi.show');
        Route::delete('/scalling/sme/koreksi/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.sme.koreksi.destroy');

        // qualified upload listing and actions
        Route::get('/scalling/sme/qualified', [ScallingController::class, 'qualifiedSme'])->name('admin.scalling.sme.qualified');
        Route::post('/scalling/sme/qualified', [ScallingController::class, 'import'])->name('admin.scalling.sme.qualified.store');
        Route::get('/scalling/sme/qualified/{scallingImport}', [ScallingController::class, 'show'])->name('admin.scalling.sme.qualified.show');
        Route::delete('/scalling/sme/qualified/{scallingImport}', [ScallingController::class, 'destroy'])->name('admin.scalling.sme.qualified.destroy');
        
    });

    // Government dashboard (role: gov)
    Route::middleware('role:gov')->prefix('dashboard/gov')->group(function () {
        // Route::get('/', function () {
        //     return view('dashboard.gov.index');
        // })->name('dashboard.gov');

        Route::get('/', [GovController::class, 'scalling'])->name('dashboard.gov');
        Route::get('/scalling/on-hand', [GovController::class, 'lopOnHand'])->name('dashboard.gov.lop-on-hand');
        Route::get('/scalling/koreksi', [GovController::class, 'lopKoreksi'])->name('dashboard.gov.lop-koreksi');
        Route::get('/scalling/qualified', [GovController::class, 'lopQualified'])->name('dashboard.gov.lop-qualified');
        Route::post('/funnel/update', [GovController::class, 'updateFunnelCheckbox'])->name('funnel.update');

        Route::get('/aosodomoro/above-3-bulan', [GovController::class, 'aosodomoroAbove3Bulan'])->name('dashboard.gov.aosodomoro-above-3-bulan');
        Route::post('/aosodomoro/above-3-bulan', [GovController::class, 'storeAosodomoroAbove3Bulan'])->name('dashboard.gov.aosodomoro-above-3-bulan.store');

        Route::get('/aosodomoro/0-3-bulan', [GovController::class, 'aosodomoro03Bulan'])->name('dashboard.gov.aosodomoro-0-3-bulan');
        Route::post('/aosodomoro/0-3-bulan', [GovController::class, 'storeAosodomoro03Bulan'])->name('dashboard.gov.aosodomoro-0-3-bulan.store');
    });

    // SOE dashboard (role: soe)
    Route::middleware('role:soe')->prefix('dashboard/soe')->group(function () {
        Route::get('/', function () {
            return view('dashboard.soe.index');
        })->name('dashboard.soe');
    });

    // SME dashboard (role: sme)
    Route::middleware('role:sme')->prefix('dashboard/sme')->group(function () {
        Route::get('/', function () {
            return view('dashboard.sme.index');
        })->name('dashboard.sme');
    });

    // Private dashboard (role: private)
    Route::middleware('role:private')->prefix('dashboard/private')->group(function () {
        // Route::get('/', function () {
        //     return view('dashboard.private.index');
        // })->name('dashboard.private');

        Route::get('/', [PrivateController::class, 'scalling'])->name('dashboard.private');
        Route::get('/scalling/on-hand', [PrivateController::class, 'lopOnHand'])->name('dashboard.private.lop-on-hand');
        Route::get('/scalling/koreksi', [PrivateController::class, 'lopKoreksi'])->name('dashboard.private.lop-koreksi');
        Route::get('/scalling/qualified', [PrivateController::class, 'lopQualified'])->name('dashboard.private.lop-qualified');
        Route::post('/funnel/update', [PrivateController::class, 'updateFunnelCheckbox'])->name('funnel.update');
    });

    // Collection dashboard (role: collection)
    Route::middleware('role:collection')->prefix('dashboard')->group(function () {
        Route::get('/', function () {
            return view('dashboard.collection.index');
        })->name('dashboard.collection');
        Route::get('/collection/c3mr', [CollectionController::class, 'c3mr'])->name('collection.c3mr');
        Route::post('/collection/c3mr', [CollectionController::class, 'storeC3mrRealisasi'])->name('collection.c3mr.storeRealisasi');
        Route::get('/collection/billing', [CollectionController::class, 'billing'])->name('collection.billing');
        Route::post('/collection/billing', [CollectionController::class, 'storeBillingRealisasi'])->name('collection.billing.storeRealisasi');
        Route::get('/collection/utip', [CollectionController::class, 'utip'])->name('collection.utip');
        Route::post('/collection/utip', [CollectionController::class, 'storeUtipRealisasi'])->name('collection.utip.storeRealisasi');
        Route::get('/collection/cr', [CollectionController::class, 'cr'])->name('collection.cr');
        Route::post('/collection/cr', [CollectionController::class, 'storeCrRealisasi'])->name('collection.cr.storeRealisasi');
    });

    // CTC dashboard (role: ctc)
    Route::middleware('role:ctc')->prefix('dashboard/ctc')->group(function () {
        Route::get('/', function () {
            return view('dashboard.ctc.index');
        })->name('dashboard.ctc');
    });

    // Rising Star dashboard (role: risingStar)
    Route::middleware('role:risingStar')->prefix('dashboard/rising-star')->group(function () {
        Route::get('/', function () {
            return view('dashboard.risingstar.index');
        })->name('dashboard.rising-star');
    });
});
