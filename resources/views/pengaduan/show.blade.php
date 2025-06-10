<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-4">{{ $pengaduan->judul }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
                        <div>
                            <p><strong>Pelapor:</strong> {{ $pengaduan->pengguna->nama }}</p>
                            <p><strong>Email Pelapor:</strong> {{ $pengaduan->pengguna->email }}</p>
                            <p><strong>Kategori:</strong> {{ $pengaduan->kategori->nama }}</p>
                            <p><strong>Tanggal Pengaduan:</strong> {{ $pengaduan->created_at->format('d F Y H:i') }}</p>
                            <p><strong>Terakhir Diperbarui:</strong> {{ $pengaduan->updated_at->format('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <p><strong>Status:</strong>
                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{
                                    $pengaduan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    ($pengaduan->status == 'proses' ? 'bg-blue-100 text-blue-800' :
                                    'bg-green-100 text-green-800')
                                }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </p>
                            @if ($pengaduan->lampiran)
                                <p class="mt-2"><strong>Lampiran:</strong></p>
                                <img src="{{ Storage::url($pengaduan->lampiran) }}" alt="Lampiran Pengaduan" class="max-w-xs mt-2 rounded-lg shadow-md">
                            @else
                                <p><strong>Lampiran:</strong> Tidak ada lampiran.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6 border-t pt-4">
                        <h4 class="text-xl font-semibold mb-2">Isi Pengaduan:</h4>
                        <p class="text-gray-800">{{ $pengaduan->isi }}</p>
                    </div>

                    <!-- Form Update Status (Hanya untuk RT) -->
                    @auth
                        @if (Auth::user()->role === 'RT')
                            <div class="mb-6 border-t pt-4">
                                <h4 class="text-xl font-semibold mb-2">Perbarui Status Pengaduan:</h4>
                                <form action="{{ route('pengaduan.updateStatus', $pengaduan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center space-x-4">
                                        <select name="status" id="status" class="block w-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="pending" {{ $pengaduan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="proses" {{ $pengaduan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                        <x-primary-button>
                                            {{ __('Perbarui Status') }}
                                        </x-primary-button>
                                    </div>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </form>
                            </div>
                        @endif
                    @endauth

                    <!-- Bagian Komentar -->
                    <div class="mb-6 border-t pt-4">
                        <h4 class="text-xl font-semibold mb-2">Komentar:</h4>
                        @forelse ($pengaduan->komentars as $komentar)
                            <div class="border p-4 rounded-lg shadow-sm mb-3 bg-gray-50">
                                <p class="font-medium text-gray-800">{{ $komentar->pengguna->nama }} <span class="text-gray-500 text-sm">- {{ $komentar->created_at->diffForHumans() }}</span></p>
                                <p class="text-gray-700">{{ $komentar->isi }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada komentar untuk pengaduan ini.</p>
                        @endforelse
                    </div>

                    <!-- Form Tambah Komentar -->
                    <div class="border-t pt-4">
                        <h4 class="text-xl font-semibold mb-2">Tambah Komentar:</h4>
                        <form action="{{ route('pengaduan.komentar.store', $pengaduan->id) }}" method="POST">
                            @csrf
                            <textarea name="isi" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tulis komentar Anda..." required>{{ old('isi') }}</textarea>
                            <x-input-error :messages="$errors->get('isi')" class="mt-2" />
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Kirim Komentar') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
