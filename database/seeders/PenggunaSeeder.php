<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // Membuat akun Ketua RT utama
        Pengguna::create([
            'nama' => 'mulyono',
            'email' => 'mulyonot@example.com',
            'password' => 'mulyono123',
            'role' => 'RT',
        ]);

        // Membuat akun Warga utama
        Pengguna::create([
            'nama' => 'mulyadi',
            'email' => 'mulyadi@example.com',
            'password' => Hash::make('mulyono123'),
            'role' => 'warga',
        ]);

        // Membuat beberapa pengguna RT tambahan (misal untuk testing)
        Pengguna::factory()->count(5)->rt()->create();

        // Membuat pengguna warga dalam jumlah besar
        // Catatan: Ini akan dijalankan di MainSeeder untuk memastikan jumlah yang tepat.
        // Di sini kita hanya membuat beberapa contoh awal.
        Pengguna::factory()->count(100)->create();
    }
}
