<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:Admin,Kader')
        ->name('dashboard');

    // Resource Balita & Ibu (Sprint 2)
    // ===== ROUTE MANUAL BALITA =====
    Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index');
    Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
    Route::post('/balita', [BalitaController::class, 'store'])->name('balita.store');
    Route::get('/balita/{id}', [BalitaController::class, 'show'])->name('balita.show');
    Route::get('/balita/{id}/edit', [BalitaController::class, 'edit'])->name('balita.edit');
    Route::put('/balita/{id}', [BalitaController::class, 'update'])->name('balita.update');
    Route::delete('/balita/{id}', [BalitaController::class, 'destroy'])->name('balita.destroy');
    Route::resource('ibu', IbuController::class);

    // Profile (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========== ROUTE UNTUK SPRINT 3, 4, 5 (SEMENTARA) ==========

    // Input Pemeriksaan (Sprint 3)
    Route::get('/pemeriksaan/create', function () {
        return view('coming-soon', ['title' => 'Input Pemeriksaan']);
    })->middleware('role:Kader')->name('pemeriksaan.create');

    // Grafik KMS (Sprint 4)
    Route::get('/kms', function () {
        return view('coming-soon', ['title' => 'Grafik KMS']);
    })->name('kms.index');

    // Laporan (Sprint 5)
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('role:Admin,Kader')
        ->name('laporan.index');

    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPDF'])
        ->middleware('role:Admin,Kader')
        ->name('laporan.exportPDF');
    // Manajemen User (Sprint 5)
    Route::get('/user', function () {
        return view('coming-soon', ['title' => 'Manajemen User']);
    })->middleware('role:Admin')->name('user.index');
});

require __DIR__.'/auth.php';