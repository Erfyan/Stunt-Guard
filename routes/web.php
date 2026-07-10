<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:Admin,Kader')
        ->name('dashboard');
    // Update Password
    Route::put('/password', [PasswordController::class, 'update'])
    ->middleware('role:Admin') // Sesuai permintaan: hanya Admin
    ->name('password.update');
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('role:Admin')
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('role:Admin')
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('role:Admin')
        ->name('profile.destroy');
    // Ekspor PDF (diletakkan di atas agar tidak tertangkap oleh {id})
    Route::get('/balita/export-pdf', [BalitaController::class, 'exportPDF'])
        ->middleware('role:Admin,Kader')
        ->name('balita.exportPDF');
        
        Route::get('/ibu/export-pdf', [IbuController::class, 'exportPDF'])
        ->middleware('role:Admin,Kader')
        ->name('ibu.exportPDF');
        
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPDF'])
            ->middleware('role:Admin,Kader')
            ->name('laporan.exportPDF');
    // Resource Balita & Ibu (Sprint 2)
    // ========== ROUTE MANUAL BALITA ==========
    Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index');
    Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
    Route::post('/balita', [BalitaController::class, 'store'])->name('balita.store');
    Route::get('/balita/{id}', [BalitaController::class, 'show'])->name('balita.show');
    Route::get('/balita/{id}/edit', [BalitaController::class, 'edit'])->name('balita.edit');
    Route::put('/balita/{id}', [BalitaController::class, 'update'])->name('balita.update');
    Route::delete('/balita/{id}', [BalitaController::class, 'destroy'])->name('balita.destroy');

    // ========== ROUTE MANUAL IBU ==========
    Route::get('/ibu', [IbuController::class, 'index'])->name('ibu.index');
    Route::get('/ibu/create', [IbuController::class, 'create'])->name('ibu.create');
    Route::post('/ibu', [IbuController::class, 'store'])->name('ibu.store');
    Route::get('/ibu/{id}', [IbuController::class, 'show'])->name('ibu.show');
    Route::get('/ibu/{id}/edit', [IbuController::class, 'edit'])->name('ibu.edit');
    Route::put('/ibu/{id}', [IbuController::class, 'update'])->name('ibu.update');
    Route::delete('/ibu/{id}', [IbuController::class, 'destroy'])->name('ibu.destroy');
    
    // Profile (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Input Pemeriksaan 
    Route::get('/pemeriksaan/create/{balita?}', [PemeriksaanController::class, 'create'])
        ->middleware('role:Kader')
        ->name('pemeriksaan.create');
    Route::post('/pemeriksaan', [PemeriksaanController::class, 'store'])
        ->middleware('role:Kader')
        ->name('pemeriksaan.store');
    Route::post('/pemeriksaan/detect', [PemeriksaanController::class, 'detect'])
        ->middleware('role:Kader')
        ->name('pemeriksaan.detect');

    // Grafik KMS 
    Route::get('/kms', function () {
        return view('coming-soon', ['title' => 'Grafik KMS']);
    })->name('kms.index');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('role:Admin,Kader')
        ->name('laporan.index');


    // Manajemen User 
    Route::get('/user', function () {
        return view('coming-soon', ['title' => 'Manajemen User']);
    })->middleware('role:Admin')->name('user.index');
});

require __DIR__.'/auth.php';