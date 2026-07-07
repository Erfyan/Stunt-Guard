<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Ibu;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'Admin') {
            $totalBalita = Balita::count();
            $totalIbu = Ibu::count();
            return view('dashboard.admin', compact('totalBalita', 'totalIbu'));
        }

        if ($user->role == 'Kader') {
            // Kader melihat semua balita (karena belum ada relasi posyandu di user, kita tampilkan semua)
            $balitas = Balita::with('ibu.user')->get();
            return view('dashboard.kader', compact('balitas'));
        }

        if ($user->role == 'Ibu') {
            // Ibu melihat anaknya sendiri
            $ibu = $user->ibu; // Relasi dari User ke Ibu
            $balitas = $ibu ? $ibu->balitas : collect();
            return view('dashboard.ibu', compact('balitas'));
        }

        // default
        return view('dashboard.general');
    }
}