<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menganggap 'komentars',
     * jadi kita eksplisitkan menjadi 'komentar'.
     *
     * @var string
     */
    protected $table = 'komentar';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'isi',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Model
    |--------------------------------------------------------------------------
    */

    /**
     * Dapatkan pengaduan tempat komentar ini berada.
     * Relasi Many-to-One: Banyak Komentar dimiliki oleh satu Pengaduan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengaduan()
    {
        // 'pengaduan_id' adalah foreign key di tabel 'komentar'
        // 'id' adalah primary key di tabel 'pengaduan'
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    /**
     * Dapatkan pengguna yang membuat komentar ini.
     * Relasi Many-to-One: Banyak Komentar dimiliki oleh satu Pengguna.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengguna()
    {
        // 'user_id' adalah foreign key di tabel 'komentar'
        // 'id' adalah primary key di tabel 'pengguna'
        return $this->belongsTo(Pengguna::class, 'user_id');
    }
}