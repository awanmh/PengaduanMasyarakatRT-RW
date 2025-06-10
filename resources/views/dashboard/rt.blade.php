<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Ketua RT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang di Dashboard Ketua RT!
                    <p>Total Pengaduan: {{ $totalPengaduan ?? 0 }}</p>
                    <p>Pengaduan Pending: {{ $pendingPengaduan ?? 0 }}</p>
                    <p>Pengaduan Diproses: {{ $prosesPengaduan ?? 0 }}</p>
                    <p>Pengaduan Selesai: {{ $selesaiPengaduan ?? 0 }}</p>

                    <h3 class="font-semibold text-lg mt-4 mb-2">5 Pengaduan Terbaru:</h3>
                    @if(isset($latestPengaduans) && $latestPengaduans->isNotEmpty())
                        <ul>
                            @foreach($latestPengaduans as $pengaduan)
                                <li>
                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="text-blue-600 hover:underline">
                                        {{ $pengaduan->judul }} oleh {{ $pengaduan->pengguna->nama }} (Status: {{ ucfirst($pengaduan->status) }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Belum ada pengaduan terbaru.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('pengaduan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Lihat Semua Pengaduan
                        </a>
                        <a href="{{ route('kategori.index') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Manajemen Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>