@extends('layouts.guest')

@section('title', 'Lupa Password - SIPANTAU STUNTING')

@section('content')
<div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md transition hover:shadow-xl">

    <!-- LOGO -->
    <div class="flex justify-center mb-3">
        <a href="/" class="flex items-center gap-2">
            @include('partials.logo')
        </a>
    </div>

    <!-- TAGLINE -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-pink-600">Sipantau Stunting</h1>
        <h2 class="text-lg font-semibold text-gray-800 mt-1">Wujudkan Generasi Emas Indonesia</h2>
        <p class="text-sm text-gray-500 mt-2">Sistem pemantauan kesehatan digital yang ceria dan akurat.</p>
    </div>

    <!-- JUDUL -->
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-800">Lupa Password</h3>
        <p class="text-sm text-gray-500 mt-1">Masukkan email Anda, kami akan kirimkan link untuk mereset password.</p>
    </div>

    <!-- SESSION STATUS -->
    @if (session('status'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-green-500 text-xl"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <!-- FORM -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">EMAIL</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition text-gray-800"
                   placeholder="Masukkan email anda">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
            Kirim Link Reset Password
        </button>
    </form>

    <!-- LINK KEMBALI -->
    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-sm text-pink-500 hover:text-pink-700 font-medium transition">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
        </a>
    </div>

    <!-- FOOTER -->
    <div class="mt-6 text-center text-xs text-gray-500 space-y-1">
        <p><span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></span> SISTEM OPERASI NORMAL</p>
        <p>VERSI 2.4.0 – SIPANTAU STUNTING © 2024</p>
        <p class="mt-3 text-gray-400">Dipercaya oleh 1,200+ Tenaga Medis</p>
    </div>

</div>
@endsection