<x-guest-layout>
    <div class="flex min-h-screen">
        <!-- Bagian Kiri (Banner) -->
        <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center" 
             style="background-image: url('https://placehold.co/1000x1000/003366/ffffff?text=RT-RW+Pengaduan');">
            <div class="flex items-center justify-center w-full bg-blue-900 bg-opacity-70">
                <div class="p-8 text-white text-center max-w-lg">
                    <img src="/img/icon.png" alt="Logo Desa" class="mx-auto mb-4 h-24 w-24">
                    <h1 class="text-4xl font-serif font-bold mb-4">Sistem Pengaduan Warga</h1>
                    <p class="text-lg">
                        Media resmi penyampaian aspirasi, laporan, dan pengaduan masyarakat kepada RT/RW secara cepat, mudah, dan transparan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan (Form Login) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 bg-gray-100">
            <div class="w-full max-w-lg">
                <div class="flex flex-col items-center mb-6">
                    <img src="/img/icon.png" alt="RT Logo" class="h-24 w-24 rounded-full mb-4 shadow-md">
                    <h2 class="text-3xl font-serif font-bold text-gray-800">Login Aplikasi</h2>
                    <p class="mt-2 text-center text-gray-500">Silakan masuk untuk melanjutkan.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" value="Email" />
                        <div class="relative">
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus 
                                class="block mt-1 w-full pl-10" />
                            <span class="absolute left-3 top-3 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" value="Password" />
                        <div class="relative">
                            <x-text-input id="password" type="password" name="password" required class="block mt-1 w-full pl-10" />
                            <span class="absolute left-3 top-3 text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-700 hover:underline">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <x-primary-button class="w-full">Masuk</x-primary-button>
                </form>

                <p class="text-center text-gray-500 text-sm mt-6">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-700 hover:underline">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
