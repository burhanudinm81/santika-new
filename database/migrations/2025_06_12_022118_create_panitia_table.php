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
        Schema::create('panitia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("dosen_id");
            $table->unsignedBigInteger("prodi_id");
            $table->unsignedBigInteger("jabatan_panitia_id");

            $table->foreign("dosen_id")->references("id")->on("dosen");
            $table->foreign("prodi_id")->references("id")->on("prodi");
            $table->foreign("jabatan_panitia_id")->references("id")->on("jabatan_panitia");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panitia');
    }
};
