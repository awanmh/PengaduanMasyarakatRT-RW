<?php

namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Nama model yang sesuai dengan factory ini.
     *
     * @var string
     */
    protected $model = Pengguna::class;

    /**
     * Definisikan state default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Semua password adalah 'password' untuk kemudahan testing
            'role' => $this->faker->randomElement(['warga']), // Defaultnya 'warga'. Kita akan buat beberapa RT secara manual atau di seeder.
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }

    /**
     * Indikasi bahwa model ini memiliki status verifikasi email.
     * Tidak terlalu relevan untuk pengujian performa, tetapi bisa ditambahkan.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Konfigurasi pengguna sebagai Ketua RT.
     *
     * @return static
     */
    public function rt(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'RT',
            ];
        });
    }
}
