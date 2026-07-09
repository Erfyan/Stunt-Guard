<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stunting</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: bold; }
        .header p { color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #888; }
        .text-red { color: #dc3545; }
        .text-green { color: #28a745; }
        .text-yellow { color: #ffc107; }
        .text-orange { color: #fd7e14; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN REKAPITULASI STATUS GIZI BALITA</h1>
        <p>Sistem Informasi Pengawasan Tumbuh Kembang Anak (SIPANTAU)</p>
        <p>Tanggal: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Posyandu</th>
                <th>Total</th>
                <th>Stunting</th>
                <th>Normal</th>
                <th>Underweight</th>
                <th>Wasting</th>
                <th>Belum Diukur</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($dataPerPosyandu as $posyanduId => $data)
                @php $posyandu = \App\Models\Posyandu::find($posyanduId); @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $posyandu ? $posyandu->nama_posyandu : 'Posyandu tidak ditemukan' }}</td>
                    <td>{{ $data['total'] }}</td>
                    <td class="text-red">{{ $data['stunting'] }}</td>
                    <td class="text-green">{{ $data['normal'] }}</td>
                    <td class="text-yellow">{{ $data['underweight'] }}</td>
                    <td class="text-orange">{{ $data['wasting'] }}</td>
                    <td>{{ $data['total'] - ($data['stunting'] + $data['normal'] + $data['underweight'] + $data['wasting']) }}</td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i:s') }} | SIPANTAU STUNTING
    </div>
</body>
</html>