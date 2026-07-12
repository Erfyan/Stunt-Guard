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

        // ===== 1. Ambil daftar balita (filter berdasarkan role) =====
        $search = $request->get('search');
        $balitaId = $request->get('id');

        $balitas = Balita::with(['ibu', 'posyandu']);

        // Filter role
        if ($user->role == 'Kader') {
            $balitas->where('posyandu_id', $user->posyandu_id);
        } elseif ($user->role == 'Ibu') {
            $ibu = $user->ibu;
            if ($ibu) {
                $balitas->where('ibu_id', $ibu->id);
            } else {
                $balitas->whereRaw('1 = 0');
            }
        }

        // Filter pencarian
        if ($search) {
            $balitas->where(function ($q) use ($search) {
                $q->where('nama_balita', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $balitas = $balitas->orderBy('nama_balita')->paginate(15);

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