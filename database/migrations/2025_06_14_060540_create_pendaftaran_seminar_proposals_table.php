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
        Schema::create('pendaftaran_seminar_proposal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal', 'id')->onDelete('cascade');
            $table->foreignId('status_daftar_sempro_id')->constrained('status_pendaftaran_seminar_proposal', 'id')->onDelete('cascade');
            $table->string('file_proposal', 255)->nullable(false);
            $table->string('lembar_konsultasi', 255)->nullable(false);
            $table->string('lembar_kerjasama_mitra', 255)->nullable(false);
            $table->string('bukti_cek_plagiasi', 255)->nullable(false);

            $table->boolean('status_file_proposal');
            $table->boolean('status_lembar_konsultasi');
            $table->boolean('status_lembar_kerjasama_mitra');
            $table->boolean('status_bukti_cek_plagiasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_seminar_proposal');
    }
};
