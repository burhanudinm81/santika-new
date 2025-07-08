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
            $table->unsignedBigInteger('dosen_pembimbing_1_id')->nullable();
            $table->unsignedBigInteger('dosen_pembimbing_2_id')->nullable();
            $table->foreign('dosen_pembimbing_1_id')->references('id')->on('dosen')->onDelete('set null');
            $table->foreign('dosen_pembimbing_2_id')->references('id')->on('dosen')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropForeign(['dosen_pembimbing_1_id']);
            $table->dropForeign(['dosen_pembimbing_2_id']);
            $table->dropColumn(['dosen_pembimbing_1_id', 'dosen_pembimbing_2_id']);
        });
    }
};
