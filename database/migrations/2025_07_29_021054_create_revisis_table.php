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
        Schema::create('revisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->text('catatan_revisi')->nullable();
            $table->string('file_proposal_revisi')->nullable();
            $table->string('file_lembar_revisi_dosen')->nullable();
            $table->enum('status', ['pending', 'diterima'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisi');
    }
};
