<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiBengkel extends Model
{
    protected $fillable = [
        'nama_bengkel',
        'deskripsi',
        'foto_1',
        'deskripsi_foto_1',
        'foto_2',
        'deskripsi_foto_2',
        'hari_operasional',
        'jam_buka',
        'jam_tutup',
        'status_operasional',
        'informasi_layanan',
    ];
}