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
        'service_id',
        'nama_motor',
        'plat_nomor',
        'tanggal_booking',
        'keluhan',
        'harga',
        'status',
    ];

    // Relasi: 1 data booking ini milik 1 orang user (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: 1 data booking ini memesan 1 jenis servis (belongsTo)
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}