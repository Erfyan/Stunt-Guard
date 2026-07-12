@extends('layouts.app')

@section('title', 'Edit Balita')
@section('header', '✏️ Edit Balita')

@section('content')
<div class="container mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

    <!-- Card Glassmorphism -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

        <form action="{{ route('balita.update', $balita->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Nama Balita -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Balita <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_balita" value="{{ old('nama_balita', $balita->nama_balita) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('nama_balita') @else border-gray-300 @enderror"
                           placeholder="Masukkan nama balita" required>
                    @error('nama_balita') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $balita->nik) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('nik') @else border-gray-300 @enderror"
                           placeholder="16 digit (opsional)">
                    @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin"
                            class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('jenis_kelamin') @else border-gray-300 @enderror" required>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $balita->tanggal_lahir ? $balita->tanggal_lahir->format('Y-m-d') : '') }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('tanggal_lahir') @else border-gray-300 @enderror" required>
                    @error('tanggal_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Ibu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ibu <span class="text-red-500">*</span></label>
                    <select name="ibu_id"
                            class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('ibu_id') @else border-gray-300 @enderror" required>
                        @foreach($ibus as $ibu)
                            <option value="{{ $ibu->id }}" {{ old('ibu_id', $balita->ibu_id) == $ibu->id ? 'selected' : '' }}>
                                {{ $ibu->nama_ibu }} ({{ $ibu->nik }})
                            </option>
                        @endforeach
                    </select>
                    @error('ibu_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Tidak ada ibu? <a href="{{ route('ibu.create') }}" class="text-pink-500 hover:text-pink-700 font-medium transition">Tambah Ibu</a></p>
                </div>

                <!-- Posyandu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Posyandu <span class="text-red-500">*</span></label>
                    <select name="posyandu_id"
                            class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('posyandu_id') @else border-gray-300 @enderror" required>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $balita->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
                                {{ $posyandu->nama_posyandu }}
                            </option>
                        @endforeach
                    </select>
                    @error('posyandu_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Berat Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Berat Lahir (kg)</label>
                    <input type="number" step="0.01" name="berat_lahir" value="{{ old('berat_lahir', $balita->berat_lahir) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('berat_lahir') @else border-gray-300 @enderror"
                           placeholder="Contoh: 3.2">
                    @error('berat_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Panjang Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Panjang Lahir (cm)</label>
                    <input type="number" step="0.1" name="panjang_lahir" value="{{ old('panjang_lahir', $balita->panjang_lahir) }}"
                           class="mt-1 w-full bg-pink-50 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition @error('panjang_lahir') @else border-gray-300 @enderror"
                           placeholder="Contoh: 49.0">
                    @error('panjang_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-6 py-2.5 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('balita.index') }}"
                   class="bg-pink-300 hover:bg-pink-400 text-white font-medium px-6 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection