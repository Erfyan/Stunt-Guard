@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header', '👤 Profil Saya')

@section('content')
<div class="container mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

        <!-- Avatar & Nama -->
        <div class="flex flex-col items-center border-b border-white/30 pb-6 mb-6">
            <div class="w-24 h-24 bg-pink-200 rounded-full flex items-center justify-center text-4xl text-pink-600 font-bold shadow-lg border-4 border-white/50">
                {{ strtoupper(substr($user->nama, 0, 1)) }}
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mt-3">{{ $user->nama }}</h2>
            <p class="text-sm text-gray-500">{{ '@' . $user->username }}</p>
            <span class="mt-2 px-4 py-1 rounded-full text-xs font-bold
                @if($user->role == 'Admin') bg-purple-200 text-purple-800
                @elseif($user->role == 'Kader') bg-green-200 text-green-800
                @elseif($user->role == 'Ibu') bg-blue-200 text-blue-800
                @else bg-gray-200 text-gray-800 @endif
            ">
                {{ strtoupper($user->role) }}
            </span>
        </div>

        <!-- Detail Data -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                <p class="text-gray-800 font-medium">{{ $user->nama }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Username</label>
                <p class="text-gray-800 font-medium">{{ $user->username }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Email</label>
                <p class="text-gray-800 font-medium">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">No HP</label>
                <p class="text-gray-800 font-medium">{{ $user->no_hp ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Role</label>
                <p class="text-gray-800 font-medium">{{ $user->role }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Status Akun</label>
                <span class="px-3 py-1 rounded-full text-xs font-bold
                    {{ $user->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                ">
                    {{ $user->status }}
                </span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Posyandu</label>
                <p class="text-gray-800 font-medium">{{ optional($user->posyandu)->nama_posyandu ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Bergabung Sejak</label>
                <p class="text-gray-800 font-medium">{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</p>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6 text-center">
            <a href="{{ route('dashboard') }}" class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-medium px-6 py-2.5 rounded-xl shadow transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

    </div>

</div>
@endsection