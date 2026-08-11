<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drama extends Model
{
    use HasFactory;

    protected $table = 'drama';

    protected $fillable = [
        'id_pengguna',
        'judul',
        'slug',
        'thumbnail',
        'sinopsis',
        'genre',
        'tahun',
        'episode',
        'rating',
        'status',
        'pemeran_utama',
        'diterbitkan_pada'
    ];

    // protected $casts = [
    //     'diterbitkan_pada' => 'datetime',
    //     'tahun' => 'integer',
    //     'episode' => 'integer'
    // ];

    // relasi dengan pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    // status
    // public function getStatusBadgeAttribute()
    // {
    //     $statuses = [
    //         'Ongoing' => 'badge-success',
    //         'Completed' => 'badge-primary',
    //         'Upcoming' => 'badge-warning',
    //         'On Hold' => 'badge-danger'
    //     ];

    //     return $statuses[$this->status] ?? 'badge-secondary';
    // }
}