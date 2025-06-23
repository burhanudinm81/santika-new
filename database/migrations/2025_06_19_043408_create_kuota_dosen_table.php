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
        Schema::create('kuota_dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            
            // Kolom Kuota D4
            $table->unsignedTinyInteger('kuota_pembimbing_1_D4')->default(5);
            $table->unsignedTinyInteger('kuota_pembimbing_2_D4')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sempro_1_D4')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sempro_2_D4')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sidang_TA_1_D4')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sidang_TA_2_D4')->default(0);
            
            // Kolom Kuota D3
            $table->unsignedTinyInteger('kuota_pembimbing_1_D3')->default(5);
            $table->unsignedTinyInteger('kuota_pembimbing_2_D3')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sempro_1_D3')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sempro_2_D3')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sidang_TA_1_D3')->default(0);
            $table->unsignedTinyInteger('kuota_penguji_sidang_TA_2_D3')->default(0);

            // Menambahkan foreign key constraint ke tabel dosen
            $table->foreign('dosen_id')->references('id')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuota_dosen');
    }
};
