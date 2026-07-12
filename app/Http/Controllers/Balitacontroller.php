<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Ibu;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BalitaController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $balitas = Balita::with(['ibu', 'posyandu'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_balita', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('balita.index', compact('balitas'));
    }

    public function create()
    {
        $ibus = Ibu::all();
        $posyandus = Posyandu::all();
        return view('balita.create', compact('ibus', 'posyandus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_id' => 'required|exists:ibuses,id',
            'posyandu_id' => 'required|exists:posyandus,id',
            'nama_balita' => 'required|string|max:100',
            'nik' => 'nullable|string|max:20|unique:balitas,nik',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'berat_lahir' => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
        ]);

        Balita::create($request->all());

        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Ambil data balita beserta relasi (ibu, posyandu, dan pemeriksaan)
        $balita = Balita::with([
            'ibu', 
            'posyandu', 
            'pemeriksaans' => function($query) {
                // Urutkan dari yang paling lama ke terbaru
                $query->orderBy('tanggal', 'asc');
            }
        ])->findOrFail($id);

        // === Format data untuk Chart.js ===
        
        // 1. Labels (sumbu X) = tanggal pemeriksaan
        $chartLabels = $balita->pemeriksaans->map(function($item) {
            return $item->tanggal->format('d/m/Y');
        })->toArray();

        // 2. Data Berat Badan (kg)
        $chartBB = $balita->pemeriksaans->pluck('berat_badan')->toArray();

        // 3. Data Tinggi Badan (cm)
        $chartTB = $balita->pemeriksaans->pluck('tinggi_badan')->toArray();

        // 4. Data Umur (bulan) - untuk tooltip
        $chartUmur = $balita->pemeriksaans->pluck('umur_bulan')->toArray();

        // 5. Data Z-Score (untuk zona warna)
        $chartZscore = $balita->pemeriksaans->pluck('zscore')->toArray();

        // 6. Data Status Gizi (untuk warna titik)
        $chartStatus = $balita->pemeriksaans->pluck('status_gizi')->toArray();

        return view('balita.show', compact(
            'balita',
            'chartLabels',
            'chartBB',
            'chartTB',
            'chartUmur',
            'chartZscore',
            'chartStatus'
        ));
    }


    public function edit($id) {
    $balita = Balita::findOrFail($id);
        $ibus = Ibu::all();
        $posyandus = Posyandu::all();
        return view('balita.edit', compact('balita', 'ibus', 'posyandus'));
    }

public function update(Request $request, $id)
{
    $balita = Balita::findOrFail($id);
        $request->validate([
            'ibu_id' => 'required|exists:ibuses,id',
            'posyandu_id' => 'required|exists:posyandus,id',
            'nama_balita' => 'required|string|max:100',
            'nik' => 'nullable|string|max:20|unique:balitas,nik,' . $balita->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'berat_lahir' => 'nullable|numeric|min:0',
            'panjang_lahir' => 'nullable|numeric|min:0',
        ]);

        $balita->update($request->all());

        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil diperbarui!');
    }

    public function destroy($id) {
        $balita = Balita::findOrFail($id);
        $balita->delete();
        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil dihapus!');
    }
    public function exportPDF(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $balitas = Balita::with(['ibu', 'posyandu'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_balita', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->get();

        // Ambil path CSS dari manifest Vite (sama seperti Ibu)
        $manifestPath = public_path('build/manifest.json');
        $cssPath = null;
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            if (isset($manifest['resources/css/pdf.css'])) {
                $cssPath = $manifest['resources/css/pdf.css']['file'];
            }
        }

        // Fallback jika file CSS belum di-build
        if (!$cssPath) {
            $cssPath = 'css/pdf.css';
        }

        $pdf = Pdf::loadView('balita.pdf', compact('balitas', 'search', 'status', 'cssPath'));
        return $pdf->download('data-balita-' . date('Y-m-d') . '.pdf');
    }
}