<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service; // Memanggil model Service

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Data Servis 1
        Service::create([
            'nama_servis' => 'Servis Ringan / Rutin',
            'deskripsi' => 'Pengecekan rem, lampu, rantai/CVT, dan tekanan ban.',
            'harga' => 50000,
            'estimasi_waktu' => 30, 
        ]);

        // Data Servis 2
        Service::create([
            'nama_servis' => 'Ganti Oli Mesin & Gardan',
            'deskripsi' => 'Penggantian pelumas mesin dan gardan standar pabrik.',
            'harga' => 85000,
            'estimasi_waktu' => 15, 
        ]);

        // Data Servis 3
        Service::create([
            'nama_servis' => 'Servis Besar (Turun Mesin)',
            'deskripsi' => 'Pembersihan ruang bakar, klep, dan komponen dalam mesin.',
            'harga' => 350000,
            'estimasi_waktu' => 180, 
        ]);
    }
}