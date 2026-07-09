@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header', '👤 Profil Saya')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">

        <!-- Informasi Profil -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Akun</h2>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror" required>
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-save"></i> Update Profil
                </button>
            </form>
        </div>

        <hr class="my-6">

        <!-- Ganti Password -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ganti Password</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                    <input type="password" name="current_password" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" name="password" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" 
                           class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>

                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-key"></i> Update Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection