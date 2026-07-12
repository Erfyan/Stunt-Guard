@extends('layouts.guest')

@section('title', 'Register - SIPANTAU STUNTING')

@section('content')
<div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md transition hover:shadow-xl">

    <!-- ===== LOGO ===== -->
    <div class="flex justify-center mb-3">
        <a href="/" class="flex items-center gap-2">
            @include('partials.logo')
        </a>
    </div>

    <!-- ===== TAGLINE ===== -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-pink-600">Sipantau Stunting</h1>
        <h2 class="text-lg font-semibold text-gray-800 mt-1">Wujudkan Generasi Emas Indonesia</h2>
        <p class="text-sm text-gray-500 mt-2">Sistem pemantauan kesehatan digital yang ceria dan akurat.</p>
    </div>

    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-800">Daftar Akun</h3>
        <p class="text-sm text-gray-500">Silakan daftar untuk memulai pemantauan.</p>
    </div>

    <!-- ===== FORM REGISTER ===== -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">NAMA LENGKAP</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800"
                   placeholder="Nama lengkap">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">EMAIL</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800"
                   placeholder="email@example.com">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">PASSWORD</label>
            <input id="password" type="password" name="password" required
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800"
                   placeholder="Minimal 8 karakter">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">KONFIRMASI PASSWORD</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800"
                   placeholder="Ulangi password">
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">PILIH ROLE</label>
            <select id="role" name="role"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800">
                <option value="Ibu">Ibu (Orang Tua)</option>
                <option value="Kader">Kader Posyandu</option>
                <option value="Admin">Admin</option>
            </select>
            @error('role')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
            Daftar Sekarang
        </button>
    </form>

    <!-- Footer -->
    <div class="mt-6 text-center text-xs text-gray-500 space-y-1">
        <p><span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></span> SISTEM OPERASI NORMAL</p>
        <p>VERSI 2.4.0 – SIPANTAU STUNTING © 2024</p>
        <p class="mt-3 text-gray-400">Dipercaya oleh 1,200+ Tenaga Medis</p>
    </div>

    <!-- Link ke Login -->
    <div class="mt-4 text-center">
        <span class="text-sm text-gray-600">Sudah punya akun?</span>
        <a href="{{ route('login') }}" class="text-sm text-pink-500 hover:text-pink-700 font-medium transition">Masuk</a>
    </div>
</div>
@endsection