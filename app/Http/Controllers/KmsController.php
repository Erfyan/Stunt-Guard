<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use Illuminate\Http\Request;

class KmsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $balitas = Balita::with(['ibu', 'pemeriksaans'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_balita', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('kms.index', compact('balitas'));
    }

    public function show($id)
    {
        $balita = Balita::with(['ibu', 'posyandu', 'pemeriksaans'])
            ->findOrFail($id);

        $chartLabels = $balita->pemeriksaans->map(function ($item) {
            return $item->tanggal->format('d/m/Y');
        })->toArray();

        $chartBB = $balita->pemeriksaans->pluck('berat_badan')->toArray();
        $chartTB = $balita->pemeriksaans->pluck('tinggi_badan')->toArray();
        $chartUmur = $balita->pemeriksaans->pluck('umur_bulan')->toArray();
        $chartZscore = $balita->pemeriksaans->pluck('zscore')->toArray();

        return view('kms.show', compact(
            'balita',
            'chartLabels',
            'chartBB',
            'chartTB',
            'chartUmur',
            'chartZscore'
        ));
    }
}
