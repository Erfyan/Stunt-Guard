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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>

    <!-- Vite Assets (CSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-pink-50 via-white to-pink-100 min-h-screen">

    <!-- ===== BLOB BACKGROUND ===== -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pink-400/10 rounded-full filter blur-3xl"></div>
    </div>

    <!-- ===== MAIN WRAPPER ===== -->
    <div class="relative z-10 min-h-screen flex flex-col">

        <!-- ===== NAVBAR ===== -->
        <nav class="sticky top-0 z-50 bg-white/20 backdrop-blur-xl border-b border-white/30 shadow-lg">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 no-underline group">
                    @include('partials.logo')
                    <span class="text-pink-600 font-bold text-lg hidden sm:inline group-hover:text-pink-700 transition">
                        SIPANTAU
                    </span>
                </a>

                <!-- Navbar Kanan -->
                <div class="flex items-center gap-4">
                    <!-- Nama User -->
                    <span class="text-sm hidden md:inline text-gray-700">
                        <i class="fas fa-user-circle text-pink-500"></i>
                        {{ Auth::user()->nama ?? 'User' }}
                        <span class="ml-2 bg-pink-500/20 text-pink-700 px-2 py-0.5 rounded-full text-xs font-medium border border-pink-200/50">
                            {{ ucfirst(Auth::user()->role ?? 'Guest') }}
                        </span>
                    </span>

                    <!-- Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="focus:outline-none hover:bg-white/30 p-2 rounded-xl transition">
                            <i class="fas fa-chevron-down text-pink-600 text-sm"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-56 bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 z-50 overflow-hidden">
                            <!-- Profil (read-only) -->
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-pink-50 transition">
                                <i class="fas fa-user-circle w-5 text-pink-500"></i>
                                <span class="text-gray-700">Profil Saya</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt w-5 text-red-500"></i>
                                    <span class="text-red-600">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- ===== SIDEBAR + CONTENT ===== -->
        <div class="flex flex-1 overflow-hidden">

            <!-- ===== SIDEBAR ===== -->
            <aside class="w-64 bg-white/20 backdrop-blur-xl border-r border-white/30 shadow-lg hidden md:block overflow-y-auto flex-shrink-0">
                <nav class="p-4 space-y-1">

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-home w-5 text-center text-pink-500"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    @php($userRole = Auth::user()->role ?? '')

                    @if(in_array($userRole, ['Admin', 'Kader', 'Petugas']))
                    <!-- Data Balita -->
                    <a href="{{ route('balita.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('balita.*') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-child w-5 text-center text-pink-500"></i>
                        <span class="font-medium">Data Balita</span>
                    </a>

                    <!-- Data Ibu -->
                    <a href="{{ route('ibu.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('ibu.*') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-female w-5 text-center text-pink-500"></i>
                        <span class="font-medium">Data Ibu Hamil</span>
                    </a>
                    @endif

                    @if($userRole == 'Kader')
                    <!-- Input Pemeriksaan -->
                    <a href="{{ route('pemeriksaan.create') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('pemeriksaan.*') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-plus-circle w-5 text-center text-pink-500"></i>
                        <span class="font-medium">Input Pemeriksaan</span>
                    </a>
                    @endif

                    <!-- KMS Charts -->
                    @if(Route::has('kms.index'))
                    <a href="{{ route('kms.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('kms.*') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-chart-line w-5 text-center text-pink-500"></i>
                        <span class="font-medium">KMS Charts</span>
                    </a>
                    @endif

                    @if(in_array($userRole, ['Admin', 'Petugas']))
                    <!-- Laporan -->
                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-file-alt w-5 text-center text-pink-500"></i>
                        <span class="font-medium">Laporan</span>
                    </a>
                    @endif

                    @if($userRole == 'Admin')
                    <!-- Manajemen User -->
                    <a href="{{ route('user.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('user.*') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-users-cog w-5 text-center text-pink-500"></i>
                        <span class="font-medium">Manajemen User</span>
                    </a>
                    @endif

                    <!-- Profil (read-only) di sidebar -->
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.show') ? 'bg-pink-500/20 text-pink-700 shadow-inner' : 'text-gray-700 hover:bg-white/30 hover:text-pink-600' }}">
                        <i class="fas fa-user-circle w-5 text-center text-pink-500"></i>
                        <span class="font-medium">Profil Saya</span>
                    </a>

                </nav>
            </aside>

            <!-- ===== MAIN CONTENT ===== -->
            <main class="flex-1 p-6 overflow-y-auto">

                <!-- Page Header -->
                @hasSection('header')
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                        @yield('header')
                    </h1>
                </div>
                @endif

                <!-- ===== NOTIFICATIONS ===== -->
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4 bg-pink-100/80 backdrop-blur-sm border-l-4 border-pink-500 text-pink-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
                    <i class="fas fa-check-circle text-pink-500 text-xl"></i>
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-pink-500 hover:text-pink-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-100/80 backdrop-blur-sm border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if(isset($errors) && $errors->any())
                <div class="mb-4 bg-yellow-100/80 backdrop-blur-sm border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-xl shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- ===== CONTENT YIELD ===== -->
                @yield('content')

            </main>
        </div>

        <!-- ===== FOOTER ===== -->
        <footer class="bg-white/20 backdrop-blur-sm border-t border-white/30 text-gray-600 text-center py-3 text-sm mt-auto">
            &copy; {{ date('Y') }} <span class="text-pink-600 font-semibold">SIPANTAU STUNTING</span> - Teknik Informatika Universitas Lamappapoleonro
            <span class="mx-2">|</span>
            <span class="text-xs opacity-60">v2.4.0</span>
        </footer>

    </div>

    <!-- ===== SCRIPTS ===== -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>