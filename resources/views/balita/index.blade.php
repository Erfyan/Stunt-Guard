@extends('layouts.app')

@section('title', 'Data Balita')
@section('header', '📋 Data Balita')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600">Manajemen data balita di wilayah kerja Anda.</p>
        <a href="{{ route('balita.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Balita
        </a>
    </div>

    <!-- Card Tabel -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posyandu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($balitas as $balita)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $balita->nama_balita ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $balita->nik ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $balita->jenis_kelamin ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ optional($balita->ibu)->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ optional($balita->posyandu)->nama_posyandu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <a href="{{ route('balita.show', $balita->id) }}">Lihat</a>
                            <a href="{{ route('balita.edit', $balita->id) }}">Edit</a>
                            <form action="{{ route('balita.destroy', $balita->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data balita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection