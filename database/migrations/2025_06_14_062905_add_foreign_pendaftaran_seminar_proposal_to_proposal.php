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
            $table->foreignId('pendaftaran_sempro_id')->nullable(true)->after('periode_id')->constrained('pendaftaran_seminar_proposal', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropForeign(['pendaftaran_sempro_id']);
            $table->dropColumn('pendaftaran_sempro');
        });
    }
};
