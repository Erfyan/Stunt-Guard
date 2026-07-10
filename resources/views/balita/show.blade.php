@extends('layouts.app')

@section('title', 'Detail Balita')
@section('header', '👶 Detail Balita')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $balita->nama_balita ?? '-' }}</h2>
                <p class="text-gray-500">NIK: {{ $balita->nik ?? '-' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('balita.edit', $balita->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow transition">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('balita.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded shadow transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi Balita -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div><span class="font-semibold">Nama:</span> {{ $balita->nama_balita ?? '-' }}</div>
            <div><span class="font-semibold">NIK:</span> {{ $balita->nik ?? '-' }}</div>
            <div><span class="font-semibold">Jenis Kelamin:</span> {{ $balita->jenis_kelamin ?? '-' }}</div>
            <div><span class="font-semibold">Tanggal Lahir:</span> {{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</div>
            <div><span class="font-semibold">Umur:</span> {{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->diffInMonths(now()) . ' bulan' : '-' }}</div>
            <div><span class="font-semibold">Berat Lahir:</span> {{ $balita->berat_lahir ?? '-' }} kg</div>
            <div><span class="font-semibold">Panjang Lahir:</span> {{ $balita->panjang_lahir ?? '-' }} cm</div>
            <div><span class="font-semibold">Status:</span> 
                <span class="px-2 py-1 rounded text-xs font-semibold {{ $balita->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $balita->status ?? '-' }}
                </span>
            </div>
        </div>

        <!-- Informasi Ibu -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">👩 Informasi Ibu</h3>
            @if($balita->ibu)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><span class="font-semibold">Nama Ibu:</span> {{ $balita->ibu->nama_ibu ?? '-' }}</div>
                    <div><span class="font-semibold">NIK Ibu:</span> {{ $balita->ibu->nik ?? '-' }}</div>
                    <div><span class="font-semibold">No HP:</span> {{ $balita->ibu->no_hp ?? '-' }}</div>
                </div>
            @else
                <p class="text-gray-500">Data ibu tidak tersedia.</p>
            @endif
        </div>

        <!-- Informasi Posyandu -->
        <div class="border-t pt-4 mt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">🏥 Informasi Posyandu</h3>
            @if($balita->posyandu)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><span class="font-semibold">Nama Posyandu:</span> {{ $balita->posyandu->nama_posyandu ?? '-' }}</div>
                    <div><span class="font-semibold">Desa/Kelurahan:</span> {{ $balita->posyandu->desa ?? '-' }}</div>
                    <div><span class="font-semibold">Kecamatan:</span> {{ $balita->posyandu->kecamatan ?? '-' }}</div>
                </div>
            @else
                <p class="text-gray-500">Data posyandu tidak tersedia.</p>
            @endif
        </div>

        <!-- ===== GRAFIK KMS ===== -->
        <div class="mt-6 border-t pt-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">📈 Grafik Pertumbuhan (KMS)</h3>
                <span class="text-xs text-gray-500">Sumber: Standar WHO 2005 (Kemenkes RI)</span>
            </div>

            @if($balita->pemeriksaans->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Grafik BB/U -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Berat Badan / Umur (BB/U)</h4>
                        <canvas id="kmsChartBB" height="220"></canvas>
                        <div class="flex justify-center gap-4 mt-2 text-xs">
                            <span class="flex items-center"><span class="w-3 h-3 bg-red-400 mr-1 rounded"></span> Stunting</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-yellow-400 mr-1 rounded"></span> Risiko</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-green-400 mr-1 rounded"></span> Normal</span>
                        </div>
                    </div>

                    <!-- Grafik TB/U -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Tinggi Badan / Umur (TB/U)</h4>
                        <canvas id="kmsChartTB" height="220"></canvas>
                        <div class="flex justify-center gap-4 mt-2 text-xs">
                            <span class="flex items-center"><span class="w-3 h-3 bg-red-400 mr-1 rounded"></span> Stunting</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-yellow-400 mr-1 rounded"></span> Risiko</span>
                            <span class="flex items-center"><span class="w-3 h-3 bg-green-400 mr-1 rounded"></span> Normal</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <p class="text-yellow-700">Belum ada data pemeriksaan untuk balita ini.</p>
                    <a href="{{ route('pemeriksaan.create', $balita->id) }}" class="text-green-600 hover:underline">
                        Tambah Pemeriksaan sekarang
                    </a>
                </div>
            @endif
        </div>

<!-- ===== RIWAYAT PEMERIKSAAN ===== -->
<div class="mt-6 border-t pt-4">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">📋 Riwayat Pemeriksaan</h3>
    
    @if($balita->pemeriksaans->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Umur</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">BB (kg)</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">TB (cm)</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Z-Score</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($balita->pemeriksaans->sortByDesc('tanggal') as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm">{{ $p->tanggal->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 text-sm">{{ $p->umur_bulan }} bulan</td>
                        <td class="px-4 py-2 text-sm">{{ $p->berat_badan }}</td>
                        <td class="px-4 py-2 text-sm">{{ $p->tinggi_badan }}</td>
                        <td class="px-4 py-2 text-sm">{{ $p->zscore ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">
                            @php
    // Normalisasi status untuk warna
    $isStunting = in_array($p->status_stunting, ['Stunted', 'Severely Stunted']);
    $isUnderweight = in_array($p->status_gizi, ['Underweight', 'Severely Underweight']);
    $isNormal = ($p->status_gizi == 'Normal' && $p->status_stunting == 'Normal');
    $isOverweight = ($p->status_gizi == 'Overweight / Obese');
@endphp
                        <span class="px-2 py-0.5 rounded text-xs font-bold {{ statusColorClass($p->status_gizi, $p->status_stunting) }}">
                            {{ $p->status_stunting ?? $p->status_gizi ?? 'N/A' }}
                        </span>
                        </td>
                        <td class="px-4 py-2 text-sm">{{ $p->petugas ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Informasi tambahan -->
        <div class="mt-3 p-3 bg-gray-50 rounded text-xs text-gray-600">
            <p>💡 <strong>Keterangan Zona:</strong> 
                <span class="text-red-600">Merah = Z-Score &lt; -2 SD (Stunting)</span> | 
                <span class="text-yellow-600">Kuning = Z-Score -2 s/d -1 SD (Risiko)</span> | 
                <span class="text-green-600">Hijau = Z-Score -1 s/d 2 SD (Normal)</span>
            </p>
            <p class="mt-1">📌 <strong>Sumber:</strong> Standar WHO 2005 (Permenkes No. 2 Tahun 2020)</p>
        </div>
    @else
        <p class="text-gray-500">Belum ada pemeriksaan.</p>
    @endif
</div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // 1. Data dari Controller
    // ========================================
    const labels = @json($chartLabels);
    const dataBB = @json($chartBB);
    const dataTB = @json($chartTB);
    const dataUmur = @json($chartUmur);
    const dataZscore = @json($chartZscore);

    // ========================================
    // 2. Fungsi untuk menentukan warna titik berdasarkan Z-Score
    // ========================================
    function getColorByZScore(zscore) {
        if (zscore < -3) return '#dc2626';      // Merah tua (Severe)
        if (zscore < -2) return '#ef4444';      // Merah (Stunting)
        if (zscore < -1) return '#facc15';      // Kuning (Risiko)
        if (zscore <= 2) return '#22c55e';      // Hijau (Normal)
        return '#f97316';                       // Oranye (Overweight)
    }

    // ========================================
    // 3. Fungsi untuk warna titik per status
    // ========================================
    const statusColors = {
        'Severely Stunted': '#dc2626',
        'Stunted': '#ef4444',
        'Underweight': '#facc15',
        'Normal': '#22c55e',
        'Overweight / Obese': '#f97316',
        'Wasted': '#f59e0b',
        'Severely Wasted': '#dc2626',
    };

    // ========================================
    // 4. Plugin Zona Kemenkes (Background)
    // ========================================
    const zonePlugin = {
        id: 'zonePlugin',
        beforeDraw: function(chart) {
            const ctx = chart.ctx;
            const chartArea = chart.chartArea;
            const yScale = chart.scales.y;
            
            // Hanya jika ada sumbu Y
            if (!yScale) return;

            // Definisikan zona berdasarkan Z-Score
            const zones = [
                { min: -Infinity, max: -3, color: 'rgba(220, 38, 38, 0.15)' },    // Merah tua
                { min: -3, max: -2, color: 'rgba(239, 68, 68, 0.15)' },         // Merah
                { min: -2, max: -1, color: 'rgba(250, 204, 21, 0.15)' },        // Kuning
                { min: -1, max: 2, color: 'rgba(34, 197, 94, 0.15)' },          // Hijau
                { min: 2, max: Infinity, color: 'rgba(249, 115, 22, 0.15)' },   // Oranye
            ];

            // Gambar zona
            zones.forEach(zone => {
                const yMin = yScale.getPixelForValue(zone.min);
                const yMax = yScale.getPixelForValue(zone.max);
                
                // Pastikan dalam chartArea
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

    // ========================================
    // 5. Grafik BB/U
    // ========================================
    const ctxBB = document.getElementById('kmsChartBB');
    if (ctxBB) {
        // Warna titik berdasarkan Z-Score (jika ada)
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
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                return [
                                    'BB: ' + context.parsed.y + ' kg',
                                    'Umur: ' + (dataUmur[index] || '?') + ' bulan',
                                    'Z-Score: ' + (dataZscore[index] || '?')
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Berat (kg)'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal Pemeriksaan'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            },
            plugins: [zonePlugin]
        });
    }

    // ========================================
    // 6. Grafik TB/U
    // ========================================
    const ctxTB = document.getElementById('kmsChartTB');
    if (ctxTB) {
        // Warna titik berdasarkan Z-Score
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
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                return [
                                    'TB: ' + context.parsed.y + ' cm',
                                    'Umur: ' + (dataUmur[index] || '?') + ' bulan',
                                    'Z-Score: ' + (dataZscore[index] || '?')
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tinggi (cm)'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal Pemeriksaan'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            },
            plugins: [zonePlugin]
        });
    }

    console.log('✅ Grafik KMS siap!');
});
</script>
@endpush
@endsection