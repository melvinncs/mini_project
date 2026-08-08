<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorit extends Model
{
    protected $table = 'favorit';

    protected $fillable = [
        'id_pengguna',
        'id_artikel',
    ];

    // favorit dimiliki oleh satu pengguna
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    // favorit mengarah ke satu artikel
    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class, 'id_artikel');
    }
}