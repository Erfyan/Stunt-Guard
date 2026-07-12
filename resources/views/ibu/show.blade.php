@extends('layouts.app')

@section('title', 'Detail Ibu')
@section('header', '👩 Detail Ibu')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Card Utama -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center border-b border-white/30 pb-4 mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $ibu->nama_ibu ?? '-' }}</h2>
                <p class="text-gray-600">NIK: {{ $ibu->nik ?? '-' }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('ibu.edit', $ibu->id) }}"
                   class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('ibu.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-4 py-2 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi Ibu -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div><span class="font-semibold text-gray-700">NIK:</span> {{ $ibu->nik ?? '-' }}</div>
            <div><span class="font-semibold text-gray-700">Nama Ibu:</span> {{ $ibu->nama_ibu ?? '-' }}</div>
            <div><span class="font-semibold text-gray-700">Tanggal Lahir:</span> {{ $ibu->tanggal_lahir ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->format('d-m-Y') : '-' }}</div>
            <div><span class="font-semibold text-gray-700">No HP:</span> {{ $ibu->no_hp ?? '-' }}</div>
            <div class="md:col-span-2"><span class="font-semibold text-gray-700">Alamat:</span> {{ $ibu->alamat ?? '-' }}</div>
        </div>

        <!-- Informasi Akun Login -->
        <div class="border-t border-white/30 pt-4">
            <h3 class="text-lg font-semibold text-pink-600 mb-2">🔑 Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><span class="font-semibold text-gray-700">Email:</span> {{ optional($ibu->user)->email ?? '-' }}</div>
                <div><span class="font-semibold text-gray-700">Username:</span> {{ optional($ibu->user)->username ?? '-' }}</div>
                <div><span class="font-semibold text-gray-700">Status Akun:</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ optional($ibu->user)->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ optional($ibu->user)->status ?? '-' }}
                    </span>
                </div>
                <div><span class="font-semibold text-gray-700">Role:</span> {{ optional($ibu->user)->role ?? '-' }}</div>
            </div>
        </div>

        <!-- Daftar Balita -->
        <div class="border-t border-white/30 pt-4 mt-4">
            <h3 class="text-lg font-semibold text-pink-600 mb-2">👶 Daftar Balita</h3>
            @if($ibu->balitas && $ibu->balitas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-white/20 text-sm">
                        <thead class="bg-pink-100/30 backdrop-blur-sm">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">JK</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Tanggal Lahir</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                            @foreach($ibu->balitas as $balita)
                            <tr class="hover:bg-white/20 transition">
                                <td class="px-4 py-2">{{ $balita->nama_balita }}</td>
                                <td class="px-4 py-2">{{ $balita->jenis_kelamin }}</td>
                                <td class="px-4 py-2">{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('balita.show', $balita->id) }}"
                                       class="text-pink-500 hover:text-pink-700 transition font-medium">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">Belum ada balita terdaftar untuk ibu ini.</p>
            @endif
        </div>

    </div>
</div>
@endsection