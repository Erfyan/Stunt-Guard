@extends('layouts.app')

@section('title', 'Data Ibu')
@section('header', '👩 Data Ibu Hamil / Orang Tua')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <p class="text-gray-600">Manajemen data ibu hamil di wilayah kerja Anda.</p>
        <a href="{{ route('ibu.create') }}"
           class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-4 py-2.5 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Ibu
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-pink-100/80 backdrop-blur-sm border-l-4 border-pink-500 text-pink-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-pink-500 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter & Pencarian -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 mb-6 transition hover:shadow-xl">
        <form action="{{ route('ibu.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Ibu</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau NIK..."
                       class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('ibu.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-undo"></i> Reset
                </a>
                <a href="{{ route('ibu.exportPDF', request()->all()) }}"
                   class="bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Ekspor PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-white/20">
                <thead class="bg-pink-100/30 backdrop-blur-sm">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nama Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">No HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                    @forelse($ibus as $ibu)
                    <tr class="hover:bg-white/20 transition duration-200 {{ $loop->even ? 'bg-white/5' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $ibu->nik }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $ibu->nama_ibu }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $ibu->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ optional($ibu->user)->email ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <!-- Lihat -->
                                <a href="{{ route('ibu.show', $ibu->id) }}"
                                   class="text-pink-500 hover:text-pink-700 transition" title="Lihat Detail">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>
                                <!-- Edit -->
                                <a href="{{ route('ibu.edit', $ibu->id) }}"
                                   class="text-yellow-500 hover:text-yellow-700 transition" title="Edit">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <!-- Hapus -->
                                <form action="{{ route('ibu.destroy', $ibu->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus? Data login akan hilang.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data ibu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-white/20 bg-white/10 backdrop-blur-sm">
            {{ $ibus->links() }}
        </div>
    </div>

</div>
@endsection