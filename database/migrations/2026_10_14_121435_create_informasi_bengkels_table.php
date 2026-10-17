<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_bengkels', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bengkel')->default('Bengkel Royal Motor');
            $table->text('deskripsi')->nullable();
            $table->string('foto_1')->nullable();
            $table->text('deskripsi_foto_1')->nullable();
            $table->string('foto_2')->nullable();
            $table->text('deskripsi_foto_2')->nullable();
            $table->string('hari_operasional')->default('Senin - Minggu');
            $table->time('jam_buka')->default('13:00:00');
            $table->time('jam_tutup')->default('22:00:00');
            $table->string('status_operasional')->default('otomatis');
            $table->text('informasi_layanan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_bengkels');
    }
};