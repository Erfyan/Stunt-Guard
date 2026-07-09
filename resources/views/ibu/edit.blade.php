@extends('layouts.app')

@section('title', 'Edit Ibu')
@section('header', '✏️ Edit Data Ibu')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('ibu.update', $ibu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $ibu->nik) }}"
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('nik') border-red-500 @enderror" required>
                    @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nama Ibu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $ibu->nama_ibu) }}"
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('nama_ibu') border-red-500 @enderror" required>
                    @error('nama_ibu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $ibu->tanggal_lahir ? $ibu->tanggal_lahir->format('Y-m-d') : '') }}"
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $ibu->no_hp) }}"
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" rows="2" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('alamat', $ibu->alamat) }}</textarea>
                </div>

                <hr class="md:col-span-2 border-gray-300">

                <!-- Email (dari user) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', optional($ibu->user)->email) }}"
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror" required>
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('ibu.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection