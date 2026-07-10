@extends('layouts.app')

@section('title', 'Dashboard Ibu')
@section('header', '👶 Data Anak Saya')

@section('content')
<div class="container mx-auto">
    @if($balitas->count() > 0)
        @foreach($balitas as $balita)
        <div class="bg-white rounded shadow p-4 mb-4">
            <h3 class="font-bold text-lg">{{ $balita->nama_balita }}</h3>
            <p>NIK: {{ $balita->nik ?? '-' }} | JK: {{ $balita->jenis_kelamin }}</p>
            <p>Tanggal Lahir: {{ $balita->tanggal_lahir->format('d-m-Y') }} ({{ $balita->umur_bulan }} bulan)</p>
            @php $last = $balita->pemeriksaans->first(); @endphp
            @if($last)
                <p>Status Terakhir: 
                    <span class="px-2 py-0.5 rounded text-xs font-bold {{ statusColorClass($last->status_gizi, $last->status_stunting) }}">
                        {{ $last->status_stunting ?? $last->status_gizi ?? 'N/A' }}
                    </span>
                </p>
                <p>BB: {{ $last->berat_badan }} kg, TB: {{ $last->tinggi_badan }} cm</p>
            @else
                <p class="text-gray-400">Belum ada pemeriksaan.</p>
            @endif
            <a href="{{ route('balita.show', $balita->id) }}" class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
        </div>
        @endforeach
    @else
        <div class="bg-yellow-50 p-4 rounded border-l-4 border-yellow-400">
            <p>Belum ada data anak. Silakan hubungi kader posyandu.</p>
        </div>
    @endif
</div>
@endsection