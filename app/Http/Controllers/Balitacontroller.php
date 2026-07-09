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

  public function show($id) {
    $balita = Balita::findOrFail($id);
    return view('balita.show', compact('balita'));
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
            ->get(); // ambil semua (tanpa paginasi)

        $pdf = Pdf::loadView('balita.pdf', compact('balitas', 'search', 'status'));
        return $pdf->download('data-balita-' . date('Y-m-d') . '.pdf');
    }
}