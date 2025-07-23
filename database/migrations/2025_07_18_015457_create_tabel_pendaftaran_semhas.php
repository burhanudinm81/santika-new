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
        Schema::create('pendaftaran_seminar_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal', 'id')->onDelete('cascade');
            $table->foreignId('status_daftar_semhas_id')->constrained('status_pendaftaran_seminar', 'id')->onDelete('cascade');

            $table->string('file_rekom_dospem')->nullable(false);
            $table->string('file_proposal_semhas')->nullable(false);
            $table->string('file_draft_jurnal')->nullable(false);
            $table->string('file_IA_mitra')->nullable(true);
            $table->string('file_bebas_tanggungan_pkl')->nullable(false);
            $table->string('file_skla')->nullable(false);

            $table->boolean('status_file_rekom_dosen')->default(false);
            $table->boolean('status_file_proposal_semhas')->default(false);
            $table->boolean('status_file_draft_jurnal')->default(false);
            $table->boolean('status_file_bebas_tanggungan_pkl')->default(false);
            $table->boolean('status_file_skla')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_seminar_hasil');
    }
};
