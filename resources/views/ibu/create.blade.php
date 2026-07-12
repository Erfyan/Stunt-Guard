@extends('layouts.app')

@section('title', 'Tambah Ibu')
@section('header', '➕ Tambah Data Ibu & Akun Login')

@section('content')
<div class="container mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

    <!-- Card Glassmorphism -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

        <form action="{{ route('ibu.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}"
                           class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('nik') border-red-500" required>
                    @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nama Ibu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                           class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('nama_ibu') border-red-500" required>
                    @error('nama_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('tanggal_lahir') border-red-500">
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                           class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('no_hp') border-red-500">
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" rows="2"
                              class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('alamat') border-red-500">{{ old('alamat') }}</textarea>
                </div>

                <hr class="md:col-span-2 border-gray-300/50">

                <!-- Data Login -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-pink-600 mb-2">🔑 Data Login (untuk Ibu)</h3>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('email') border-red-500" required>
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password"
                           class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('password') border-red-500" required>
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation"
                           class="mt-1 w-full bg-gray-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                </div>
            </div>

            <!-- Tombol -->
            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('ibu.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-6 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection