<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artikel extends Model
{
    protected $table = 'artikel';

    protected $fillable = [
        'id_pengguna',
        'judul',
        'slug',
        'thumbnail',
        'isi',
        'diterbitkan_pada',
    ];

    protected $casts = [
        'diterbitkan_pada' => 'datetime',
    ];

    // artikel dimiliki oleh satu pengguna
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    // artikel memiliki banyak komentar
    public function komentar(): HasMany
    {
        return $this->hasMany(Komentar::class, 'id_artikel');
    }

    // artikel memiliki banyak favorit
    public function favorit(): HasMany
    {
        return $this->hasMany(Favorit::class, 'id_artikel');
    }
}