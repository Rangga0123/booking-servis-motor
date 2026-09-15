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
        Schema::table('bookings', function (Blueprint $table) {
            // Menambahkan kolom status dengan nilai default 'menunggu'
            $table->string('status')->default('menunggu')->after('keluhan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Berfungsi untuk menghapus kembali kolom jika migrasi dibatalkan (rollback)
            $table->dropColumn('status');
        });
    }
};