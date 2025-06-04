<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'comment',
    ];

    // Relasi ke Complaint
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    // Relasi ke User (RT atau warga)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
