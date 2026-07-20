<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Ibu;
use App\Models\Posyandu;
use App\Models\User;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ========== ADMIN ==========
        if ($user->role == 'Admin') {
            $totalBalita = Balita::count();
            $totalIbu = Ibu::count();
            $totalUser = User::count();
            $balitas = Balita::with(['ibu', 'posyandu'])
                ->latest()
                ->limit(10)
                ->get();

            // Compute Posyandu activity statistics
            $posyanduStats = Posyandu::with(['balitas' => function($q) {
                    $q->with(['pemeriksaans' => function($q2) {
                        $q2->latest()->limit(1);
                    }]);
                }])
                ->get()
                ->map(function($p) {
                    $total = $p->balitas->count();
                    $stunted = $p->balitas->filter(function($b) {
                        $last = $b->pemeriksaans->first();
                        return $last && in_array($last->status_stunting, ['Stunted', 'Severely Stunted']);
                    })->count();
                    $percent = $total ? round(($stunted / $total) * 100) : 0;
                    return [
                        'nama' => $p->nama_posyandu,
                        'total' => $total,
                        'stunted_percent' => $percent,
                    ];
                })
                ->toArray();

            return view('dashboard.admin', compact('totalBalita', 'totalIbu', 'totalUser', 'balitas', 'posyanduStats'));
        }

        // ========== KADER ==========
        if ($user->role == 'Kader') {
            // Ambil balita di posyandu kader
            $balitas = Balita::with(['ibu', 'posyandu', 'pemeriksaans' => function($q) {
                $q->latest()->limit(1);
            }])
            ->when($user->posyandu_id, function ($query) use ($user) {
                return $query->where('posyandu_id', $user->posyandu_id);
            })
            ->get();

            $totalBalita = $balitas->count();

            // Statistik status gizi terakhir
            $stunting = 0;
            $normal = 0;
            $underweight = 0;
            $wasting = 0;
            $risiko = 0;

            foreach ($balitas as $b) {
                $last = $b->pemeriksaans->first();
                if ($last) {
                    if (in_array($last->status_stunting, ['Stunted', 'Severely Stunted'])) {
                        $stunting++;
                    } elseif ($last->status_gizi == 'Normal') {
                        $normal++;
                    } elseif (in_array($last->status_gizi, ['Underweight', 'Severely Underweight'])) {
                        $underweight++;
                    } elseif (in_array($last->status_gizi, ['Wasting', 'Severely Wasted'])) {
                        $wasting++;
                    }
                }
            }

            // Data untuk grafik tren (6 bulan terakhir)
            $trenData = Pemeriksaan::select(
                    DB::raw('MONTH(tanggal) as bulan'),
                    DB::raw('YEAR(tanggal) as tahun'),
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN status_stunting IN ("Stunted", "Severely Stunted") THEN 1 ELSE 0 END) as stunting')
                )
                ->whereHas('balita', function($q) use ($user) {
                    $q->when($user->posyandu_id, function($q2) use ($user) {
                        $q2->where('posyandu_id', $user->posyandu_id);
                    });
                })
                ->where('tanggal', '>=', Carbon::now()->subMonths(6))
                ->groupBy('tahun', 'bulan')
                ->orderBy('tahun')
                ->orderBy('bulan')
                ->get();

            $chartLabels = $trenData->map(function($item) {
                return Carbon::create()->month($item->bulan)->year($item->tahun)->format('M Y');
            })->toArray();

            $chartData = $trenData->pluck('stunting')->toArray();

            // Peringatan: anak dengan Z-Score < -3 SD
            $peringatan = Balita::whereHas('pemeriksaans', function($q) {
                $q->where('zscore', '<', -3)->latest();
            })
            ->when($user->posyandu_id, function($q) use ($user) {
                $q->where('posyandu_id', $user->posyandu_id);
            })
            ->with(['ibu', 'pemeriksaans' => function($q) {
                $q->latest()->limit(1);
            }])
            ->limit(5)
            ->get();

            return view('dashboard.kader', compact(
                'balitas', 'totalBalita', 'stunting', 'normal', 
                'underweight', 'wasting', 'chartLabels', 'chartData', 'peringatan'
            ));
        }

        // ========== PUSKESMAS ==========
        if ($user->role == 'Petugas' || $user->role == 'Puskesmas') {
            // Agregat per posyandu
            $posyandus = Posyandu::with(['balitas' => function($q) {
                $q->with(['pemeriksaans' => function($q2) {
                    $q2->latest()->limit(1);
                }]);
            }])->get();

            $dataPosyandu = $posyandus->map(function($p) {
                $total = $p->balitas->count();
                $stunting = $p->balitas->filter(function($b) {
                    $last = $b->pemeriksaans->first();
                    return $last && in_array($last->status_stunting, ['Stunted', 'Severely Stunted']);
                })->count();
                $normal = $p->balitas->filter(function($b) {
                    $last = $b->pemeriksaans->first();
                    return $last && $last->status_gizi == 'Normal';
                })->count();
                return [
                    'nama' => $p->nama_posyandu,
                    'total' => $total,
                    'stunting' => $stunting,
                    'normal' => $normal,
                ];
            });

            // Total seluruh
            $totalBalita = Balita::count();
            $totalStunting = Balita::whereHas('pemeriksaans', function($q) {
                $q->whereIn('status_stunting', ['Stunted', 'Severely Stunted'])->latest();
            })->count();

            return view('dashboard.puskesmas', compact('dataPosyandu', 'totalBalita', 'totalStunting'));
        }

        // ========== DINAS KESEHATAN ==========
        if ($user->role == 'Dinas') {
            // Agregat per kecamatan
            $dataKecamatan = DB::table('posyandus')
                ->join('balitas', 'posyandus.id', '=', 'balitas.posyandu_id')
                ->leftJoin('pemeriksaans', function($join) {
                    $join->on('balitas.id', '=', 'pemeriksaans.balita_id')
                         ->whereRaw('pemeriksaans.created_at = (SELECT MAX(created_at) FROM pemeriksaans WHERE balita_id = balitas.id)');
                })
                ->select(
                    'posyandus.kecamatan',
                    DB::raw('COUNT(DISTINCT balitas.id) as total_balita'),
                    DB::raw('SUM(CASE WHEN pemeriksaans.status_stunting IN ("Stunted", "Severely Stunted") THEN 1 ELSE 0 END) as stunting')
                )
                ->groupBy('posyandus.kecamatan')
                ->get();

            return view('dashboard.dinas', compact('dataKecamatan'));
        }

        // ========== IBU (Orang Tua) ==========
        if ($user->role == 'Ibu') {
            $ibu = $user->ibu;
            $balitas = $ibu ? $ibu->balitas()->with(['pemeriksaans' => function($q) {
                $q->latest()->limit(1);
            }])->get() : collect();

            return view('dashboard.ibu', compact('balitas'));
        }

        return view('dashboard.general');
    }
}