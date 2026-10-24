<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (! Schema::hasColumn('services', 'harga_barang')) {
                $table->unsignedBigInteger('harga_barang')->default(0);
            }

            if (! Schema::hasColumn('services', 'biaya_jasa')) {
                $table->unsignedBigInteger('biaya_jasa')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('services', 'harga_barang')) {
                $columns[] = 'harga_barang';
            }

            if (Schema::hasColumn('services', 'biaya_jasa')) {
                $columns[] = 'biaya_jasa';
            }

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};