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
            $table->foreignId('pendaftaran_semhas_id')->nullable('true')->constrained('pendaftaran_seminar_hasil', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropForeign(['pendaftaran_semhas_id']);
            $table->dropColumn(['pendaftaran_semhas_id']);
        });
    }
};
