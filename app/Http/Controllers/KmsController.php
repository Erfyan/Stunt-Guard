<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KmsController extends Controller
{
    /**
     * Halaman utama KMS (daftar balita + grafik jika ada id)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Jika user tidak login (seharusnya tidak terjadi karena middleware)
        if (!$user) {
            return redirect()->route('login');
        }

        // ===== 1. Ambil daftar balita (filter berdasarkan role) =====
        $search = $request->get('search');
        $balitaId = $request->get('id');

        // Query dasar
        $balitasQuery = Balita::with(['ibu', 'posyandu']);

        // Filter berdasarkan role
        if ($user->role == 'Kader') {
            // Kader hanya melihat balita di posyandunya
            if ($user->posyandu_id) {
                $balitasQuery->where('posyandu_id', $user->posyandu_id);
            } else {
                // Jika kader tidak memiliki posyandu, tampilkan kosong
                $balitasQuery->whereRaw('1 = 0');
            }
        } elseif ($user->role == 'Ibu') {
            // Ibu hanya melihat anaknya sendiri
            $ibu = $user->ibu;
            if ($ibu) {
                $balitasQuery->where('ibu_id', $ibu->id);
            } else {
                $balitasQuery->whereRaw('1 = 0');
            }
        }
        // Admin dan Petugas tidak difilter, melihat semua

        // Filter pencarian (jika ada)
        if ($search) {
            $balitasQuery->where(function ($q) use ($search) {
                $q->where('nama_balita', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Eksekusi query dengan pagination
        $balitas = $balitasQuery->orderBy('nama_balita')->paginate(15);

        // ===== 2. Jika ada parameter id, ambil data balita untuk grafik =====
        $balita = null;
        $chartLabels = [];
        $chartBB = [];
        $chartTB = [];
        $chartUmur = [];
        $chartZscore = [];

        if ($balitaId) {
            $balita = Balita::with([
                'ibu',
                'posyandu',
                'pemeriksaans' => function ($q) {
                    $q->orderBy('tanggal', 'asc');
                }
            ])->find($balitaId);

            if ($balita) {
                // Siapkan data untuk Chart.js
                $chartLabels = $balita->pemeriksaans->map(function ($item) {
                    return $item->tanggal->format('d/m/Y');
                })->toArray();

                $chartBB = $balita->pemeriksaans->pluck('berat_badan')->toArray();
                $chartTB = $balita->pemeriksaans->pluck('tinggi_badan')->toArray();
                $chartUmur = $balita->pemeriksaans->pluck('umur_bulan')->toArray();
                $chartZscore = $balita->pemeriksaans->pluck('zscore')->toArray();
            }
        }

        // ===== 3. Kirim ke view =====
        return view('kms.index', compact(
            'balitas',
            'balita',
            'chartLabels',
            'chartBB',
            'chartTB',
            'chartUmur',
            'chartZscore'
        ));
    }

    /**
     * Redirect ke halaman index dengan parameter id
     */
    public function show($id)
    {
        return redirect()->route('kms.index', ['id' => $id]);
    }
}