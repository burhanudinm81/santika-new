<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tahap', function (Blueprint $table) {
            $table->string('tahap')->change();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahap', function (Blueprint $table) {
            $table->integer('tahap')->change();
            $table->dropColumn(['aktif_sempro', 'aktif_sidang_akhir', 'deleted_at']);
        });
    }
};
