@extends('layouts.app')

@section('title', 'Dashboard Dinas Kesehatan')
@section('header', '🏛️ Dashboard Dinas Kesehatan')

@section('content')
<div class="container mx-auto">
    <div class="bg-white rounded shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold">📊 Rekap Stunting per Kecamatan</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Kecamatan</th>
                    <th class="px-4 py-2 text-left">Total Balita</th>
                    <th class="px-4 py-2 text-left">Stunting</th>
                    <th class="px-4 py-2 text-left">Prevalensi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataKecamatan ?? [] as $k)
                @php
                    $totalBalita = data_get($k, 'total_balita', 0);
                    $stunting = data_get($k, 'stunting', 0);
                    $prevalensi = $totalBalita > 0 ? round(($stunting / $totalBalita) * 100, 2) : 0;
                @endphp
                <tr>
                    <td class="px-4 py-2">{{ data_get($k, 'kecamatan', '-') }}</td>
                    <td class="px-4 py-2">{{ $totalBalita }}</td>
                    <td class="px-4 py-2 text-red-600">{{ $stunting }}</td>
                    <td class="px-4 py-2">{{ $prevalensi }}%</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection