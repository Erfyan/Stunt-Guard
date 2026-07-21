@extends('layouts.guest')

@section('title', 'Login - SIPANTAU STUNTING')

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
        <p class="text-sm text-gray-500 mt-2">Sistem pemantauan kesehatan digital yang ceria dan akurat untuk memantau tumbuh kembang si buah hati setiap saat.</p>
    </div>

    <!-- ===== SELAMAT DATANG ===== -->
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-800">Selamat Datang</h3>
        <p class="text-sm text-gray-500">Silakan masuk untuk melanjutkan pemantauan kesehatan.</p>
    </div>

    <!-- ===== FORM LOGIN ===== -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Username / Email -->
        <div>
            <label for="login" class="block text-sm font-medium text-gray-700">USERNAME ATAU EMAIL</label>
            <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800"
                   placeholder="Masukkan username atau email anda">
            @error('login')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <label for="password" class="block text-sm font-medium text-gray-700">PASSWORD</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-pink-500 hover:text-pink-700 transition">Lupa Password?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" required
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800"
                   placeholder="Masukkan password">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="h-4 w-4 text-pink-500 focus:ring-pink-400 border-gray-300 rounded">
            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat saya untuk 30 hari ke depan</label>
        </div>

        <!-- Tombol Login -->
        <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
            Masuk Sekarang
        </button>
    </form>

    <!-- Opsi Login Lain -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500">ATAU MASUK DENGAN</p>
        <div class="flex justify-center gap-4 mt-3">
            <button class="bg-gray-100 border border-gray-300 px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-gray-200 transition">
                <i class="fas fa-fingerprint text-pink-500"></i>
                <span class="text-sm text-gray-700">Biometrik</span>
            </button>
            <button class="bg-gray-100 border border-gray-300 px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-gray-200 transition">
                <i class="fas fa-key text-pink-500"></i>
                <span class="text-sm text-gray-700">Kode Akses</span>
            </button>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center text-xs text-gray-500 space-y-1">
        <p><span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></span> SISTEM OPERASI NORMAL</p>
        <p>VERSI 2.4.0 – SIPANTAU STUNTING © 2026</p>
        <p class="mt-3 text-gray-400">Dipercaya oleh 1,200+ Tenaga Medis</p>
    </div>

    <!-- Link ke Register -->
    <div class="mt-4 text-center">
        <span class="text-sm text-gray-600">Belum punya akun?</span>
        <a href="{{ route('register') }}" class="text-sm text-pink-500 hover:text-pink-700 font-medium transition">Daftar sekarang</a>
    </div>
</div>
@endsection