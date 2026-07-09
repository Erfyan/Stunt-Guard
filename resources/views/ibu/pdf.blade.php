<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Ibu</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: bold; }
        .header p { color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA IBU</h1>
        <p>Sistem Informasi Pengawasan Tumbuh Kembang Anak (SIPANTAU)</p>
        <p>Tanggal: {{ date('d-m-Y H:i') }}</p>
        @if($search)
            <p>Pencarian: "{{ $search }}"</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Ibu</th>
                <th>Tanggal Lahir</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Status Akun</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($ibus as $ibu)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $ibu->nik ?? '-' }}</td>
                <td>{{ $ibu->nama_ibu ?? '-' }}</td>
                <td>{{ $ibu->tanggal_lahir ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                <td>{{ $ibu->no_hp ?? '-' }}</td>
                <td>{{ $ibu->alamat ?? '-' }}</td>
                <td>{{ optional($ibu->user)->email ?? '-' }}</td>
                <td>{{ optional($ibu->user)->status ?? '-' }}</td>
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