<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara mass assignment dari Controller/Form
    protected $fillable = [
        'user_id',
        'mechanic_id',       // <-- Tambahkan ini untuk relasi mekanik
        'nama_motor',
        'plat_nomor',
        'jenis_servis',
        'tanggal_booking',
        'jam_booking',
        'keluhan',
        'metode_pembayaran',
        'status'
    ];

    // Relasi: 1 data booking milik 1 orang user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: 1 data booking memesan 1 jenis servis
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relasi: 1 data booking ditangani oleh 1 orang mekanik
    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class, 'mechanic_id');
    }
}