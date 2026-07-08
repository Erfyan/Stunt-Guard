@extends('layouts.app')

@section('title', 'Edit Balita')
@section('header', '✏️ Edit Balita')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('balita.update', $balita->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nama Balita -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Balita <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_balita" value="{{ old('nama_balita', $balita->nama_balita) }}" 
                        class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('nama_balita') border-red-500 @enderror" required>
                    @error('nama_balita') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $balita->nik) }}" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('nik') border-red-500 @enderror">
                    @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('jenis_kelamin') border-red-500 @enderror" required>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $balita->tanggal_lahir ? $balita->tanggal_lahir->format('Y-m-d') : '') }}" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('tanggal_lahir') border-red-500 @enderror" required>
                    @error('tanggal_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Ibu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ibu <span class="text-red-500">*</span></label>
                    <select name="ibu_id" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('ibu_id') border-red-500 @enderror" required>
                        @foreach($ibus as $ibu)
                            <option value="{{ $ibu->id }}" {{ old('ibu_id', $balita->ibu_id) == $ibu->id ? 'selected' : '' }}>
                                {{ $ibu->nama_ibu }} ({{ $ibu->nik }})
                            </option>
                        @endforeach
                    </select>
                    @error('ibu_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Tidak ada ibu? <a href="{{ route('ibu.create') }}" class="text-green-600 hover:underline">Tambah Ibu</a></p>
                </div>

                <!-- Posyandu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Posyandu <span class="text-red-500">*</span></label>
                    <select name="posyandu_id" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('posyandu_id') border-red-500 @enderror" required>
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
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('berat_lahir') border-red-500 @enderror">
                    @error('berat_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Panjang Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Panjang Lahir (cm)</label>
                    <input type="number" step="0.1" name="panjang_lahir" value="{{ old('panjang_lahir', $balita->panjang_lahir) }}" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('panjang_lahir') border-red-500 @enderror">
                    @error('panjang_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('balita.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection