@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header', '📊 Dashboard Admin')

@section('content')
<div class="container mx-auto">
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Balita</p>
                    <p class="text-2xl font-bold">{{ $totalBalita ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-child text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Ibu</p>
                    <p class="text-2xl font-bold">{{ $totalIbu ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-female text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total User</p>
                    <p class="text-2xl font-bold">{{ $totalUser ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Balita Terbaru -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">📋 Balita Terbaru</h2>
            <a href="{{ route('balita.index') }}" class="text-green-600 hover:text-green-800 text-sm">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">JK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posyandu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($balitas ?? [] as $balita)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $balita->nama_balita ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $balita->jenis_kelamin ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                        <td class="px-6 py-4">{{ optional($balita->ibu)->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4">{{ optional($balita->posyandu)->nama_posyandu ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('balita.show', $balita->id) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data balita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection