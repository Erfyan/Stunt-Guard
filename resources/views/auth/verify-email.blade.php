@extends('layouts.guest')

@section('title', 'Verifikasi Email - SIPANTAU STUNTING')

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

    <!-- ===== JUDUL HALAMAN ===== -->
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-800">Verifikasi Email</h3>
        <p class="text-sm text-gray-500 mt-1">Sebelum memulai, verifikasi alamat email Anda.</p>
    </div>

    <!-- ===== PESAN ===== -->
    <div class="mb-4 text-sm text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-200">
        Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik link yang telah kami kirimkan ke email Anda. Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan ulang.
    </div>

    <!-- ===== STATUS (Jika link verifikasi sudah dikirim ulang) ===== -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-green-500 text-xl"></i>
            <span>Link verifikasi baru telah dikirim ke alamat email Anda.</span>
        </div>
    @endif

    <!-- ===== TOMBOL ===== -->
    <div class="flex flex-col gap-3 mt-4">
        <!-- Kirim Ulang Email -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
                <i class="fas fa-envelope mr-2"></i> Kirim Ulang Email Verifikasi
            </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 rounded-xl transition">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="mt-6 text-center text-xs text-gray-500 space-y-1">
        <p><span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></span> SISTEM OPERASI NORMAL</p>
        <p>VERSI 2.4.0 – SIPANTAU STUNTING © 2024</p>
        <p class="mt-3 text-gray-400">Dipercaya oleh 1,200+ Tenaga Medis</p>
    </div>

</div>
@endsection