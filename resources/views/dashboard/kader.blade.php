@extends('layouts.app')

@section('title', 'Dashboard Kader')
@section('header', '👋 Dashboard Kader')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- ===== STATISTIK KARTU ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-6 md:mb-8">
        <!-- Total Balita -->
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Balita</p>
                    <p class="text-2xl md:text-3xl font-bold text-pink-800">{{ $totalBalita ?? 0 }}</p>
                </div>
                <div class="bg-pink-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-child text-pink-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Stunting -->
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Stunting</p>
                    <p class="text-2xl md:text-3xl font-bold text-red-600">{{ $stunting ?? 0 }}</p>
                </div>
                <div class="bg-red-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Normal -->
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Normal</p>
                    <p class="text-2xl md:text-3xl font-bold text-green-600">{{ $normal ?? 0 }}</p>
                </div>
                <div class="bg-green-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Underweight -->
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 md:p-6 transition hover:shadow-xl hover:scale-[1.02]">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Underweight</p>
                    <p class="text-2xl md:text-3xl font-bold text-yellow-600">{{ $underweight ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100/60 backdrop-blur-sm p-3 rounded-full shadow-inner">
                    <i class="fas fa-weight text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== GRAFIK TREN ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 md:p-6 mb-6 transition hover:shadow-xl">
        <h3 class="text-lg font-semibold text-pink-600 mb-4">📈 Tren Stunting 6 Bulan Terakhir</h3>
        <canvas id="trenChart" height="80"></canvas>
    </div>

    <!-- ===== AKSI CEPAT LAPORAN ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 md:p-6 mb-6 transition hover:shadow-xl flex flex-wrap justify-between items-center gap-4">
        <div>
            <h3 class="text-lg font-semibold text-pink-600">📊 Laporan Stunting</h3>
            <p class="text-sm text-gray-600">Lihat rekap data dan analisis stunting di posyandu Anda.</p>
        </div>
        <a href="{{ route('laporan.index') }}" 
           class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-5 py-2.5 rounded-xl shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-pink-500 transition flex items-center gap-2">
            <i class="fas fa-file-alt"></i> Lihat Laporan
        </a>
    </div>

    <!-- ===== PERINGATAN ===== -->
    @if(isset($peringatan) && $peringatan->count() > 0)
    <div class="bg-red-100/40 backdrop-blur-sm border border-red-200/50 shadow-lg rounded-2xl p-4 md:p-5 mb-6 transition hover:shadow-xl">
        <h3 class="font-bold text-red-700 flex items-center gap-2">
            <i class="fas fa-bell text-red-600"></i> Peringatan: Anak dengan Z-Score &lt; -3 SD
        </h3>
        <ul class="mt-2 space-y-1 text-sm text-gray-700">
            @foreach($peringatan as $p)
                <li class="flex items-center gap-2">
                    <i class="fas fa-circle text-red-500 text-[6px]"></i>
                    <strong>{{ $p->nama_balita }}</strong> ({{ $p->umur_bulan }} bulan)
                    – Terakhir: {{ $p->pemeriksaans->first()->tanggal->format('d-m-Y') }}
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- ===== DAFTAR BALITA ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/30 flex justify-between items-center">
            <h4 class="text-lg font-semibold text-pink-600">📋 Daftar Balita</h4>
            <a href="{{ route('balita.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white text-sm font-medium px-4 py-2 rounded-xl shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-pink-500 transition flex items-center gap-1">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-white/20 text-sm">
                <thead class="bg-pink-100/30 backdrop-blur-sm">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">JK</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Umur</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                    @forelse($balitas ?? [] as $b)
                    <tr class="hover:bg-white/20 transition duration-200 {{ $loop->even ? 'bg-white/5' : '' }}">
                        <td class="px-4 py-3 whitespace-nowrap text-gray-800">{{ $b->nama_balita ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $b->jenis_kelamin ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                            {{ $b->tanggal_lahir ? \Carbon\Carbon::parse($b->tanggal_lahir)->diffInMonths(now()) . ' bulan' : '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php $last = $b->pemeriksaans->last(); @endphp
                            @if($last)
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ statusColorClass($last->status_gizi, $last->status_stunting) }}">
                                    {{ $last->status_stunting ?? $last->status_gizi ?? 'N/A' }}
                                </span>
                            @else
                                <span class="text-gray-400">Belum diukur</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="{{ route('balita.show', $b->id) }}" class="text-pink-500 hover:text-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 rounded p-1 transition" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">Tidak ada data balita.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trenChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels ?? []),
                datasets: [{
                    label: 'Jumlah Stunting',
                    data: @json($chartData ?? []),
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
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection