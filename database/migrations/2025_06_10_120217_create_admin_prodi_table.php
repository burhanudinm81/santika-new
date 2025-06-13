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
        Schema::create('admin_prodi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("prodi_id");

            $table->string("nama", 255);
            $table->string("email", 255)->nullable();
            $table->string("password", 255);
            $table->rememberToken();
            $table->string("foto_profil", 255)->nullable();

            $table->foreign("prodi_id")->references("id")->on("prodi");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_prodi');
    }
};
