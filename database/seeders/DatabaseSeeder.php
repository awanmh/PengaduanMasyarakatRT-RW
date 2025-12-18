<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Pengguna;
use App\Models\Pengaduan;
use App\Models\Komentar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage; // Untuk menghapus lampiran dummy

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membersihkan folder lampiran dummy (jika ada)
        Storage::disk('public')->deleteDirectory('lampiran_pengaduan');
        Storage::disk('public')->makeDirectory('lampiran_pengaduan');

        // 2. Panggil PenggunaSeeder untuk membuat akun utama (RT, Warga) dan beberapa warga awal
        $this->call(PenggunaSeeder::class);

        // 3. Buat beberapa kategori awal
        Kategori::factory()->count(20)->create();

        // 4. Membuat data pengaduan dalam jumlah SANGAT BESAR
        // Target 500.000+ baris data
        // Sesuaikan jumlah ini sesuai dengan kemampuan RAM/CPU Anda dan target 500.000
        // Jika 500.000 terlalu besar, coba 100.000 dulu untuk tes.
        $numPengaduans = 1000; // Contoh: 550.000 pengaduan untuk memastikan > 500.000
        $chunkSize = 100; // Proses dalam blok untuk efisiensi memori

        echo "Membuat " . $numPengaduans . " data pengaduan...\n";
        for ($i = 0; $i < $numPengaduans / $chunkSize; $i++) {
            Pengaduan::factory()->count($chunkSize)->create();
            echo "  > " . (($i + 1) * $chunkSize) . " pengaduan telah dibuat.\n";
        }
        echo "Selesai membuat data pengaduan.\n";

        // 5. Membuat data komentar (opsional, karena ini juga bisa jadi banyak)
        // Jumlah komentar bisa 2x-5x jumlah pengaduan, tapi akan sangat memakan waktu.
        // Kita buat jumlah komentar yang lebih sedikit agar seeder tidak terlalu lama.
        $numKomentars = 1000; // Contoh: 100.000 komentar
        echo "Membuat " . $numKomentars . " data komentar...\n";
        for ($i = 0; $i < $numKomentars / $chunkSize; $i++) {
            Komentar::factory()->count($chunkSize)->create();
            echo "  > " . (($i + 1) * $chunkSize) . " komentar telah dibuat.\n";
        }
        echo "Selesai membuat data komentar.\n";

        echo "Proses seeding selesai!\n";
    }
}
