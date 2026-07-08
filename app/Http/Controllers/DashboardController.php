<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Ibu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data untuk Admin
        if ($user->role == 'Admin') {
            $totalBalita = Balita::count();
            $totalIbu = Ibu::count();
            $totalUser = User::count();
            return view('dashboard.admin', compact('totalBalita', 'totalIbu', 'totalUser'));
        }

        // Data untuk Kader
            if ($user->role == 'Kader') {
                $balitas = Balita::with(['ibu', 'posyandu'])
                    ->when($user->posyandu_id, function ($query) use ($user) {
                        return $query->where('posyandu_id', $user->posyandu_id);
                    })->get();
                $totalBalita = $balitas->count();
                $totalIbu = $balitas->pluck('ibu_id')->unique()->count();
                return view('dashboard.kader', compact('balitas', 'totalBalita', 'totalIbu'));
            }


        // Data untuk Ibu
        if ($user->role == 'Ibu') {
            $ibu = $user->ibu;
            $balitas = $ibu ? $ibu->balitas : collect();
            return view('dashboard.ibu', compact('balitas'));
        }

        return view('dashboard.general');
    }
}