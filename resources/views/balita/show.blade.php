@extends('layouts.app')

@section('title', 'Detail Balita')
@section('header', '👶 Detail Balita')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $balita->nama_balita ?? '-' }}</h2>
                <p class="text-gray-500">NIK: {{ $balita->nik ?? '-' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('balita.edit', $balita->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('balita.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded shadow transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi Balita -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div><span class="font-semibold">Nama:</span> {{ $balita->nama_balita ?? '-' }}</div>
            <div><span class="font-semibold">NIK:</span> {{ $balita->nik ?? '-' }}</div>
            <div><span class="font-semibold">Jenis Kelamin:</span> {{ $balita->jenis_kelamin ?? '-' }}</div>
            <div><span class="font-semibold">Tanggal Lahir:</span> {{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</div>
            <div><span class="font-semibold">Umur:</span> {{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now()) . ' bulan' : '-' }}</div>
            <div><span class="font-semibold">Berat Lahir:</span> {{ $balita->berat_lahir ?? '-' }} kg</div>
            <div><span class="font-semibold">Panjang Lahir:</span> {{ $balita->panjang_lahir ?? '-' }} cm</div>
            <div><span class="font-semibold">Status:</span> 
                <span class="px-2 py-1 rounded text-xs font-semibold {{ $balita->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $balita->status ?? '-' }}
                </span>
            </div>
        </div>

        <!-- Informasi Ibu -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">👩 Informasi Ibu</h3>
            @if($balita->ibu)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><span class="font-semibold">Nama Ibu:</span> {{ $balita->ibu->nama_ibu ?? '-' }}</div>
                    <div><span class="font-semibold">NIK Ibu:</span> {{ $balita->ibu->nik ?? '-' }}</div>
                    <div><span class="font-semibold">No HP:</span> {{ $balita->ibu->no_hp ?? '-' }}</div>
                </div>
            @else
                <p class="text-gray-500">Data ibu tidak tersedia.</p>
            @endif
        </div>

        <!-- Informasi Posyandu -->
        <div class="border-t pt-4 mt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">🏥 Informasi Posyandu</h3>
            @if($balita->posyandu)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><span class="font-semibold">Nama Posyandu:</span> {{ $balita->posyandu->nama_posyandu ?? '-' }}</div>
                    <div><span class="font-semibold">Desa/Kelurahan:</span> {{ $balita->posyandu->desa ?? '-' }}</div>
                    <div><span class="font-semibold">Kecamatan:</span> {{ $balita->posyandu->kecamatan ?? '-' }}</div>
                </div>
            @else
                <p class="text-gray-500">Data posyandu tidak tersedia.</p>
            @endif
        </div>

        <!-- Riwayat Pemeriksaan (akan diisi di Sprint 3) -->
        <div class="border-t pt-4 mt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">📊 Riwayat Pemeriksaan</h3>
            <p class="text-gray-400 text-sm">Fitur ini akan tersedia pada Sprint 3 (Input Pemeriksaan & Deteksi Stunting).</p>
        </div>
    </div>
</div>
@endsection