@extends('layouts.app')

@section('title', 'Edit User - SIPANTAU')
@section('header', '✏️ Edit Pengguna')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('user.index') }}" class="text-pink-500 hover:text-pink-700 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Data User
        </a>
    </div>

    <div class="bg-white/40 backdrop-blur-md border border-white/50 shadow-xl rounded-3xl p-6 sm:p-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center sm:text-left">Edit Data Pengguna</h2>
        
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">NAMA LENGKAP</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">USERNAME</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400">
                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">EMAIL</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nomor HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">NOMOR HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400">
                    @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password (Optional) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">PASSWORD BARU</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">KONFIRMASI PASSWORD BARU</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800 placeholder-gray-400"
                           placeholder="Ulangi password baru">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">ROLE PENGGUNA</label>
                    <select name="role" id="role" required onchange="togglePosyandu()"
                            class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800">
                        <option value="">Pilih Role...</option>
                        <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin (Sistem)</option>
                        <option value="Kader" {{ old('role', $user->role) == 'Kader' ? 'selected' : '' }}>Kader (Posyandu)</option>
                        <option value="Ibu" {{ old('role', $user->role) == 'Ibu' ? 'selected' : '' }}>Ibu (Orang Tua)</option>
                        <option value="Puskesmas" {{ old('role', $user->role) == 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                        <option value="Dinas" {{ old('role', $user->role) == 'Dinas' ? 'selected' : '' }}>Dinas Kesehatan</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">STATUS AKUN</label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800">
                        <option value="Aktif" {{ old('status', $user->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non Aktif" {{ old('status', $user->status) == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Posyandu (Tergantung Role) -->
                <div id="posyandu_container" class="{{ old('role', $user->role) == 'Kader' ? 'block' : 'hidden' }}">
                    <label for="posyandu_id" class="block text-sm font-medium text-gray-700 mb-1">PENEMPATAN POSYANDU</label>
                    <select name="posyandu_id" id="posyandu_id"
                            class="w-full px-4 py-3 bg-white/60 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800">
                        <option value="">Pilih Posyandu...</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $user->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
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
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i> Perbarui Data User
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
            // document.getElementById('posyandu_id').value = ''; // Jangan clear otomatis pada mode edit
        }
    }
</script>
@endsection
