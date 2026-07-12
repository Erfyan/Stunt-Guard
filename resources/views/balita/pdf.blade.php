<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Balita - SIPANTAU</title>

    @if(isset($cssPath) && file_exists(public_path('build/' . $cssPath)))
        <link rel="stylesheet" href="{{ asset('build/' . $cssPath) }}">
    @else
        <!-- Fallback CDN jika file CSS belum di-build -->
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        /* Fallback jika Tailwind tidak sepenuhnya support di DomPDF */
        body { font-family: 'Arial', 'Helvetica', sans-serif; }
        .bg-pink-100 { background-color: #fce7f3; }
        .bg-pink-50 { background-color: #fdf2f8; }
        .text-pink-800 { color: #831843; }
        .text-pink-600 { color: #db2777; }
        .border-pink-300 { border-color: #f9a8d4; }
        .border-pink-200 { border-color: #fbcfe8; }
        .text-green-600 { color: #16a34a; }
        .text-red-600 { color: #dc2626; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px 8px; }
        .border { border: 1px solid #e5e7eb; }
    </style>
</head>
<body class="p-6 bg-white text-gray-800">

    <!-- ===== HEADER ===== -->
    <div class="text-center border-b-4 border-pink-300 pb-4 mb-6">
        <h1 class="text-2xl font-bold text-pink-600 tracking-wide">SIPANTAU <span class="text-pink-400">STUNTING</span></h1>
        <p class="text-sm text-gray-600">Sistem Informasi Pengawasan Tumbuh Kembang Anak</p>
        <p class="text-xs text-gray-500 mt-1">
            <span class="font-semibold">Data Balita</span> &nbsp;|&nbsp; 
            Tanggal Cetak: {{ date('d-m-Y H:i') }}
        </p>
        @if($search)
            <p class="text-xs text-gray-500 mt-1"><span class="font-semibold">Pencarian:</span> "{{ $search }}"</p>
        @endif
        @if(isset($status) && $status)
            <p class="text-xs text-gray-500"><span class="font-semibold">Filter Status:</span> {{ $status }}</p>
        @endif
    </div>

    <!-- ===== TABLE ===== -->
    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="bg-pink-100 text-pink-800 uppercase text-xs tracking-wider">
                <th class="border border-pink-200 px-2 py-2 text-left w-10">No</th>
                <th class="border border-pink-200 px-2 py-2 text-left">Nama</th>
                <th class="border border-pink-200 px-2 py-2 text-left">NIK</th>
                <th class="border border-pink-200 px-2 py-2 text-center w-12">JK</th>
                <th class="border border-pink-200 px-2 py-2 text-left">Tgl Lahir</th>
                <th class="border border-pink-200 px-2 py-2 text-left">Ibu</th>
                <th class="border border-pink-200 px-2 py-2 text-left">Posyandu</th>
                <th class="border border-pink-200 px-2 py-2 text-center w-20">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($balitas as $balita)
            <tr class="{{ $loop->even ? 'bg-pink-50' : 'bg-white' }} hover:bg-pink-100">
                <td class="border border-gray-300 px-2 py-1.5 text-center">{{ $no++ }}</td>
                <td class="border border-gray-300 px-2 py-1.5">{{ $balita->nama_balita ?? '-' }}</td>
                <td class="border border-gray-300 px-2 py-1.5">{{ $balita->nik ?? '-' }}</td>
                <td class="border border-gray-300 px-2 py-1.5 text-center">{{ $balita->jenis_kelamin ?? '-' }}</td>
                <td class="border border-gray-300 px-2 py-1.5">{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                <td class="border border-gray-300 px-2 py-1.5">{{ optional($balita->ibu)->nama_ibu ?? '-' }}</td>
                <td class="border border-gray-300 px-2 py-1.5">{{ optional($balita->posyandu)->nama_posyandu ?? '-' }}</td>
                <td class="border border-gray-300 px-2 py-1.5 text-center">
                    @if($balita->status == 'Aktif')
                        <span class="text-green-600 font-semibold">● Aktif</span>
                    @elseif($balita->status == 'Non Aktif')
                        <span class="text-red-600 font-semibold">● Non Aktif</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="border border-gray-300 px-4 py-6 text-center text-gray-500 italic">
                    Tidak ada data balita
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ===== TOTAL INFO ===== -->
    <div class="mt-3 text-right text-sm text-gray-600">
        Total Data: <span class="font-bold text-pink-600">{{ $balitas->count() }}</span> balita
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="mt-6 pt-3 border-t-2 border-pink-200 flex justify-between text-xs text-gray-500">
        <span>Halaman 1 / 1</span>
        <span>Dicetak: {{ date('d-m-Y H:i:s') }}</span>
    </div>

</body>
</html>