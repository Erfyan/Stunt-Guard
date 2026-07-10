@extends('layouts.app')

@section('title', 'Dashboard Puskesmas')
@section('header', '🏥 Dashboard Puskesmas')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
            <p class="text-gray-500">Total Balita</p>
            <p class="text-2xl font-bold">{{ $totalBalita ?? 0 }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow border-l-4 border-red-500">
            <p class="text-gray-500">Stunting</p>
            <p class="text-2xl font-bold text-red-600">{{ $totalStunting ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold">📊 Rekap per Posyandu</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Posyandu</th>
                    <th class="px-4 py-2 text-left">Total</th>
                    <th class="px-4 py-2 text-left">Stunting</th>
                    <th class="px-4 py-2 text-left">Normal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataPosyandu ?? [] as $p)
                <tr>
                    <td class="px-4 py-2">{{ $p['nama'] }}</td>
                    <td class="px-4 py-2">{{ $p['total'] }}</td>
                    <td class="px-4 py-2 text-red-600">{{ $p['stunting'] }}</td>
                    <td class="px-4 py-2 text-green-600">{{ $p['normal'] }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection