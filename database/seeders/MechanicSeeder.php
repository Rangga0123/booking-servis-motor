<?php

namespace Database\Seeders;

use App\Models\Mechanic;
use Illuminate\Database\Seeder;

class MechanicSeeder extends Seeder
{
    public function run(): void
    {
        Mechanic::create(['nama_mekanik' => 'Mas vinno', 'spesialisasi' => 'tukang Galau']);
        Mechanic::create(['nama_mekanik' => 'Mas Rangga', 'spesialisasi' => 'benerin sakral']);
        Mechanic::create(['nama_mekanik' => 'Mas kevin', 'spesialisasi' => 'perusak motor']);
    }
}