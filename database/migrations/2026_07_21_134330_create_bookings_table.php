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
        Schema::create('booking_servis', function (Blueprint $table) {
            $table->id('id_booking');
            // Relasi ke tabel pelanggan dan kendaraan
            $table->foreignId('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            $table->foreignId('id_kendaraan')->references('id_kendaraan')->on('kendaraans')->onDelete('cascade');
            
            $table->string('jenis_servis');
            $table->date('tanggal_booking');
            $table->time('jam_booking');
            $table->text('keluhan');
            $table->text('catatan')->nullable();
            $table->enum('status_booking', ['Menunggu', 'Diproses', 'Selesai', 'Batal'])->default('Menunggu');
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