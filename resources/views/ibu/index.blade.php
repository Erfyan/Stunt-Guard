@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">👩 Data Ibu Hamil / Orang Tua</h1>
        <a href="{{ route('ibu.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Tambah Ibu
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Ibu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No HP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($ibus as $ibu)
                <tr>
                    <td class="px-6 py-4">{{ $ibu->nik }}</td>
                    <td class="px-6 py-4">{{ $ibu->nama_ibu }}</td>
                    <td class="px-6 py-4">{{ $ibu->no_hp ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $ibu->user->email ?? '-' }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('ibu.show', $ibu) }}" class="text-blue-600 hover:text-blue-800">Lihat</a>
                        <a href="{{ route('ibu.edit', $ibu) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                        <form action="{{ route('ibu.destroy', $ibu) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menghapus? Data login akan hilang.')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data Ibu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection