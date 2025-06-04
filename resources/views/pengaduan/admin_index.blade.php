<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Pengaduan Warga (Admin RT)
        </h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Form Pencarian dan Filter -->
        <form method="GET" action="{{ route('rt.pengaduan.index') }}" class="mb-6 space-y-4 max-w-full">
            <div class="flex flex-wrap gap-4 items-center">

                <input
                    type="text"
                    name="search"
                    placeholder="Cari pengaduan..."
                    value="{{ request('search') }}"
                    class="border rounded px-3 py-2 flex-grow min-w-[200px]"
                />

                <select name="status" class="border rounded px-3 py-2">
                    <option value="">-- Pilih Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <select name="kategori_id" class="border rounded px-3 py-2">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>

                <input
                    type="date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="border rounded px-3 py-2"
                    aria-label="Dari tanggal"
                >

                <input
                    type="date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="border rounded px-3 py-2"
                    aria-label="Sampai tanggal"
                >

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Filter
                </button>

                <a href="{{ route('rt.pengaduan.index') }}" class="underline text-gray-600 px-3 py-2">Reset</a>
            </div>
        </form>

        <!-- Notifikasi sukses -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Pengaduan -->
        @if($pengaduans->isEmpty())
            <p class="text-center text-gray-500 py-6">Tidak ada pengaduan.</p>
        @else
            <table class="min-w-full border border-gray-300 rounded overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b text-left">Judul</th>
                        <th class="px-4 py-2 border-b text-left">Pelapor</th>
                        <th class="px-4 py-2 border-b text-left">Kategori</th>
                        <th class="px-4 py-2 border-b text-left">Status</th>
                        <th class="px-4 py-2 border-b text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="border-b px-4 py-2">{{ $p->judul }}</td>
                        <td class="border-b px-4 py-2">{{ $p->user->name ?? '-' }}</td>
                        <td class="border-b px-4 py-2">{{ $p->kategori->nama ?? '-' }}</td>
                        <td class="border-b px-4 py-2 capitalize">{{ $p->status }}</td>
                        <td class="border-b px-4 py-2">
                            <form action="{{ route('pengaduan.update_status', $p->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $p->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses" {{ $p->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="border-b px-4 py-2 text-gray-700 italic">Isi: {{ $p->isi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination jika ada -->
            <div class="mt-4">
                {{ $pengaduans->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
