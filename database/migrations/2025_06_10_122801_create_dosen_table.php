<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();

            $table->string("nidn", 20)->unique();
            $table->string("nip", 20)->unique();
            $table->string("nama", 255)->index();
            $table->string("password", 255);
            $table->rememberToken();
            $table->string("email", 255)->nullable();
            $table->string("no_handphone", 15)->nullable();
            $table->string("foto_profil", 255)->nullable();
            $table->text("deskripsi_profil")->nullable();
            $table->string("gambar_peminatan_riset", 255)->nullable();
            $table->text("deskripsi_peminatan_riset")->nullable();
            $table->string("publikasi", 1000)->nullable();
            $table->string("link_google_scholar", 255)->nullable();
            $table->string("penghargaan", 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
