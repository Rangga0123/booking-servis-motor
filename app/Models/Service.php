<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (ditambah/diedit)
    protected $fillable = ['nama_servis', 'deskripsi', 'harga', 'estimasi_waktu'];

    // Relasi: 1 jenis servis bisa dipesan berkali-kali (hasMany)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}