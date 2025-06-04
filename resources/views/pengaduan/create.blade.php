<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Pengaduan Baru
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white shadow-md rounded p-6">
            <form method="POST" action="{{ route('pengaduan.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" id="judul" name="judul" class="mt-1 w-full border border-gray-300 rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="mt-1 w-full border border-gray-300 rounded p-2" required>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="isi" class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                    <textarea id="isi" name="isi" rows="5" class="mt-1 w-full border border-gray-300 rounded p-2" required></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
