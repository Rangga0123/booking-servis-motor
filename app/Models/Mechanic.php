<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi di tabel mechanics
    protected $fillable = [
        'nama_mekanik',
        'spesialisasi',
        'status'
    ];

    // Relasi: 1 mekanik bisa menangani banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'mechanic_id');
    }
}