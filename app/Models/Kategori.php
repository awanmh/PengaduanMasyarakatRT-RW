<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menganggap 'kategoris',
     * jadi kita eksplisitkan menjadi 'kategori'.
     *
     * @var string
     */
    protected $table = 'kategori';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Model
    |--------------------------------------------------------------------------
    */

    /**
     * Dapatkan semua pengaduan yang termasuk dalam kategori ini.
     * Relasi One-to-Many: Satu Kategori memiliki banyak Pengaduan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengaduans()
    {
        // 'kategori_id' adalah foreign key di tabel 'pengaduan' yang merujuk ke 'id' di tabel 'kategori'
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}