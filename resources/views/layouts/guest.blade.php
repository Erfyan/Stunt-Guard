<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
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

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-pink-50 via-white to-pink-100 min-h-screen flex items-center justify-center p-4 relative">
    <!-- Skip to main content -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:top-0 focus:left-0 focus:p-4 focus:bg-white focus:text-pink-600 focus:font-bold focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-pink-500 rounded-br-lg transition">
        Lompat ke konten utama
    </a>

    <!-- ===== BLOB BACKGROUND ===== -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pink-400/10 rounded-full filter blur-3xl"></div>
    </div>

    <!-- ===== MAIN CARD ===== -->
    <main id="main-content" tabindex="-1" class="relative z-10 w-full max-w-md focus:outline-none">
        @yield('content')
    </main>

    <!-- ===== SCRIPTS ===== -->
    @stack('scripts')
</body>
</html>