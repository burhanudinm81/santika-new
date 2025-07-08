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
        Schema::create('dosen_bidang_minat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('bidang_minat_id');
            $table->unsignedBigInteger('status_dosen_bidang_minat_id');

            $table->foreign('dosen_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->foreign('bidang_minat_id')->references('id')->on('bidang_minat')->onDelete('cascade');
            $table->foreign('status_dosen_bidang_minat_id')->references('id')->on('status_dosen_bidang_minat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_bidang_minat');
    }
};
