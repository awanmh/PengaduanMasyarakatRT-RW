<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Pengaduan RT-RW</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Ikon Lucide untuk visual yang lebih baik -->
    <script src="https://cdn.jsdelivr.net/npm/lucide-vue@latest"></script>
</head>
<body class="font-sans bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-blue-900 text-white shadow-md">
        <div class="container mx-auto flex items-center justify-between py-4 px-6">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/icon.png') }}" 
                     alt="Lambang Garuda" class="h-10 w-10">
                <div>
                    <h1 class="text-lg font-bold">SISTEM PENGADUAN WARGA</h1>
                    <p class="text-sm text-blue-200">RT/RW - Kelurahan/Kecamatan</p>
                </div>
            </div>
            <nav class="flex space-x-4">
                <a href="#cara-kerja" class="hover:text-yellow-300 transition duration-300 hidden md:inline-block">Cara Kerja</a>
                <a href="#keunggulan" class="hover:text-yellow-300 transition duration-300 hidden md:inline-block">Keunggulan</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition duration-300">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition duration-300">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition duration-300 ml-2">
                            Daftar
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Konten Utama (dengan padding untuk header) -->
    <main class="pt-[80px]">

        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-24">
            <div class="container mx-auto text-center px-6">
                <h2 class="text-4xl font-bold mb-4 sm:text-5xl lg:text-6xl">Layanan Pengaduan Warga Digital</h2>
                <p class="text-lg max-w-2xl mx-auto mb-6">
                    Sampaikan aspirasi, keluhan, dan laporan Anda secara cepat, transparan, dan akuntabel.
                </p>
                <div class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-yellow-400 text-blue-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition duration-300">
                            Pergi ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-blue-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-300">
                            Masuk Sistem
                        </a>
                        <a href="{{ route('register') }}" class="bg-yellow-400 text-blue-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition duration-300">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Section Cara Kerja -->
        <section id="cara-kerja" class="py-20 bg-white">
            <div class="container mx-auto text-center px-6">
                <h3 class="text-3xl font-bold text-blue-900 mb-12">Cara Kerja</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 shadow rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit-3 text-blue-500 mb-4 mx-auto"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/><path d="m15 5 4 4"/></svg>
                        <h4 class="font-semibold text-lg mb-2">1. Ajukan Pengaduan</h4>
                        <p>Buat akun, lalu tuliskan laporan atau keluhan Anda dengan jelas.</p>
                    </div>
                    <div class="p-6 shadow rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle-2 text-green-500 mb-4 mx-auto"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        <h4 class="font-semibold text-lg mb-2">2. Verifikasi & Tindak Lanjut</h4>
                        <p>Pengurus RT/RW akan memverifikasi laporan dan menindaklanjutinya.</p>
                    </div>
                    <div class="p-6 shadow rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle text-orange-500 mb-4 mx-auto"><path d="M7.9 20A9.3 9.3 0 0 1 4 16.1L2 22l6-2h6a9.26 9.26 0 0 0 4-4 9.26 9.26 0 0 0 4-4 9.26 9.26 0 0 0-4-4 9.26 9.26 0 0 0-4 4"/></svg>
                        <h4 class="font-semibold text-lg mb-2">3. Selesai</h4>
                        <p>Status pengaduan dapat dipantau secara transparan hingga selesai.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Keunggulan -->
        <section id="keunggulan" class="py-20 bg-gray-100">
            <div class="container mx-auto text-center px-6">
                <h3 class="text-3xl font-bold text-blue-900 mb-12">Keunggulan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-white shadow rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye text-blue-500 mb-4 mx-auto"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <h4 class="font-semibold text-lg mb-2">Transparansi</h4>
                        <p>Semua laporan dapat dipantau secara terbuka oleh warga.</p>
                    </div>
                    <div class="p-6 bg-white shadow rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-faster text-blue-500 mb-4 mx-auto"><path d="M10 8 8 20 22 4 12 14l-4 8-2-8"/><path d="M14.5 4.5 20 10"/></svg>
                        <h4 class="font-semibold text-lg mb-2">Cepat</h4>
                        <p>Laporan diterima langsung oleh pengurus RT/RW untuk ditindaklanjuti.</p>
                    </div>
                    <div class="p-6 bg-white shadow rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-smartphone text-blue-500 mb-4 mx-auto"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                        <h4 class="font-semibold text-lg mb-2">Mudah</h4>
                        <p>Akses laporan dari mana saja, kapan saja, hanya lewat smartphone.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-blue-900 text-white py-10">
            <div class="container mx-auto text-center px-6">
                <p class="text-lg font-bold">Sistem Pengaduan RT-RW</p>
                <p class="text-sm text-blue-200">&copy; {{ date('Y') }} Pemerintah Desa/Kelurahan - Semua Hak Dilindungi</p>
            </div>
        </footer>

    </main>

</body>
</html>
