@extends('layouts.app')

@section('title', 'Dashboard Kader')
@section('header', '👋 Dashboard Kader')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
            <p class="text-gray-500">Total Balita</p>
            <p class="text-2xl font-bold">{{ $totalBalita ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow border-l-4 border-red-500">
            <p class="text-gray-500">Stunting</p>
            <p class="text-2xl font-bold text-red-600">{{ $stunting ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow border-l-4 border-green-500">
            <p class="text-gray-500">Normal</p>
            <p class="text-2xl font-bold text-green-600">{{ $normal ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow border-l-4 border-yellow-500">
            <p class="text-gray-500">Underweight</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $underweight ?? 0 }}</p>
        </div>
    </div>

    <!-- Grafik Tren -->
    <div class="bg-white p-4 rounded shadow mb-6">
        <h3 class="font-semibold text-gray-700">📈 Tren Stunting 6 Bulan Terakhir</h3>
        <canvas id="trenChart" height="80"></canvas>
    </div>

    <!-- Peringatan -->
    @if(isset($peringatan) && $peringatan->count() > 0)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-6">
        <h3 class="font-bold text-red-700">🚨 Peringatan: Anak dengan Z-Score < -3 SD</h3>
        <ul>
            @foreach($peringatan as $p)
                <li>{{ $p->nama_balita }} ({{ $p->umur_bulan }} bulan) - Terakhir: {{ $p->pemeriksaans->first()->tanggal->format('d-m-Y') }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Daftar Balita -->
    <div class="bg-white rounded shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between">
            <h4 class="font-semibold">📋 Daftar Balita</h4>
            <a href="{{ route('balita.create') }}" class="text-green-600 hover:underline">+ Tambah</a>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">JK</th>
                    <th class="px-4 py-2 text-left">Umur</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($balitas ?? [] as $b)
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
                        @if($last)
                            <span class="px-2 py-0.5 rounded text-xs font-bold {{ statusColorClass($last->status_gizi, $last->status_stunting) }}">
                                {{ $last->status_stunting ?? $last->status_gizi ?? 'N/A' }}
                            </span>
                        @else
                            <span class="text-gray-400">Belum diukur</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('trenChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Jumlah Stunting',
                data: @json($chartData ?? []),
                borderColor: 'red',
                tension: 0.3,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } }
        }
    });
</script>
@endpush
@endsection