<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'mechanic_id',
        'nama_pelanggan',
        'no_hp',
        'email_pelanggan',
        'nama_motor',
        'plat_nomor',
        'jenis_servis',
        'tanggal_booking',
        'jam_booking',
        'keluhan',
        'metode_pembayaran',
        'status',
        'harga',
        'harga_barang',
        'biaya_jasa',
    ];

    // Booking dimiliki oleh satu pelanggan.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Booking terhubung dengan satu layanan.
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // Booking bisa ditangani oleh satu mekanik.
    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class, 'mechanic_id');
    }
}