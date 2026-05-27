<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\BuildingMaintenanceController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OutdoorCctvController;
use App\Http\Controllers\ErrorNotifController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware(['auth', 'verified'])->group(function () {

    // ── Semua role ─────────────────────────────────────────────────
    Route::get('/dashboard', [BuildingController::class, 'dashboard'])->name('dashboard');
    Route::get('/monitoring',    [BuildingController::class, 'index'])->name('buildings.monitoring');
    Route::get('/logs', [LogController::class, 'index'])
    ->middleware('role:manajer,superadmin,petugas')
    ->name('logs.index');

    Route::get('/dashboard/monitoring/{building}/maintenance',
        [BuildingMaintenanceController::class, 'show'])
        ->name('dashboard.buildings.maintenance');

    Route::get('/monitoring/{building}/maintenance',
        [BuildingMaintenanceController::class, 'show'])
        ->name('buildings.maintenance');

    Route::post('/maintenance/cctvs/{cctv}/mark-maintenance',
        [BuildingMaintenanceController::class, 'markMaintenance'])
        ->name('maintenance.cctvs.markMaintenance');

    Route::post('/maintenance/cctvs/{cctv}/mark-error',
        [BuildingMaintenanceController::class, 'markError'])
        ->name('maintenance.cctvs.markError');

    // Outdoor — semua role bisa mark maintenance/error
    Route::get('/outdoor-cctvs',
        [OutdoorCctvController::class, 'index'])
        ->name('outdoor.cctvs.index');

    Route::post('/outdoor-cctvs/{cctv}/mark-maintenance',   // ← ganti outdoorCctv → cctv
        [OutdoorCctvController::class, 'markMaintenance'])
        ->name('outdoor.cctvs.markMaintenance');

    Route::post('/outdoor-cctvs/{cctv}/mark-error',         // ← ganti outdoorCctv → cctv
        [OutdoorCctvController::class, 'markError'])
        ->name('outdoor.cctvs.markError');

    Route::get('/api/active-errors', [\App\Http\Controllers\ErrorNotifController::class, 'index'])
    ->middleware('auth')
    ->name('api.active.errors');
    Route::post('/api/cctvs/{cctv}/acknowledge-error',
    [\App\Http\Controllers\ErrorNotifController::class, 'acknowledge'])
    ->middleware('auth')
    ->name('api.cctvs.acknowledge');

    Route::get('/logs/export', [LogController::class, 'export'])->name('logs.export');
    // web.php — tambahkan di dalam middleware auth
    Route::get('/api/cctv-stream', [\App\Http\Controllers\CctvSseController::class, 'stream'])
    ->name('api.cctv.stream');

    // ── Manajer & Superadmin saja ──────────────────────────────────
    Route::middleware('role:manajer,superadmin')->group(function () {

        Route::post('/monitoring',               [BuildingController::class, 'store'])->name('buildings.store');
        Route::put('/monitoring/{building}',     [BuildingController::class, 'update'])->name('buildings.update');
        Route::delete('/monitoring/{building}',  [BuildingController::class, 'destroy'])->name('buildings.destroy');

        Route::post('/maintenance/floors/{floor}/cctvs',
            [BuildingMaintenanceController::class, 'storeCctv'])
            ->name('maintenance.cctvs.store');

        Route::delete('/maintenance/cctvs/{cctv}',
            [BuildingMaintenanceController::class, 'destroyCctv'])
            ->name('maintenance.cctvs.destroy');

        Route::patch('/maintenance/cctvs/{cctv}',
            [BuildingMaintenanceController::class, 'updateCctvInfo'])
            ->name('maintenance.cctvs.update');

        

        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);

        // Outdoor — tambah & hapus hanya manajer/superadmin
        Route::post('/outdoor-cctvs',
            [OutdoorCctvController::class, 'store'])
            ->name('outdoor.cctvs.store');

        Route::delete('/outdoor-cctvs/{cctv}',               // ← ganti outdoorCctv → cctv
            [OutdoorCctvController::class, 'destroy'])
            ->name('outdoor.cctvs.destroy');
    });
    // ── Superadmin saja ────────────────────────────────────────
Route::middleware('role:superadmin')->group(function () {
    Route::get('/settings',              [\App\Http\Controllers\SettingController::class, 'index'])
        ->name('settings.index');
    Route::put('/settings/threshold',    [\App\Http\Controllers\SettingController::class, 'updateThreshold'])
        ->name('settings.threshold');
    Route::put('/settings/profile',      [\App\Http\Controllers\SettingController::class, 'updateProfile'])
        ->name('settings.profile');
        Route::put('/settings/colors', [\App\Http\Controllers\SettingController::class, 'updateColors'])
    ->name('settings.colors');
    Route::put('/settings/ack-reset', [\App\Http\Controllers\SettingController::class, 'updateAckReset'])
    ->name('settings.ack_reset');
});
});

Route::post('/avatar/update',   [UserController::class, 'updateAvatar'])->name('avatar.update');
Route::delete('/avatar/delete', [UserController::class, 'deleteAvatar'])->name('avatar.delete');

require __DIR__.'/auth.php';