<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = [
        'id_pengguna',
        'id_artikel',
        'isi',
    ];

    // komentar dimiliki oleh satu pengguna 
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    // komentar dimiliki oleh satu artikel 
    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }
}