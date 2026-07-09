@extends('layouts.app')

@section('title', 'Laporan Rekapitulasi')
@section('header', '📊 Laporan Stunting')

@section('content')
<div class="container mx-auto">
    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="w-64">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Posyandu</label>
                <select name="posyandu_id" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Posyandu</option>
                    @foreach($posyandus as $p)
                        <option value="{{ $p->id }}" {{ request('posyandu_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_posyandu }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>
                <a href="{{ route('laporan.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition">
                    Reset
                </a>
                <!-- Tombol Ekspor PDF -->
                <a href="{{ route('laporan.exportPDF', request()->all()) }}" 
                style="display:inline-block !important; background:red !important; color:white !important; padding:10px 20px !important; border-radius:8px !important; font-weight:bold !important;">
                    <i class="fas fa-file-pdf"></i> Ekspor PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Rekapitulasi -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Rekapitulasi Status Gizi per Posyandu</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posyandu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Balita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stunting</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Normal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Underweight</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Wasting</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Belum Diukur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataPerPosyandu as $posyanduId => $data)
                        @php $posyandu = $posyandus->firstWhere('id', $posyanduId); @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $posyandu ? $posyandu->nama_posyandu : 'Posyandu tidak ditemukan' }}</td>
                            <td class="px-6 py-4">{{ $data['total'] }}</td>
                            <td class="px-6 py-4 text-red-600">{{ $data['stunting'] }}</td>
                            <td class="px-6 py-4 text-green-600">{{ $data['normal'] }}</td>
                            <td class="px-6 py-4 text-yellow-600">{{ $data['underweight'] }}</td>
                            <td class="px-6 py-4 text-orange-600">{{ $data['wasting'] }}</td>
                            <td class="px-6 py-4">{{ $data['total'] - ($data['stunting'] + $data['normal'] + $data['underweight'] + $data['wasting']) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-gray-500">Belum ada data balita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
