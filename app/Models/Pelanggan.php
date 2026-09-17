<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    // Memberitahu Laravel nama primary key-nya
    protected $primaryKey = 'id_pelanggan';

    // Kolom apa saja yang boleh diisi datanya
    protected $fillable = [
        'nama', 
        'no_hp', 
        'email', 
        'alamat'
    ];
}