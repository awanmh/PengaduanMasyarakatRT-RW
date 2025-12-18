<?php

namespace Database\Factories;

use App\Models\Pengaduan;
use App\Models\Pengguna; // Perlu di-import untuk relasi
use App\Models\Kategori; // Perlu di-import untuk relasi
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * Nama model yang sesuai dengan factory ini.
     *
     * @var string
     */
    protected $model = Pengaduan::class;

    /**
     * Definisikan state default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan ada pengguna dan kategori di database sebelum menjalankan seeder ini
        $userId = Pengguna::inRandomOrder()->first()->id ?? Pengguna::factory()->create()->id;
        $kategoriId = Kategori::inRandomOrder()->first()->id ?? Kategori::factory()->create()->id;

        return [
            'user_id' => $userId,
            'kategori_id' => $kategoriId,
            'judul' => $this->faker->sentence(mt_rand(3, 7)),
            'isi' => $this->faker->paragraph(mt_rand(5, 15)),
            'lampiran' => $this->faker->boolean(20) ? 'lampiran_pengaduan/' . $this->faker->image('public/storage/lampiran_pengaduan', 640, 480, null, false) : null, // 20% kemungkinan ada lampiran
            'status' => $this->faker->randomElement(['pending', 'proses', 'selesai']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
