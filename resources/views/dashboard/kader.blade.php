<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kader') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600">Halo, <strong>{{ Auth::user()->nama }}</strong>! Selamat datang di SIPANTAU.</p>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-100 p-4 rounded shadow">
                        <h3 class="font-bold">Total Balita</h3>
                        <p class="text-2xl">{{ $balitas->count() }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded shadow">
                        <h3 class="font-bold">Status</h3>
                        <p class="text-sm">Sistem siap digunakan.</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-bold mb-2">Daftar Balita</h3>
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border">Nama</th>
                                <th class="p-2 border">Ibu</th>
                                <th class="p-2 border">JK</th>
                                <th class="p-2 border">Tanggal Lahir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($balitas as $b)
                            <tr>
                                <td class="p-2 border">{{ $b->nama_balita }}</td>
                                <td class="p-2 border">{{ $b->ibu->nama_ibu ?? '-' }}</td>
                                <td class="p-2 border">{{ $b->jenis_kelamin }}</td>
                                <td class="p-2 border">{{ $b->tanggal_lahir->format('d-m-Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-2 text-center">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>