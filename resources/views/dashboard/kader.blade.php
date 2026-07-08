@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">👋 Halo, {{ Auth::user()->nama }}</h1>
    <p class="text-gray-600 mb-6">Selamat datang di dashboard Kader Posyandu.</p>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded shadow">
            <h3 class="font-semibold">Total Balita</h3>
            <p class="text-2xl font-bold">{{ $totalBalita ?? 0 }}</p>
        </div>
        <div class="bg-green-100 p-4 rounded shadow">
            <h3 class="font-semibold">Total Ibu</h3>
            <p class="text-2xl font-bold">{{ $totalIbu ?? 0 }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded shadow">
            <h3 class="font-semibold">Posyandu</h3>
            <p class="text-2xl font-bold">{{ Auth::user()->posyandu->nama_posyandu ?? 'Belum ditentukan' }}</p>
        </div>
    </div>

    <!-- Daftar Balita -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold">📋 Daftar Balita</h2>
            <a href="{{ route('balita.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">+ Tambah</a>
        </div>
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">JK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ibu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($balitas as $balita)
                <tr>
                    <td class="px-6 py-4">{{ $balita->nama_balita ?? $balita->nama ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $balita->jenis_kelamin ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($balita->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ optional($balita->ibu)->nama_ibu ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('balita.show', $balita) }}" class="text-blue-600 hover:underline">Lihat</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-gray-500">Belum ada data balita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection