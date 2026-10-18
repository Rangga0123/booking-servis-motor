<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ganti 'bookings' jika nama tabel booking Anda berbeda
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('nama_pelanggan')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email_pelanggan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['nama_pelanggan', 'no_hp', 'email_pelanggan']);
        });
    }
};