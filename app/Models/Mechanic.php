<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mekanik',
        'spesialisasi',
        'status'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'mechanic_id');
    }
}