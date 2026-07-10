@extends('layouts.app')

@section('title', 'Grafik KMS - ' . $balita->nama_balita)
@section('header', '📈 Grafik KMS - ' . $balita->nama_balita)

@section('content')
<div class="container mx-auto">
    <!-- Informasi Balita -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-wrap justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $balita->nama_balita }}</h3>
                <p class="text-gray-600">
                    NIK: {{ $balita->nik ?? '-' }} | 
                    JK: {{ $balita->jenis_kelamin }} | 
                    Lahir: {{ $balita->tanggal_lahir->format('d-m-Y') }}
                </p>
                <p class="text-gray-500 text-sm">
                    Ibu: {{ optional($balita->ibu)->nama_ibu ?? '-' }} | 
                    Posyandu: {{ optional($balita->posyandu)->nama_posyandu ?? '-' }}
                </p>
            </div>
            <div>
                @php $last = $balita->pemeriksaans->last(); @endphp
                @if($last)
                    <span class="px-3 py-1 rounded text-sm font-bold {{ statusColorClass($last->status_gizi, $last->status_stunting) }}">
                        Status: {{ $last->status_stunting ?? $last->status_gizi ?? 'N/A' }}
                    </span>
                @else
                    <span class="text-gray-400">Belum ada pemeriksaan</span>
                @endif
                <a href="{{ route('kms.index') }}" class="ml-3 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition text-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    @if($balita->pemeriksaans->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Grafik BB/U -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="text-center font-semibold text-gray-700 mb-2">Berat Badan / Umur (BB/U)</h4>
                <canvas id="kmsChartBB" height="250"></canvas>
                <div class="flex flex-wrap justify-center gap-3 mt-2 text-xs">
                    <span class="flex items-center"><span class="w-3 h-3 bg-red-500 mr-1 rounded"></span> Stunting</span>
                    <span class="flex items-center"><span class="w-3 h-3 bg-yellow-500 mr-1 rounded"></span> Risiko</span>
                    <span class="flex items-center"><span class="w-3 h-3 bg-green-500 mr-1 rounded"></span> Normal</span>
                </div>
            </div>

            <!-- Grafik TB/U -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="text-center font-semibold text-gray-700 mb-2">Tinggi Badan / Umur (TB/U)</h4>
                <canvas id="kmsChartTB" height="250"></canvas>
                <div class="flex flex-wrap justify-center gap-3 mt-2 text-xs">
                    <span class="flex items-center"><span class="w-3 h-3 bg-red-500 mr-1 rounded"></span> Stunting</span>
                    <span class="flex items-center"><span class="w-3 h-3 bg-yellow-500 mr-1 rounded"></span> Risiko</span>
                    <span class="flex items-center"><span class="w-3 h-3 bg-green-500 mr-1 rounded"></span> Normal</span>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="bg-white rounded-lg shadow mt-6 p-4">
            <h4 class="font-semibold text-gray-700 mb-3">📋 Riwayat Pemeriksaan</h4>
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Umur</th>
                            <th class="px-4 py-2 text-left">BB (kg)</th>
                            <th class="px-4 py-2 text-left">TB (cm)</th>
                            <th class="px-4 py-2 text-left">Z-Score</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($balita->pemeriksaans->sortByDesc('tanggal') as $p)
                        <tr>
                            <td class="px-4 py-2">{{ $p->tanggal->format('d-m-Y') }}</td>
                            <td class="px-4 py-2">{{ $p->umur_bulan }} bulan</td>
                            <td class="px-4 py-2">{{ $p->berat_badan }}</td>
                            <td class="px-4 py-2">{{ $p->tinggi_badan }}</td>
                            <td class="px-4 py-2">{{ $p->zscore ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-0.5 rounded text-xs font-bold {{ statusColorClass($p->status_gizi, $p->status_stunting) }}">
                                    {{ $p->status_stunting ?? $p->status_gizi ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $p->petugas ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 p-2 bg-gray-50 rounded text-xs text-gray-600">
                💡 <strong>Zona KMS:</strong> 
                <span class="text-red-600">Merah = Z-Score &lt; -2 SD (Stunting)</span> | 
                <span class="text-yellow-600">Kuning = Z-Score -2 s/d -1 SD (Risiko)</span> | 
                <span class="text-green-600">Hijau = Z-Score -1 s/d 2 SD (Normal)</span>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700">Belum ada data pemeriksaan untuk balita ini.</p>
            <a href="{{ route('pemeriksaan.create', $balita->id) }}" class="text-green-600 hover:underline">Tambah Pemeriksaan sekarang</a>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data dari controller
    const labels = @json($chartLabels);
    const dataBB = @json($chartBB);
    const dataTB = @json($chartTB);
    const dataUmur = @json($chartUmur);
    const dataZscore = @json($chartZscore);

    // Fungsi warna titik
    function getColorByZScore(zscore) {
        if (zscore < -3) return '#dc2626';
        if (zscore < -2) return '#ef4444';
        if (zscore < -1) return '#facc15';
        if (zscore <= 2) return '#22c55e';
        return '#f97316';
    }

    // Plugin zona Kemenkes
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

    // Grafik BB/U
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

    // Grafik TB/U
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