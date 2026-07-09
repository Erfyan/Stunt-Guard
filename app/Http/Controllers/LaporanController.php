<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Posyandu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $posyanduId = $request->get('posyandu_id');
        $posyandus = Posyandu::all();

        // Ambil data balita dengan relasi posyandu dan pemeriksaan terakhir
        $balitas = Balita::with(['posyandu', 'pemeriksaans' => function ($query) {
            $query->latest()->limit(1);
        }])
        ->when($posyanduId, function ($query, $posyanduId) {
            return $query->where('posyandu_id', $posyanduId);
        })
        ->get();

        // Kelompokkan per posyandu
        $dataPerPosyandu = $balitas->groupBy('posyandu_id')->map(function ($items) {
            $total = $items->count();
            $stunting = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_stunting == 'Stunting';
            })->count();
            $normal = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Normal';
            })->count();
            $underweight = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Underweight';
            })->count();
            $wasting = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Wasting';
            })->count();

            return [
                'total' => $total,
                'stunting' => $stunting,
                'normal' => $normal,
                'underweight' => $underweight,
                'wasting' => $wasting,
                'items' => $items,
            ];
        });

        return view('laporan.index', compact('posyandus', 'dataPerPosyandu', 'posyanduId'));
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
                return $last && $last->status_stunting == 'Stunting';
            })->count();
            $normal = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Normal';
            })->count();
            $underweight = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Underweight';
            })->count();
            $wasting = $items->filter(function ($item) {
                $last = $item->pemeriksaans->first();
                return $last && $last->status_gizi == 'Wasting';
            })->count();

            return [
                'total' => $total,
                'stunting' => $stunting,
                'normal' => $normal,
                'underweight' => $underweight,
                'wasting' => $wasting,
                'items' => $items,
            ];
        });

        $pdf = Pdf::loadView('laporan.pdf', compact('dataPerPosyandu', 'posyanduId'));
        return $pdf->download('laporan-stunting-' . date('Y-m-d') . '.pdf');
    }
}