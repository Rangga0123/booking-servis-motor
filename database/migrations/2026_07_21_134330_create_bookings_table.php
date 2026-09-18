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
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nama_motor');
        $table->string('plat_nomor');
        $table->string('jenis_servis')->nullable();
        $table->dateTime('tanggal_booking')->nullable();
        $table->text('keluhan');
        $table->string('metode_pembayaran')->nullable();
        $table->string('status')->default('menunggu');
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