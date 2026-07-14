<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function show($id)
    {
        $ibu = Ibu::with(['user', 'balitas'])->findOrFail($id);
        return view('ibu.show', compact('ibu'));
    }

 public function edit($id)
    {
        $ibu = Ibu::with('user')->findOrFail($id);
        return view('ibu.edit', compact('ibu'));
    }

    public function update(Request $request, $id)
    {
        $ibu = Ibu::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|max:20|unique:ibuses,nik,' . $ibu->id,
            'nama_ibu' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $ibu->user_id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update data ibu
        $ibu->update($request->only(['nik', 'nama_ibu', 'tanggal_lahir', 'alamat', 'no_hp']));

        // Update user
        $user = User::find($ibu->user_id);
        $userData = [
            'nama' => $request->nama_ibu,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);

        return redirect()->route('ibu.index')
            ->with('success', 'Data ibu berhasil diperbarui!');
    }
    public function destroy(Ibu $ibu)
    {
        // Hapus user juga
        $ibu->user()->delete();
        $ibu->delete();

        return redirect()->route('ibu.index')
            ->with('success', 'Data Ibu berhasil dihapus!');
    }
    public function exportPDF(Request $request)
    {
        $search = $request->get('search');

        $ibus = Ibu::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('nama_ibu', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('ibu.pdf', compact('ibus', 'search'));
        return $pdf->download('data-ibu-' . date('Y-m-d') . '.pdf');
    }
}