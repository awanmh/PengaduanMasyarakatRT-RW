<?php

namespace Database\Factories;

use App\Models\Komentar;
use App\Models\Pengaduan; // Perlu di-import
use App\Models\Pengguna; // Perlu di-import
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Komentar>
 */
class KomentarFactory extends Factory
{
    /**
     * Nama model yang sesuai dengan factory ini.
     *
     * @var string
     */
    protected $model = Komentar::class;

    /**
     * Definisikan state default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan ada pengaduan dan pengguna di database sebelum menjalankan seeder ini
        $pengaduanId = Pengaduan::inRandomOrder()->first()->id ?? Pengaduan::factory()->create()->id;
        $userId = Pengguna::inRandomOrder()->first()->id ?? Pengguna::factory()->create()->id;

        return [
            'pengaduan_id' => $pengaduanId,
            'user_id' => $userId,
            'isi' => $this->faker->paragraph(mt_rand(1, 3)),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
