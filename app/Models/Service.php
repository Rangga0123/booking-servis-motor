<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'nama_servis',
        'deskripsi',
        'harga',
        'estimasi_waktu',
        'harga_barang',
        'biaya_jasa',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }
}