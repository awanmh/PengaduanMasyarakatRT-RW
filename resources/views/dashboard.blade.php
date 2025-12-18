@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header Dashboard -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-blue-900">Dashboard</h1>
        <p class="text-gray-600">Selamat datang di Sistem Pengaduan Warga</p>
    </div>

    <!-- Notifikasi -->
    @if (session('status'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <!-- Statistik Pengaduan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="p-6 bg-white rounded-xl shadow-md border-t-4 border-blue-800">
            <h2 class="text-sm text-gray-500">Total Pengaduan</h2>
            <p class="text-2xl font-bold text-blue-900 mt-2">123</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow-md border-t-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">Sedang Diproses</h2>
            <p class="text-2xl font-bold text-yellow-600 mt-2">45</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow-md border-t-4 border-green-600">
            <h2 class="text-sm text-gray-500">Selesai</h2>
            <p class="text-2xl font-bold text-green-700 mt-2">78</p>
        </div>
    </div>

    <!-- Daftar Pengaduan -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-900 text-white font-semibold">
            Daftar Pengaduan Terbaru
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Judul</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t">
                    <td class="px-6 py-3">1</td>
                    <td class="px-6 py-3">Lampu Jalan Mati</td>
                    <td class="px-6 py-3">Fasilitas Umum</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">Diproses</span>
                    </td>
                    <td class="px-6 py-3">
                        <a href="#" class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
                <tr class="border-t">
                    <td class="px-6 py-3">2</td>
                    <td class="px-6 py-3">Sampah Menumpuk</td>
                    <td class="px-6 py-3">Lingkungan</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">Selesai</span>
                    </td>
                    <td class="px-6 py-3">
                        <a href="#" class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
