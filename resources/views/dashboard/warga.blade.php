<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang di Dashboard Warga!
                    <p>Total Pengaduan Anda: {{ $myTotalPengaduan ?? 0 }}</p>
                    <p>Pengaduan Pending: {{ $myPendingPengaduan ?? 0 }}</p>
                    <p>Pengaduan Diproses: {{ $myProsesPengaduan ?? 0 }}</p>
                    <p>Pengaduan Selesai: {{ $mySelesaiPengaduan ?? 0 }}</p>

                    <h3 class="font-semibold text-lg mt-4 mb-2">5 Pengaduan Terakhir Anda:</h3>
                    @if(isset($latestMyPengaduans) && $latestMyPengaduans->isNotEmpty())
                        <ul>
                            @foreach($latestMyPengaduans as $pengaduan)
                                <li>
                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="text-blue-600 hover:underline">
                                        {{ $pengaduan->judul }} (Status: {{ ucfirst($pengaduan->status) }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Belum ada pengaduan terbaru.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Buat Pengaduan Baru
                        </a>
                        <a href="{{ route('warga.my_pengaduans') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Lihat Semua Pengaduan Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>