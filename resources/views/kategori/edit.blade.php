<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center">
        <div class="max-w-xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 lg:p-10 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">
                        {{ __('Formulir Edit Kategori') }}
                    </h3>
                    <form method="POST" action="{{ route('kategori.update', $kategori->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- Gunakan metode PUT untuk update --}}

                        <!-- Nama Kategori -->
                        <div>
                            <x-input-label for="nama" :value="__('Nama Kategori')" class="text-gray-700 dark:text-gray-300 mb-2"/>
                            <x-text-input
                                id="nama"
                                class="block w-full px-4 py-2 text-lg rounded-md shadow-sm border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                                type="text"
                                name="nama"
                                :value="old('nama', $kategori->nama)"
                                required
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-3">
                            <a href="{{ route('kategori.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-md">
                                {{ __('Perbarui Kategori') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
