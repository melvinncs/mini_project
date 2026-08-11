<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'id_pengguna',
        'judul',
        'slug',
        'kategori',
        'thumbnail',
        'isi',
        'diterbitkan_pada',
    ];

    protected $casts = [
        'diterbitkan_pada' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
