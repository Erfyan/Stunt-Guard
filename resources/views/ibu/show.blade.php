@extends('layouts.app')

@section('title', 'Detail Ibu')
@section('header', '👩 Detail Ibu')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $ibu->nama_ibu ?? '-' }}</h2>
                <p class="text-gray-500">NIK: {{ $ibu->nik ?? '-' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('ibu.edit', $ibu->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('ibu.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded shadow transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi Ibu -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div><span class="font-semibold">NIK:</span> {{ $ibu->nik ?? '-' }}</div>
            <div><span class="font-semibold">Nama Ibu:</span> {{ $ibu->nama_ibu ?? '-' }}</div>
            <div><span class="font-semibold">Tanggal Lahir:</span> {{ $ibu->tanggal_lahir ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->format('d-m-Y') : '-' }}</div>
            <div><span class="font-semibold">No HP:</span> {{ $ibu->no_hp ?? '-' }}</div>
            <div class="md:col-span-2"><span class="font-semibold">Alamat:</span> {{ $ibu->alamat ?? '-' }}</div>
        </div>

        <!-- Informasi Akun Login -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">🔑 Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><span class="font-semibold">Email:</span> {{ optional($ibu->user)->email ?? '-' }}</div>
                <div><span class="font-semibold">Username:</span> {{ optional($ibu->user)->username ?? '-' }}</div>
                <div><span class="font-semibold">Status Akun:</span> 
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ optional($ibu->user)->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ optional($ibu->user)->status ?? '-' }}
                    </span>
                </div>
                <div><span class="font-semibold">Role:</span> {{ optional($ibu->user)->role ?? '-' }}</div>
            </div>
        </div>

        <!-- Daftar Balita -->
        <div class="border-t pt-4 mt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">👶 Daftar Balita</h3>
            @if($ibu->balitas && $ibu->balitas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">JK</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ibu->balitas as $balita)
                            <tr>
                                <td class="px-4 py-2">{{ $balita->nama_balita }}</td>
                                <td class="px-4 py-2">{{ $balita->jenis_kelamin }}</td>
                                <td class="px-4 py-2">{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('balita.show', $balita->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Belum ada balita terdaftar untuk ibu ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection