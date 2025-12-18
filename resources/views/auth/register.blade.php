<x-guest-layout>
    <div class="flex min-h-screen">
        <!-- Banner kiri -->
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 text-white items-center justify-center p-10">
            <div class="text-center">
                <img src="/images/logo-desa.png" alt="Logo Desa" class="mx-auto mb-6 h-24 w-24">
                <h1 class="text-3xl font-bold">Portal Warga Desa</h1>
                <p class="mt-4 text-lg">Silakan daftar sebagai Warga atau Ketua RT untuk menggunakan sistem ini.</p>
            </div>
        </div>

        <!-- Form kanan -->
        <div class="flex w-full md:w-1/2 items-center justify-center bg-white p-8">
            <div class="w-full max-w-md">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Akun</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full"
                                      type="text"
                                      name="name"
                                      :value="old('name')"
                                      required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Daftar Sebagai')" />
                        <select id="role" name="role"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                required>
                            <option value="">Pilih Peran</option>
                            <option value="warga" {{ old('role') == 'warga' ? 'selected' : '' }}>Warga</option>
                            <option value="RT" {{ old('role') == 'RT' ? 'selected' : '' }}>Ketua RT</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation"
                                      required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('login') }}"
                           class="underline text-sm text-gray-600 hover:text-gray-900">
                            Sudah punya akun?
                        </a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            {{ __('Daftar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
