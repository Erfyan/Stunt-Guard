@extends('layouts.app')

@section('title', $title ?? 'Fitur Segera Hadir')
@section('header', '🚧 ' . ($title ?? 'Fitur Segera Hadir'))

@section('content')
<div class="flex flex-col items-center justify-center py-16">
    <div class="text-6xl mb-6">🛠️</div>
    <h2 class="text-3xl font-bold text-gray-700 mb-2">Fitur Sedang Dikembangkan</h2>
    <p class="text-gray-500 text-lg">Halaman <strong>{{ $title ?? 'ini' }}</strong> akan tersedia pada sprint berikutnya.</p>
    <p class="text-gray-400 mt-2">Kembali ke <a href="{{ route('dashboard') }}" class="text-green-600 hover:underline">Dashboard</a></p>
</div>
@endsection