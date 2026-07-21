@extends('layouts.app')

@section('title', 'Tambah User - SIPANTAU')
@section('header', '➕ Tambah Pengguna Baru')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('user.index') }}" class="text-pink-500 hover:text-pink-700 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Data User
        </a>
    </div>

    <div class="bg-white/40 backdrop-blur-md border border-white/50 shadow-xl rounded-3xl p-6 sm:p-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center sm:text-left">Lengkapi Formulir Pengguna</h2>
        
        <form action="{{ route('user.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">NAMA LENGKAP</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="Masukkan nama lengkap">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">USERNAME</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="Masukkan username (tanpa spasi)">
                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">EMAIL</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="email@example.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nomor HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">NOMOR HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="08xxxxxxxxxx">
                    @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">PASSWORD</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="Minimal 8 karakter">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">KONFIRMASI PASSWORD</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="Ulangi password">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">ROLE PENGGUNA</label>
                    <select name="role" id="role" required onchange="togglePosyandu()"
                            class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800">
                        <option value="">Pilih Role...</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin (Sistem)</option>
                        <option value="Kader" {{ old('role') == 'Kader' ? 'selected' : '' }}>Kader (Posyandu)</option>
                        <option value="Ibu" {{ old('role') == 'Ibu' ? 'selected' : '' }}>Ibu (Orang Tua)</option>
                        <option value="Puskesmas" {{ old('role') == 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                        <option value="Dinas" {{ old('role') == 'Dinas' ? 'selected' : '' }}>Dinas Kesehatan</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">STATUS AKUN</label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800">
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non Aktif" {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Posyandu (Tergantung Role) -->
                <div id="posyandu_container" class="{{ old('role') == 'Kader' ? 'block' : 'hidden' }}">
                    <label for="posyandu_id" class="block text-sm font-medium text-gray-700 mb-1">PENEMPATAN POSYANDU</label>
                    <select name="posyandu_id" id="posyandu_id"
                            class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800">
                        <option value="">Pilih Posyandu...</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id') == $posyandu->id ? 'selected' : '' }}>
                                {{ $posyandu->nama_posyandu }} - {{ $posyandu->kecamatan }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">* Wajib diisi jika role adalah Kader.</p>
                    @error('posyandu_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('user.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-6 rounded-xl transition shadow-sm">
                    Batal
                </a>
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePosyandu() {
        const role = document.getElementById('role').value;
        const container = document.getElementById('posyandu_container');
        if (role === 'Kader') {
            container.classList.remove('hidden');
            container.classList.add('block');
        } else {
            container.classList.add('hidden');
            container.classList.remove('block');
            document.getElementById('posyandu_id').value = '';
        }
    }
</script>
@endsection
