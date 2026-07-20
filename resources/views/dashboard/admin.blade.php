@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header', '📊 Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- ============================================= -->
    <!-- KARTU STATISTIK                               -->
    <!-- ============================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-6 md:mb-8">
        <!-- Total Balita -->
        <div class="bg-white/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Balita</p>
                    <p class="text-2xl md:text-3xl font-bold text-pink-800">{{ $totalBalita ?? 0 }}</p>
                    <span class="text-xs text-green-500 font-semibold">+4.2%</span>
                </div>
                <div class="bg-pink-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-child text-pink-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Ibu Hamil -->
        <div class="bg-white/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Ibu Hamil</p>
                    <p class="text-2xl md:text-3xl font-bold text-pink-800">{{ $totalIbu ?? 0 }}</p>
                    <span class="text-xs text-green-500 font-semibold">+1.5%</span>
                </div>
                <div class="bg-pink-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-female text-pink-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Stunting Cases -->
        <div class="bg-white/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Stunting Cases</p>
                    <p class="text-2xl md:text-3xl font-bold text-pink-600">{{ $stuntingCases ?? 0 }}</p>
                    <span class="text-xs text-red-500 font-semibold">15%</span>
                </div>
                <div class="bg-pink-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-exclamation-triangle text-pink-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="bg-white/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total User</p>
                    <p class="text-2xl md:text-3xl font-bold text-pink-800">{{ $totalUser ?? 0 }}</p>
                </div>
                <div class="bg-pink-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-users text-pink-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================= -->
    <!-- GRAFIK TREN & PERINGATAN                     -->
    <!-- ============================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 md:mb-8">
        <!-- Grafik -->
        <div class="lg:col-span-2 bg-pink-100/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl p-5 md:p-6">
            <div class="flex flex-wrap justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">📈 Trend Stunting 2026</h3>
                <span class="text-xs text-gray-500">Persentase prevalensi bulanan</span>
            </div>
            <canvas id="trenChart" height="100"></canvas>
            <div class="flex justify-between text-xs text-gray-500 mt-3">
                <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MEI</span><span>JUN</span>
            </div>
        </div>

        <!-- Peringatan & Reminder -->
        <div class="space-y-4 bg-pink-300/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl p-5 md:p-6">
            <!-- Critical -->
            <div class="bg-red-100/40 backdrop-blur-sm border border-red-200/50 shadow-lg rounded-2xl p-4 md:p-5">
                <div class="flex items-start gap-3">
                    <span class="text-red-600 text-lg font-bold">🚨 CRITICAL</span>
                </div>
                <p class="text-gray-800 font-semibold mt-1">Laila Fitriani</p>
                <p class="text-sm text-gray-600">butuh intervensi gizi segera (Z-Score < -3SD).</p>
                <span class="text-xs text-gray-400 block mt-2">⏱️ 2 Jam yang lalu</span>
            </div>

            <!-- Reminder -->
            <div class="bg-yellow-100/40 backdrop-blur-sm border border-yellow-200/50 shadow-lg rounded-2xl p-4 md:p-5">
                <div class="flex items-start gap-3">
                    <span class="text-yellow-600 text-lg font-bold">📌 REMINDER</span>
                </div>
                <p class="text-gray-800 font-semibold mt-1">Posyandu Flamboyan</p>
                <p class="text-sm text-gray-600">mulai jam 09:00 besok.</p>
                <span class="text-xs text-gray-400 block mt-2">📅 Hari ini, 18:30</span>
            </div>
        </div>
    </div>

    <!-- ============================================= -->
    <!-- TABEL PEMERIKSAAN TERBARU                    -->
    <!-- ============================================= -->
    <div class="bg-white/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl overflow-hidden mb-6 md:mb-8">
        <div class="px-4 py-4 md:px-6 md:py-5 border-b border-pink-300 flex flex-wrap justify-between items-center gap-3">
            <h3 class="text-lg font-semibold text-gray-700">📋 Pemeriksaan Terbaru</h3>
            <a href="{{ route('pemeriksaan.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-xl text-sm font-medium shadow transition flex items-center gap-1">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-white/20">
                <thead class="bg-pink-100/30 backdrop-blur-sm">
                    <tr>
                        <th class="px-4 py-3 md:px-6 md:py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 md:px-6 md:py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Tgl Lahir</th>
                        <th class="px-4 py-3 md:px-6 md:py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">TB (cm)</th>
                        <th class="px-4 py-3 md:px-6 md:py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">BB (kg)</th>
                        <th class="px-4 py-3 md:px-6 md:py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 md:px-6 md:py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-pink-100/10 backdrop-blur-sm divide-y divide-white/10">
                    @forelse($pemeriksaans ?? [] as $p)
                    <tr class="hover:bg-white/20 transition duration-200">
                        <td class="px-4 py-3 md:px-6 md:py-4 text-gray-800 font-medium">{{ $p->balita->nama_balita ?? '-' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-gray-700">{{ optional($p->balita)->tanggal_lahir ? \Carbon\Carbon::parse($p->balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-gray-700">{{ $p->tinggi_badan ?? '-' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-gray-700">{{ $p->berat_badan ?? '-' }}</td>
                        <td class="px-4 py-3 md:px-6 md:py-4">
                            @php
                                $status = $p->status_gizi ?? 'N/A';
                                $color = match($status) {
                                    'Normal' => 'bg-green-100 text-green-800',
                                    'Stunting', 'Severely Stunted' => 'bg-red-100 text-red-800',
                                    'Underweight', 'Severely Underweight' => 'bg-yellow-100 text-yellow-800',
                                    'Wasting', 'Severely Wasted' => 'bg-orange-100 text-orange-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">{{ $status }}</span>
                        </td>
                        <td class="px-4 py-3 md:px-6 md:py-4">
                            <a href="{{ route('balita.show', $p->balita_id) }}" class="text-pink-500 hover:text-pink-700 transition" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 md:px-6 md:py-4 text-center text-gray-500 italic">Belum ada pemeriksaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ============================================= -->
    <!-- AKTIVITAS WILAYAH                            -->
    <!-- ============================================= -->
    <div class="bg-pink-100/20 backdrop-blur-md border border-pink-300 shadow-lg rounded-2xl p-5 md:p-6">
        <h3 class="text-lg font-semibold text-pink-500 mb-4">📍 Aktivitas Wilayah</h3>
            <div class="space-y-4">
                @foreach($posyanduStats ?? [] as $stat)
                    <div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium text-gray-700">{{ $stat['nama'] }}</span>
                            <span class="text-pink-500 font-bold">{{ $stat['stunted_percent'] }}%</span>
                        </div>
                        <div class="w-full bg-white/30 rounded-full h-2.5 mt-1">
                            <div class="bg-pink-500 h-2.5 rounded-full" style="width:{{ $stat['stunted_percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trenChart');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN'],
                    datasets: [{
                        label: 'Stunting',
                        data: [12, 15, 10, 18, 14, 20],
                        borderColor: '#f472b6',
                        backgroundColor: 'rgba(244, 114, 182, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#f472b6',
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection