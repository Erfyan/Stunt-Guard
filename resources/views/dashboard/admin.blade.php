<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p>Halo, Admin!</p>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="bg-yellow-100 p-4 rounded">Total Balita: {{ $totalBalita }}</div>
                    <div class="bg-purple-100 p-4 rounded">Total Ibu: {{ $totalIbu }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>