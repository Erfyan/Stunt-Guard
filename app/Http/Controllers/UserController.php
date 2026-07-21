<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('posyandu')->orderBy('created_at', 'desc')->paginate(10);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $posyandus = Posyandu::all();
        return view('user.create', compact('posyandus'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:Admin,Kader,Ibu,Petugas,Puskesmas,Dinas',
            'posyandu_id' => 'nullable|exists:posyandus,id',
            'status' => 'required|in:Aktif,Non Aktif',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'posyandu_id' => $validated['posyandu_id'],
            'status' => $validated['status'],
            'no_hp' => $validated['no_hp'],
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $posyandus = Posyandu::all();
        return view('user.edit', compact('user', 'posyandus'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:Admin,Kader,Ibu,Petugas,Puskesmas,Dinas',
            'posyandu_id' => 'nullable|exists:posyandus,id',
            'status' => 'required|in:Aktif,Non Aktif',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $data = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'posyandu_id' => $validated['posyandu_id'],
            'status' => $validated['status'],
            'no_hp' => $validated['no_hp'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('user.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Cegah menghapus diri sendiri
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus!');
    }
}