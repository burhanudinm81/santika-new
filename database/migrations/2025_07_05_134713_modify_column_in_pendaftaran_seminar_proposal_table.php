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
        Schema::table('pendaftaran_seminar_proposal', function (Blueprint $table) {
            $table->string('lembar_kerjasama_mitra', 255)->nullable()->change();
            $table->boolean('status_lembar_kerjasama_mitra')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_seminar_proposal', function (Blueprint $table) {
            $table->string('lembar_kerjasama_mitra', 255)->nullable(false)->change();
            $table->boolean('status_lembar_kerjasama_mitra')->nullable(false)->change();
        });
    }
};
