<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Sesuaikan kolom-kolom di bawah ini dengan form booking kamu
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel user
            $table->string('nama_motor');
            $table->string('plat_nomor');
            $table->text('keluhan');
            $table->string('status')->default('menunggu'); // Kolom status yang kita butuhkan
            $table->decimal('harga', 10, 2)->default(0); // Kolom harga untuk total pendapatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};