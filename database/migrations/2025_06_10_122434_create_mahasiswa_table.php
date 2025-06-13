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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("prodi_id");
            $table->unsignedBigInteger("periode_id");

            $table->string("nim", 20)->unique();
            $table->string("nama", 255)->index();
            $table->string("password", 255);
            $table->rememberToken();
            $table->string("kelas", 3);
            $table->integer("angkatan");
            $table->string("email", 255)->nullable();
            $table->string("foto_profil")->nullable();

            $table->foreign("prodi_id")->references("id")->on("prodi");
            $table->foreign("periode_id")->references("id")->on("periode");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
