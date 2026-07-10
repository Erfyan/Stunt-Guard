@extends('layouts.app')

@section('title', 'KMS Charts')
@section('header', '📈 Grafik KMS')

@section('content')
<div class="container mx-auto">
    <!-- Form Pencarian -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form action="{{ route('kms.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Balita</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama atau NIK..." 
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('kms.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Daftar Balita -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Pilih Balita untuk Lihat Grafik KMS</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">JK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Terakhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($balitas as $balita)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $balita->nama_balita }}</td>
                        <td class="px-6 py-4">{{ $balita->nik ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $balita->jenis_kelamin }}</td>
                        <td class="px-6 py-4">{{ $balita->tanggal_lahir->format('d-m-Y') }}</td>
                        <td class="px-6 py-4">{{ optional($balita->ibu)->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php $last = $balita->pemeriksaans->last(); @endphp
                            @if($last)
                                <span class="px-2 py-0.5 rounded text-xs font-bold {{ statusColorClass($last->status_gizi, $last->status_stunting) }}">
                                    {{ $last->status_stunting ?? $last->status_gizi ?? 'N/A' }}
                                </span>
                            @else
                                <span class="text-gray-400">Belum diukur</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('kms.show', $balita->id) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-chart-line"></i> Lihat Grafik
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data balita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $balitas->links() }}
        </div>
    </div>
</div>
@endsection