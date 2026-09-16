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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id('id_kendaraan');
            // Relasi ke tabel pelanggans
            $table->foreignId('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            
            $table->string('merk');
            $table->string('tipe');
            $table->string('no_polisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
