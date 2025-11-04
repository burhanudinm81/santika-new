<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuota_dosen', function (Blueprint $table) {
            // Drop foreign key constraint lama
            $table->dropForeign(['dosen_id']);
            
            // Tambah foreign key dengan cascade delete
            $table->foreign('dosen_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kuota_dosen', function (Blueprint $table) {
            // Drop foreign key dengan cascade
            $table->dropForeign(['dosen_id']);
            
            // Kembalikan ke foreign key original tanpa cascade
            $table->foreign('dosen_id')
                ->references('id')
                ->on('dosen');
        });
    }
};