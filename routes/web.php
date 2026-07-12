<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\KmsController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // ==============================
    // DASHBOARD
    // ==============================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==============================
    // PROFILE (hanya Admin)
    // ==============================
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    });

    // ==============================
    // BALITA (CRUD & Export)
    // ==============================
    Route::get('/balita/export-pdf', [BalitaController::class, 'exportPDF'])
        ->middleware('role:Admin,Kader')
        ->name('balita.exportPDF');

    Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index');
    Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
    Route::post('/balita', [BalitaController::class, 'store'])->name('balita.store');
    Route::get('/balita/{id}', [BalitaController::class, 'show'])->name('balita.show');
    Route::get('/balita/{id}/edit', [BalitaController::class, 'edit'])->name('balita.edit');
    Route::put('/balita/{id}', [BalitaController::class, 'update'])->name('balita.update');
    Route::delete('/balita/{id}', [BalitaController::class, 'destroy'])->name('balita.destroy');

    // ==============================
    // IBU (CRUD & Export)
    // ==============================
    Route::get('/ibu/export-pdf', [IbuController::class, 'exportPDF'])
        ->middleware('role:Admin,Kader')
        ->name('ibu.exportPDF');

    Route::get('/ibu', [IbuController::class, 'index'])->name('ibu.index');
    Route::get('/ibu/create', [IbuController::class, 'create'])->name('ibu.create');
    Route::post('/ibu', [IbuController::class, 'store'])->name('ibu.store');
    Route::get('/ibu/{id}', [IbuController::class, 'show'])->name('ibu.show');
    Route::get('/ibu/{id}/edit', [IbuController::class, 'edit'])->name('ibu.edit');
    Route::put('/ibu/{id}', [IbuController::class, 'update'])->name('ibu.update');
    Route::delete('/ibu/{id}', [IbuController::class, 'destroy'])->name('ibu.destroy');

    // ==============================
    // PEMERIKSAAN (hanya Kader)
    // ==============================
    Route::get('/pemeriksaan/create/{balita?}', [PemeriksaanController::class, 'create'])
        ->middleware('role:Kader')
        ->name('pemeriksaan.create');
    Route::post('/pemeriksaan', [PemeriksaanController::class, 'store'])
        ->middleware('role:Kader')
        ->name('pemeriksaan.store');
    Route::post('/pemeriksaan/detect', [PemeriksaanController::class, 'detect'])
        ->middleware('role:Kader')
        ->name('pemeriksaan.detect');

    // ==============================
    // KMS CHARTS (Admin & Kader)
    // ==============================
    Route::get('/kms', [KmsController::class, 'index'])
        ->middleware('role:Admin,Kader')
        ->name('kms.index');
    Route::get('/kms/{id}', [KmsController::class, 'show'])
        ->middleware('role:Admin,Kader')
        ->name('kms.show');

    // ==============================
    // LAPORAN (Admin & Kader)
    // ==============================
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPDF'])
        ->middleware('role:Admin,Kader')
        ->name('laporan.exportPDF');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])
        ->middleware('role:Admin,Kader')
        ->name('laporan.exportExcel');
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('role:Admin,Kader')
        ->name('laporan.index');

    Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

    // ==============================
    // MANAJEMEN USER (hanya Admin)
    // ==============================
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('user', UserController::class);
    });
});

require __DIR__.'/auth.php';