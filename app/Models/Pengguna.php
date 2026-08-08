<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Model
{
    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    // pengguna memiliki banyak artikel
    public function artikel(): HasMany
    {
        return $this->hasMany(Artikel::class, 'id_pengguna');
    }

    // pengguna memiliki banyak komentar
    public function komentar(): HasMany
    {
        return $this->hasMany(Komentar::class, 'id_pengguna');
    }

    // pengguna memiliki banyak favorit
    public function favorit(): HasMany
    {
        return $this->hasMany(Favorit::class, 'id_pengguna');
    }
}