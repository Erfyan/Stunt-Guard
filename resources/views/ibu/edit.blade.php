@extends('layouts.app')

@section('title', 'Edit Ibu')
@section('header', '✏️ Edit Data Ibu')

@section('content')
<div class="container mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

    <!-- Card Glassmorphism -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

        <form action="{{ route('ibu.update', ['id' => $ibu->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $ibu->nik) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('nik') border-red-500 @else border-gray-300 @enderror"
                           placeholder="Masukkan NIK" required>
                    @error('nik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Ibu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $ibu->nama_ibu) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('nama_ibu') border-red-500 @else border-gray-300 @enderror"
                           placeholder="Masukkan nama ibu" required>
                    @error('nama_ibu')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir (AMAN) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                           value="{{ old('tanggal_lahir', optional($ibu->tanggal_lahir) ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->format('Y-m-d') : '') }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $ibu->no_hp) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                           placeholder="Contoh: 081234567890">
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" rows="2"
                              class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                              placeholder="Masukkan alamat">{{ old('alamat', $ibu->alamat) }}</textarea>
                </div>

                <hr class="md:col-span-2 border-gray-300/50">

                <!-- Data Login -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-pink-600 mb-2">🔑 Data Login</h3>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', optional($ibu->user)->email) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('email') border-red-500 @else border-gray-300 @enderror"
                           placeholder="email@example.com" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('ibu.index') }}"
                   class="bg-pink-300 hover:bg-pink-400 text-white font-medium px-6 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection