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
           $table->foreignId('penguji_sempro_1_id')->nullable()->constrained('dosen');
           $table->foreignId('penguji_sempro_2_id')->nullable()->constrained('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropForeign('penguji_sempro_1_id');
            $table->dropForeign('penguji_sempro_2_id');
            $table->dropColumn('penguji_sempro_1_id');
            $table->dropColumn('penguji_sempro_2_id');
        });
    }
};
