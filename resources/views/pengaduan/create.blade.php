<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengaduan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Judul Pengaduan -->
                        <div>
                            <x-input-label for="judul" :value="__('Judul Pengaduan')" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required autofocus />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <!-- Isi Pengaduan -->
                        <div class="mt-4">
                            <x-input-label for="isi" :value="__('Isi Pengaduan')" />
                            <textarea id="isi" name="isi" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('isi') }}</textarea>
                            <x-input-error :messages="$errors->get('isi')" class="mt-2" />
                        </div>

                        <!-- Kategori Pengaduan -->
                        <div class="mt-4">
                            <x-input-label for="kategori_id" :value="__('Kategori')" />
                            <select id="kategori_id" name="kategori_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        <!-- Lampiran (Gambar) -->
                        <div class="mt-4">
                            <x-input-label for="lampiran" :value="__('Lampiran (Opsional)')" />
                            <input id="lampiran" type="file" name="lampiran" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
                            <x-input-error :messages="$errors->get('lampiran')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Hanya gambar (jpeg, png, jpg, gif) dan maksimal 2MB.</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Kirim Pengaduan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
