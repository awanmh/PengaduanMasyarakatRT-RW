<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pengaduan Anda
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('pengaduan.create') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                    + Buat Pengaduan
                </a>
            </div>

            @if ($pengaduans->isEmpty())
                <p class="text-gray-600">Belum ada pengaduan.</p>
            @else
                <div class="overflow-x-auto bg-white shadow-md rounded p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-2">Judul</th>
                                <th scope="col" class="px-4 py-2">Kategori</th>
                                <th scope="col" class="px-4 py-2">Status</th>
                                <th scope="col" class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengaduans as $p)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 font-medium text-gray-900">
                                        <a href="{{ route('pengaduan.show', $p->id) }}" class="hover:underline">
                                            {{ $p->judul }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2">{{ $p->kategori->nama }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $p->status }}</td>
                                    <td class="px-4 py-2">
                                        @if ($p->status == 'pending')
                                            <a href="{{ route('pengaduan.edit', $p->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                            <form action="{{ route('pengaduan.destroy', $p->id) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 italic">Tidak tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
