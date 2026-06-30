<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // Halaman landing sederhana
});

// Bungkus semua route yang butuh login dengan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route bawaan Breeze untuk login/register (jangan dihapus)
require __DIR__.'/auth.php';