<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mechanics', function (Blueprint $table) {
            if (!Schema::hasColumn('mechanics', 'nama_mekanik')) {
                $table->string('nama_mekanik')->after('id');
            }
            if (!Schema::hasColumn('mechanics', 'spesialisasi')) {
                $table->string('spesialisasi')->nullable()->after('nama_mekanik');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mechanics', function (Blueprint $table) {
            $table->dropColumn(['nama_mekanik', 'spesialisasi']);
        });
    }
};