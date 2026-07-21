<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Posyandu;
use App\Models\Pemeriksaan; // <-- tambahkan ini
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $posyanduId = $request->get('posyandu_id');
        $posyandus = Posyandu::all();

        // ===== REKAPITULASI PER POSYANDU =====
        $balitas = Balita::with(['posyandu', 'pemeriksaans' => function ($query) {
            $query->latest()->limit(1);
        }])
        ->when($posyanduId, function ($query, $posyanduId) {
            return $query->where('posyandu_id', $posyanduId);
        })
        ->get();

        $dataPerPosyandu = $balitas->groupBy('posyandu_id')->map(function ($items) {
            $total = $items->count();
            $stunting = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && in_array($last->status_stunting, ['Stunted', 'Severely Stunted']);
            })->count();
            $normal = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Normal';
            })->count();
            $underweight = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && in_array($last->status_gizi, ['Underweight', 'Severely Underweight']);
            })->count();
            $wasting = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && in_array($last->status_gizi, ['Wasting', 'Severely Wasted']);
            })->count();

            return [
                'total' => $total,
                'stunting' => $stunting,
                'normal' => $normal,
                'underweight' => $underweight,
                'wasting' => $wasting,
            ];
        });

        // ===== RECENT DATA SUBMISSIONS =====
        $recentSubmissions = Pemeriksaan::with(['balita', 'user'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($p) {
                // Tentukan status berdasarkan kondisi
                $status = 'Pending Review';
                if ($p->status_gizi == 'Normal' && $p->status_stunting == 'Normal') {
                    $status = 'Verified';
                } elseif (in_array($p->status_stunting, ['Stunted', 'Severely Stunted'])) {
                    $status = 'Flagged Error';
                } elseif (in_array($p->status_gizi, ['Underweight', 'Severely Underweight', 'Wasting', 'Severely Wasted'])) {
                    $status = 'Pending Review';
                }

                return (object) [
                    'id' => $p->id,
                    'patient_name' => optional($p->balita)->nama_balita ?? 'N/A',
                    'category' => 'BALITA GROWTH',
                    'created_at' => $p->created_at,
                    'assigned_officer' => $p->petugas ?? optional($p->user)->nama ?? '-',
                    'status' => $status,
                ];
            });

        return view('laporan.index', compact('posyandus', 'dataPerPosyandu', 'posyanduId', 'recentSubmissions'));
    }

    public function exportPDF(Request $request)
    {
        $posyanduId = $request->get('posyandu_id');
        $posyandus = Posyandu::all();

        $balitas = Balita::with(['posyandu', 'pemeriksaans' => function ($query) {
            $query->latest()->limit(1);
        }])
        ->when($posyanduId, function ($query, $posyanduId) {
            return $query->where('posyandu_id', $posyanduId);
        })
        ->get();

        $dataPerPosyandu = $balitas->groupBy('posyandu_id')->map(function ($items) {
            $total = $items->count();
            $stunting = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && in_array($last->status_stunting, ['Stunted', 'Severely Stunted']);
            })->count();
            $normal = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Normal';
            })->count();
            $underweight = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && in_array($last->status_gizi, ['Underweight', 'Severely Underweight']);
            })->count();
            $wasting = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && in_array($last->status_gizi, ['Wasting', 'Severely Wasted']);
            })->count();

            return [
                'total' => $total,
                'stunting' => $stunting,
                'normal' => $normal,
                'underweight' => $underweight,
                'wasting' => $wasting,
            ];
        });

        // Ambil path CSS (sama seperti sebelumnya)
        $manifestPath = public_path('build/manifest.json');
        $cssPath = null;
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            if (isset($manifest['resources/css/pdf.css'])) {
                $cssPath = $manifest['resources/css/pdf.css']['file'];
            }
        }
        if (!$cssPath) {
            $cssPath = 'css/pdf.css';
        }

        $pdf = Pdf::loadView('laporan.pdf', compact('dataPerPosyandu', 'posyandus', 'cssPath'));
        return $pdf->download('laporan-stunting-' . date('Y-m-d') . '.pdf');
    }
}