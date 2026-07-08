<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIPANTAU STUNTING')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-child"></i>
                    <span class="hidden sm:inline">SIPANTAU</span>
                </a>

                <!-- Navbar Kanan -->
                <div class="flex items-center gap-4">
                    <span class="text-sm hidden md:inline">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->nama }}
                        <span class="ml-2 bg-green-500 px-2 py-0.5 rounded text-xs">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </span>

                    <!-- Dropdown User -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="focus:outline-none hover:bg-green-600 p-1 rounded transition">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 origin-top-right">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-circle"></i> Profil
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-lg hidden md:block overflow-y-auto">
                <nav class="p-4 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>

                    @if(in_array(Auth::user()->role, ['Admin', 'Kader', 'Petugas']))
                    <!-- Data Balita -->
                    <a href="{{ route('balita.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('balita.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-child w-5 text-center"></i>
                        <span>Data Balita</span>
                    </a>

                    <!-- Data Ibu -->
                    <a href="{{ route('ibu.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('ibu.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-female w-5 text-center"></i>
                        <span>Data Ibu Hamil</span>
                    </a>
                    @endif

                    @if(Auth::user()->role == 'Kader')
                    <!-- Input Pemeriksaan -->
                    <a href="{{ route('pemeriksaan.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('pemeriksaan.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-plus-circle w-5 text-center"></i>
                        <span>Input Pemeriksaan</span>
                    </a>
                    @endif

                    <!-- Grafik KMS (hanya jika ada route) -->
                    @if(Route::has('kms.index'))
                    <a href="{{ route('kms.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('kms.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span>Grafik KMS</span>
                    </a>
                    @endif

                    @if(in_array(Auth::user()->role, ['Admin', 'Petugas']))
                    <!-- Laporan -->
                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('laporan.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt w-5 text-center"></i>
                        <span>Laporan</span>
                    </a>
                    @endif

                    @if(Auth::user()->role == 'Admin')
                    <!-- Manajemen User -->
                    <a href="{{ route('user.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('user.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-users-cog w-5 text-center"></i>
                        <span>Manajemen User</span>
                    </a>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                <!-- Header halaman -->
                @hasSection('header')
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">@yield('header')</h1>
                    </div>
                @endif

                <!-- Notifikasi -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Konten -->
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white text-center py-3 text-sm mt-auto">
            &copy; {{ date('Y') }} SIPANTAU STUNTING - Teknik Informatika Universitas Lamappapoleonro
        </footer>
    </div>

    <!-- Alpine JS (untuk dropdown) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    @stack('scripts')
</body>
</html>