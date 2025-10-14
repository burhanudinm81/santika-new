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
        Schema::create('dokumen_pembanding_plagiasi', function (Blueprint $table) {
            $table->id();
            $table->string("filename");
            $table->string("nama_mahasiswa_1")->nullable();
            $table->string("nama_mahasiswa_2")->nullable();
            $table->string("nim_1")->nullable();
            $table->string("nim_2")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pembanding_plagiasi');
    }
};
