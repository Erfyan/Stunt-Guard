<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class IbuController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');

        $ibus = Ibu::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('nama_ibu', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('ibu.index', compact('ibus'));
    }

    public function create()
    {
        return view('ibu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20|unique:ibuses,nik',
            'nama_ibu' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // 1. Buat User untuk Ibu (role = Ibu)
        $user = User::create([
            'nama' => $request->nama_ibu,
            'username' => strtolower(str_replace(' ', '_', $request->nama_ibu)) . rand(10, 99),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Ibu',
            'status' => 'Aktif'
        ]);

        // 2. Buat data Ibu
        Ibu::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_ibu' => $request->nama_ibu,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('ibu.index')
            ->with('success', 'Data Ibu berhasil ditambahkan! Akun login telah dibuat.');
    }

    public function show(Ibu $ibu)
    {
        return view('ibu.show', compact('ibu'));
    }

    public function edit(Ibu $ibu)
    {
        return view('ibu.edit', compact('ibu'));
    }

    public function update(Request $request, Ibu $ibu)
    {
        $request->validate([
            'nik' => 'required|string|max:20|unique:ibuses,nik,' . $ibu->id,
            'nama_ibu' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $ibu->user_id,
        ]);

        // Update User
        $ibu->user->update([
            'nama' => $request->nama_ibu,
            'email' => $request->email,
        ]);

        // Update Ibu
        $ibu->update($request->all());

        return redirect()->route('ibu.index')
            ->with('success', 'Data Ibu berhasil diperbarui!');
    }

    public function destroy(Ibu $ibu)
    {
        // Hapus user juga
        $ibu->user()->delete();
        $ibu->delete();

        return redirect()->route('ibu.index')
            ->with('success', 'Data Ibu berhasil dihapus!');
    }
}