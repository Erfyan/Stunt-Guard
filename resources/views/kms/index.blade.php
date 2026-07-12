@extends('layouts.app')

@section('title', 'KMS Charts')
@section('header', '📈 Grafik KMS')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- ===== FORM PENCARIAN ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 mb-6 transition hover:shadow-xl">
        <form action="{{ route('kms.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Balita</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau NIK..."
                       class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('kms.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===== DAFTAR BALITA ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/30">
            <h2 class="text-lg font-semibold text-pink-600">👶 Pilih Balita untuk Lihat Grafik KMS</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-white/20">
                <thead class="bg-pink-100/30 backdrop-blur-sm">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">JK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Tgl Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                    @forelse($balitas as $b)
                    <tr class="hover:bg-white/20 transition duration-200 {{ $loop->even ? 'bg-white/5' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $b->nama_balita }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $b->nik ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $b->jenis_kelamin }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $b->tanggal_lahir->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ optional($b->ibu)->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $last = $b->pemeriksaans->last(); @endphp
                            @if($last)
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ statusColorClass($last->status_gizi, $last->status_stunting) }}">
                                    {{ $last->status_stunting ?? $last->status_gizi ?? 'N/A' }}
                                </span>
                            @else
                                <span class="text-gray-400">Belum diukur</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('kms.index', ['id' => $b->id, 'search' => request('search')]) }}"
                               class="text-pink-500 hover:text-pink-700 transition font-medium flex items-center gap-1">
                                <i class="fas fa-chart-line"></i> Lihat Grafik
                            </a>
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
        <div class="px-6 py-4 border-t border-white/20 bg-white/10 backdrop-blur-sm">
            {{ $balitas->links() }}
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- ===== GRAFIK (muncul jika ada parameter id) ===== -->
    <!-- ========================================================= -->
    @if($balita)
    <div class="mt-8">

        <!-- Informasi Balita (sama seperti sebelumnya) -->
        <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Nama & ID -->
                <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-2xl p-4 shadow-md">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Nama & ID</p>
                    <p class="text-lg font-bold text-gray-800">{{ $balita->nama_balita }}</p>
                    <p class="text-sm text-gray-600">#BLT-{{ str_pad($balita->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>

                <!-- Usia & Kelamin -->
                <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-2xl p-4 shadow-md">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Usia & Kelamin</p>
                    <p class="text-lg font-bold text-gray-800">{{ $balita->umur_bulan }} Bulan</p>
                    <p class="text-sm text-gray-600">{{ $balita->jenis_kelamin }}</p>
                </div>

                <!-- Berat & Tinggi -->
                <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-2xl p-4 shadow-md">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Berat & Tinggi</p>
                    @php $last = $balita->pemeriksaans->last(); @endphp
                    <p class="text-lg font-bold text-gray-800">{{ $last ? $last->berat_badan : '-' }} Kg</p>
                    <p class="text-sm text-gray-600">{{ $last ? $last->tinggi_badan : '-' }} Cm</p>
                    @if($last)
                        <p class="text-xs text-gray-400">Terakhir: {{ $last->tanggal->format('d M Y') }}</p>
                    @endif
                </div>

                <!-- Status Gizi -->
                <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-2xl p-4 shadow-md">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Status Gizi</p>
                    @if($last)
                        <span class="text-lg font-bold {{ statusColorClass($last->status_gizi, $last->status_stunting) }}">
                            {{ $last->status_gizi ?? 'N/A' }}
                        </span>
                        <p class="text-sm text-gray-600">Sesuai Grafik KMS</p>
                    @else
                        <p class="text-gray-400">Belum ada pemeriksaan</p>
                    @endif
                </div>
            </div>

            <!-- Grafik -->
            @if($balita->pemeriksaans->count() > 0)
                <div class="mb-6">
                    <div class="flex flex-wrap justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-pink-600">Berat Badan menurut Umur (KMS)</h3>
                        <span class="text-xs text-gray-500">Grafik pemantauan pertumbuhan balita (0–60 Bulan)</span>
                    </div>
                    <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-2xl p-4 shadow-md">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- BB/U -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2 text-center">Berat Badan / Umur (BB/U)</h4>
                                <canvas id="kmsChartBB" height="200"></canvas>
                                <div class="flex justify-center gap-4 mt-2 text-xs">
                                    <span class="flex items-center"><span class="w-3 h-3 bg-red-400 mr-1 rounded"></span> Stunting</span>
                                    <span class="flex items-center"><span class="w-3 h-3 bg-yellow-400 mr-1 rounded"></span> Risiko</span>
                                    <span class="flex items-center"><span class="w-3 h-3 bg-green-400 mr-1 rounded"></span> Normal</span>
                                </div>
                            </div>
                            <!-- TB/U -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2 text-center">Tinggi Badan / Umur (TB/U)</h4>
                                <canvas id="kmsChartTB" height="200"></canvas>
                                <div class="flex justify-center gap-4 mt-2 text-xs">
                                    <span class="flex items-center"><span class="w-3 h-3 bg-red-400 mr-1 rounded"></span> Stunting</span>
                                    <span class="flex items-center"><span class="w-3 h-3 bg-yellow-400 mr-1 rounded"></span> Risiko</span>
                                    <span class="flex items-center"><span class="w-3 h-3 bg-green-400 mr-1 rounded"></span> Normal</span>
                                </div>
                            </div>
                        </div>
                        <!-- Info pertumbuhan -->
                        <div class="mt-4 p-3 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                            <div class="flex flex-wrap justify-between text-sm">
                                <span><strong>{{ $balita->umur_bulan }} Bulan (Hari ini)</strong></span>
                                <span><strong>Berat: {{ $last ? $last->berat_badan : '-' }} Kg</strong></span>
                                <span><strong>Status: {{ $last ? $last->status_gizi : '-' }}</strong></span>
                            </div>
                            <div class="flex flex-wrap gap-4 mt-1 text-xs text-gray-600">
                                <span class="flex items-center"><span class="w-3 h-3 bg-green-400 mr-1 rounded"></span> Zona Hijau (Normal)</span>
                                <span class="flex items-center"><span class="w-3 h-3 bg-yellow-400 mr-1 rounded"></span> Risiko Berat Kurang</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat -->
                <div class="mt-6 border-t border-white/30 pt-4">
                    <h3 class="text-lg font-semibold text-pink-600 mb-4">📋 Riwayat Pengukuran</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-white/20 text-sm">
                            <thead class="bg-pink-100/30 backdrop-blur-sm">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Usia</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Berat (Kg)</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Tinggi (Cm)</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Petugas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                                @foreach($balita->pemeriksaans->sortByDesc('tanggal') as $p)
                                <tr class="hover:bg-white/20 transition {{ $loop->even ? 'bg-white/5' : '' }}">
                                    <td class="px-4 py-2">{{ $p->tanggal->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ $p->umur_bulan }} Bulan</td>
                                    <td class="px-4 py-2">{{ $p->berat_badan }}</td>
                                    <td class="px-4 py-2">{{ $p->tinggi_badan }}</td>
                                    <td class="px-4 py-2">{{ $p->petugas ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2 text-right">
                        <a href="#" class="text-sm text-pink-500 hover:text-pink-700 transition">Lihat Semua →</a>
                    </div>
                </div>

                <!-- Saran Kesehatan -->
                <div class="mt-6 border-t border-white/30 pt-4">
                    <h3 class="text-lg font-semibold text-pink-600 mb-2">💡 Saran Kesehatan</h3>
                    @if($last)
                        <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl p-4">
                            <p class="text-gray-700">
                                Pertumbuhan <strong>{{ $balita->nama_balita }}</strong> berada di jalur yang sangat baik.
                                Pertahankan asupan protein hewani untuk mengoptimalkan tinggi badannya.
                            </p>
                            <ul class="list-disc list-inside text-sm text-gray-600 mt-2 space-y-1">
                                <li>Berikan ASI/Susu 2–3 gelas per hari</li>
                                <li>Cukupi sayuran berdaun hijau</li>
                            </ul>
                            <a href="#" class="mt-2 inline-block text-pink-500 hover:text-pink-700 text-sm font-medium transition">
                                Buka Artikel Parenting →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Data pemeriksaan belum tersedia untuk memberikan saran.</p>
                    @endif
                </div>

                <!-- Tombol Kembali ke Daftar -->
                <div class="mt-4 text-center">
                    <a href="{{ route('kms.index') }}" class="text-pink-500 hover:text-pink-700 font-medium transition">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>

            @else
                <div class="bg-yellow-100/50 backdrop-blur-sm border-l-4 border-yellow-400 p-4 rounded-xl">
                    <p class="text-yellow-700">Belum ada data pemeriksaan untuk balita ini.</p>
                    <a href="{{ route('pemeriksaan.create', $balita->id) }}" class="text-pink-500 hover:text-pink-700 font-medium transition">
                        <i class="fas fa-plus"></i> Tambah Pemeriksaan
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>

<!-- ========================================================= -->
<!-- ===== SCRIPTS (Chart.js) – hanya jika ada balita ===== -->
<!-- ========================================================= -->
@if($balita)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json($chartLabels);
    const dataBB = @json($chartBB);
    const dataTB = @json($chartTB);
    const dataUmur = @json($chartUmur);
    const dataZscore = @json($chartZscore);

    function getColorByZScore(zscore) {
        if (zscore < -3) return '#dc2626';
        if (zscore < -2) return '#ef4444';
        if (zscore < -1) return '#facc15';
        if (zscore <= 2) return '#22c55e';
        return '#f97316';
    }

    const zonePlugin = {
        id: 'zonePlugin',
        beforeDraw: function(chart) {
            const ctx = chart.ctx;
            const chartArea = chart.chartArea;
            const yScale = chart.scales.y;
            if (!yScale) return;

            const zones = [
                { min: -Infinity, max: -3, color: 'rgba(220, 38, 38, 0.15)' },
                { min: -3, max: -2, color: 'rgba(239, 68, 68, 0.15)' },
                { min: -2, max: -1, color: 'rgba(250, 204, 21, 0.15)' },
                { min: -1, max: 2, color: 'rgba(34, 197, 94, 0.15)' },
                { min: 2, max: Infinity, color: 'rgba(249, 115, 22, 0.15)' },
            ];

            zones.forEach(zone => {
                const yMin = yScale.getPixelForValue(zone.min);
                const yMax = yScale.getPixelForValue(zone.max);
                const top = Math.min(yMin, yMax);
                const bottom = Math.max(yMin, yMax);
                if (top < chartArea.top || bottom > chartArea.bottom) return;
                ctx.fillStyle = zone.color;
                ctx.fillRect(
                    chartArea.left,
                    Math.max(top, chartArea.top),
                    chartArea.right - chartArea.left,
                    Math.min(bottom, chartArea.bottom) - Math.max(top, chartArea.top)
                );
            });
        }
    };

    const ctxBB = document.getElementById('kmsChartBB');
    if (ctxBB && labels.length > 0) {
        const pointColorsBB = dataZscore.map(z => getColorByZScore(z));
        new Chart(ctxBB, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Berat Badan (kg)',
                    data: dataBB,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: pointColorsBB,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                return [
                                    'BB: ' + context.parsed.y + ' kg',
                                    'Umur: ' + (dataUmur[idx] || '?') + ' bulan',
                                    'Z-Score: ' + (dataZscore[idx] || '?')
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Berat (kg)' } },
                    x: { title: { display: true, text: 'Tanggal' } }
                }
            },
            plugins: [zonePlugin]
        });
    }

    const ctxTB = document.getElementById('kmsChartTB');
    if (ctxTB && labels.length > 0) {
        const pointColorsTB = dataZscore.map(z => getColorByZScore(z));
        new Chart(ctxTB, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tinggi Badan (cm)',
                    data: dataTB,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: pointColorsTB,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                return [
                                    'TB: ' + context.parsed.y + ' cm',
                                    'Umur: ' + (dataUmur[idx] || '?') + ' bulan',
                                    'Z-Score: ' + (dataZscore[idx] || '?')
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Tinggi (cm)' } },
                    x: { title: { display: true, text: 'Tanggal' } }
                }
            },
            plugins: [zonePlugin]
        });
    }
});
</script>
@endpush
@endif
@endsection