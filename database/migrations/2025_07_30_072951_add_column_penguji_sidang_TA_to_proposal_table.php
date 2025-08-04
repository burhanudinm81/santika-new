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
        Schema::table('proposal', function (Blueprint $table) {
            $table->unsignedBigInteger('penguji_sidang_ta_1_id')->nullable()->after('penguji_sempro_2_id');
            $table->unsignedBigInteger('penguji_sidang_ta_2_id')->nullable()->after('penguji_sidang_ta_1_id');
            $table->foreign('penguji_sidang_ta_1_id')->references('id')->on('dosen');
            $table->foreign('penguji_sidang_ta_2_id')->references('id')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropForeign(['penguji_sidang_ta_1_id', 'penguji_sidang_ta_2_id']);
            $table->dropColumn(['penguji_sidang_ta_1_id', 'penguji_sidang_ta_2_id']);
        });
    }
};
