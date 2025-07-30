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
            $table->unsignedBigInteger('periode_semhas_id')->nullable()->after('pendaftaran_semhas_id');
            $table->unsignedBigInteger('tahap_semhas_id')->nullable()->after('periode_semhas_id');
            $table->foreign('periode_semhas_id')->references('id')->on('periode');
            $table->foreign('tahap_semhas_id')->references('id')->on('tahap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
             $table->dropForeign(['periode_semhas_id']);
            $table->dropForeign(['tahap_semhas_id']);
            $table->dropColumn('periode_semhas_id');
            $table->dropColumn('tahap_semhas_id');
        });
    }
};
