@extends('layouts.app')

@section('title', 'Data Balita')
@section('header', '📋 Data Balita')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header: Judul + Tombol Tambah -->
    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <p class="text-gray-600">Manajemen data balita di wilayah kerja Anda.</p>
        <a href="{{ route('balita.create') }}" 
           class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-4 py-2.5 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Balita
        </a>
    </div>

    <!-- Pencarian & Filter -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 mb-6 transition hover:shadow-xl">
        <form action="{{ route('balita.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama atau NIK..." 
                       class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
            </div>
            <div class="w-44">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" 
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                    <option value="">Semua</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non Aktif" {{ request('status') == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                </select>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="submit" 
                        class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('balita.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-undo"></i> Reset
                </a>
                <!-- Tombol Ekspor PDF (tetap merah) -->
                <a href="{{ route('balita.exportPDF', request()->all()) }}" 
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">JK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Tgl Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Posyandu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                    @forelse($balitas as $balita)
                    <tr class="hover:bg-white/20 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $balita->nama_balita ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $balita->nik ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $balita->jenis_kelamin ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ optional($balita->ibu)->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ optional($balita->posyandu)->nama_posyandu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <!-- Lihat -->
                                <a href="{{ route('balita.show', $balita->id) }}" 
                                   class="text-pink-500 hover:text-pink-700 transition" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>
                                <!-- Edit -->
                                <a href="{{ route('balita.edit', $balita->id) }}" 
                                   class="text-yellow-500 hover:text-yellow-700 transition" 
                                   title="Edit">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <!-- Hapus -->
                                <form action="{{ route('balita.destroy', $balita->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 transition" 
                                            title="Hapus">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data balita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-white/20 bg-white/10 backdrop-blur-sm">
            {{ $balitas->links() }}
        </div>
    </div>

</div>
@endsection