<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Ibu;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index()
    {
        $balitas = Balita::with(['ibu', 'posyandu'])->get();
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
}