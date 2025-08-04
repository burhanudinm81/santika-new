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
        Schema::create('jadwal_seminar_hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->string('ruang');
            $table->date('tanggal');
            $table->tinyInteger('sesi');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_sidang_ujian_akhir');
    }
};
