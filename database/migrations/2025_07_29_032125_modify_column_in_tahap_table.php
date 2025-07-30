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
        Schema::table('tahap', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->boolean('aktif_sempro');
            $table->boolean('aktif_sidang_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahap', function (Blueprint $table) {
            $table->dropColumn(['aktif_sempro', 'aktif_sidang_akhir']);
        });
    }
};
