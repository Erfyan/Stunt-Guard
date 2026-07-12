@extends('layouts.app')

@section('title', 'Detail Balita')
@section('header', '👶 Detail Balita')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Card Utama -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-6 transition hover:shadow-xl">

        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center border-b border-white/30 pb-4 mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $balita->nama_balita ?? '-' }}</h2>
                <p class="text-gray-600">NIK: {{ $balita->nik ?? '-' }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('balita.edit', $balita->id) }}" 
                   class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-xl shadow transition flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('balita.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium px-4 py-2 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi Balita -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div><span class="font-semibold text-gray-700">Nama:</span> {{ $balita->nama_balita ?? '-' }}</div>
            <div><span class="font-semibold text-gray-700">NIK:</span> {{ $balita->nik ?? '-' }}</div>
            <div><span class="font-semibold text-gray-700">Jenis Kelamin:</span> {{ $balita->jenis_kelamin ?? '-' }}</div>
            <div><span class="font-semibold text-gray-700">Tanggal Lahir:</span> {{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</div>
            <div><span class="font-semibold text-gray-700">Umur:</span> {{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now()) . ' bulan' : '-' }}</div>
            <div><span class="font-semibold text-gray-700">Berat Lahir:</span> {{ $balita->berat_lahir ?? '-' }} kg</div>
            <div><span class="font-semibold text-gray-700">Panjang Lahir:</span> {{ $balita->panjang_lahir ?? '-' }} cm</div>
            <div>
                <span class="font-semibold text-gray-700">Status:</span>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $balita->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $balita->status ?? '-' }}
                </span>
            </div>
        </div>

        <!-- Informasi Ibu -->
        <div class="border-t border-white/30 pt-4">
            <h3 class="text-lg font-semibold text-pink-600 mb-2">👩 Informasi Ibu</h3>
            @if($balita->ibu)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><span class="font-semibold text-gray-700">Nama Ibu:</span> {{ $balita->ibu->nama_ibu ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-700">NIK Ibu:</span> {{ $balita->ibu->nik ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-700">No HP:</span> {{ $balita->ibu->no_hp ?? '-' }}</div>
                </div>
            @else
                <p class="text-gray-500 italic">Data ibu tidak tersedia.</p>
            @endif
        </div>

        <!-- Informasi Posyandu -->
        <div class="border-t border-white/30 pt-4 mt-4">
            <h3 class="text-lg font-semibold text-pink-600 mb-2">🏥 Informasi Posyandu</h3>
            @if($balita->posyandu)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><span class="font-semibold text-gray-700">Nama Posyandu:</span> {{ $balita->posyandu->nama_posyandu ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-700">Desa/Kelurahan:</span> {{ $balita->posyandu->desa ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-700">Kecamatan:</span> {{ $balita->posyandu->kecamatan ?? '-' }}</div>
                </div>
            @else
                <p class="text-gray-500 italic">Data posyandu tidak tersedia.</p>
            @endif
        </div>

        <!-- ===== GRAFIK KMS ===== -->
        <div class="mt-6 border-t border-white/30 pt-4">
            <div class="flex flex-wrap justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-pink-600">📈 Grafik Pertumbuhan (KMS)</h3>
                <span class="text-xs text-gray-500">Sumber: Standar WHO 2005 (Kemenkes RI)</span>
            </div>

            @if($balita->pemeriksaans->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Grafik BB/U -->
                    <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-2xl p-4 shadow-md">
                        <h4 class="text-sm font-medium text-gray-700 mb-2 text-center">Berat Badan / Umur (BB/U)</h4>
                        <canvas id="kmsChartBB" height="220"></canvas>
                        <div class="flex justify-center gap-4 mt-2 text-xs">
                            <span class="flex items-center"><span class="w-3 h-3 bg-red-400 mr-1 rounded"></span> Stunting</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-yellow-400 mr-1 rounded"></span> Risiko</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-green-400 mr-1 rounded"></span> Normal</span>
                        </div>
                    </div>

                    <!-- Grafik TB/U -->
                    <div class="bg-white/30 backdrop-blur-sm border border-white/30 rounded-2xl p-4 shadow-md">
                        <h4 class="text-sm font-medium text-gray-700 mb-2 text-center">Tinggi Badan / Umur (TB/U)</h4>
                        <canvas id="kmsChartTB" height="220"></canvas>
                        <div class="flex justify-center gap-4 mt-2 text-xs">
                            <span class="flex items-center"><span class="w-3 h-3 bg-red-400 mr-1 rounded"></span> Stunting</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-yellow-400 mr-1 rounded"></span> Risiko</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-green-400 mr-1 rounded"></span> Normal</span>
                        </div>
                    </div>
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

        <!-- ===== RIWAYAT PEMERIKSAAN ===== -->
        <div class="mt-6 border-t border-white/30 pt-4">
            <h3 class="text-lg font-semibold text-pink-600 mb-4">📋 Riwayat Pemeriksaan</h3>

            @if($balita->pemeriksaans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-white/20 text-sm">
                        <thead class="bg-pink-100/30 backdrop-blur-sm">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Umur</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">BB (kg)</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">TB (cm)</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Z-Score</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                            @foreach($balita->pemeriksaans->sortByDesc('tanggal') as $p)
                            <tr class="hover:bg-white/20 transition duration-200 {{ $loop->even ? 'bg-white/5' : '' }}">
                                <td class="px-4 py-2">{{ $p->tanggal->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">{{ $p->umur_bulan }} bulan</td>
                                <td class="px-4 py-2">{{ $p->berat_badan }}</td>
                                <td class="px-4 py-2">{{ $p->tinggi_badan }}</td>
                                <td class="px-4 py-2">{{ $p->zscore ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ statusColorClass($p->status_gizi, $p->status_stunting) }}">
                                        {{ $p->status_stunting ?? $p->status_gizi ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $p->petugas ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Keterangan Zona -->
                <div class="mt-3 p-3 bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl text-xs text-gray-600">
                    <p>💡 <strong>Keterangan Zona:</strong>
                        <span class="text-red-600">Merah = Z-Score &lt; -2 SD (Stunting)</span> |
                        <span class="text-yellow-600">Kuning = Z-Score -2 s/d -1 SD (Risiko)</span> |
                        <span class="text-green-600">Hijau = Z-Score -1 s/d 2 SD (Normal)</span>
                    </p>
                    <p class="mt-1">📌 <strong>Sumber:</strong> Standar WHO 2005 (Permenkes No. 2 Tahun 2020)</p>
                </div>
            @else
                <p class="text-gray-500 italic">Belum ada pemeriksaan.</p>
            @endif
        </div>

    </div> <!-- End Card Utama -->
</div>

<!-- ===== SCRIPTS ===== -->
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
@endsection