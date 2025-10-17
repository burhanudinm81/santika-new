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
        Schema::create('visibilitas_nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('tahap_id');
            $table->integer('jenis_nilai_seminar');
            $table->boolean('visibilitas')->default(false);

            $table->foreign('periode_id')->references('id')->on('periode')->onDelete('cascade');
            $table->foreign('tahap_id')->references('id')->on('tahap')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visibilitas_nilai');
    }
};
