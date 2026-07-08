@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Ibu & Akun Login</h1>

        <form action="{{ route('ibu.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK *</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500" required>
                    @error('nik') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ibu *</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500" required>
                    @error('nama_ibu') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500">{{ old('alamat') }}</textarea>
                </div>
                <hr class="md:col-span-2 border-gray-300">
                <h3 class="md:col-span-2 font-bold text-gray-700">🔑 Data Login (untuk Ibu)</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500" required>
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password *</label>
                    <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500" required>
                    @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2 focus:ring-green-500" required>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">Simpan</button>
                <a href="{{ route('ibu.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection