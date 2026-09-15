<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password123'), // Password admin
            'role' => 'admin', // Role diset langsung ke admin
        ]);
    }
}