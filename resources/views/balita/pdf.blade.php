<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Balita</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: bold; }
        .header p { color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
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
        <h1>DATA BALITA</h1>
        <p>Sistem Informasi Pengawasan Tumbuh Kembang Anak (SIPANTAU)</p>
        <p>Tanggal: {{ date('d-m-Y H:i') }}</p>
        @if($search)
            <p>Pencarian: "{{ $search }}"</p>
        @endif
        @if(isset($status) && $status)
            <p>Status: {{ $status }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>JK</th>
                <th>Tanggal Lahir</th>
                <th>Ibu</th>
                <th>Posyandu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($balitas as $balita)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $balita->nama_balita ?? '-' }}</td>
                <td>{{ $balita->nik ?? '-' }}</td>
                <td>{{ $balita->jenis_kelamin ?? '-' }}</td>
                <td>{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                <td>{{ optional($balita->ibu)->nama_ibu ?? '-' }}</td>
                <td>{{ optional($balita->posyandu)->nama_posyandu ?? '-' }}</td>
                <td>{{ $balita->status ?? '-' }}</td>
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