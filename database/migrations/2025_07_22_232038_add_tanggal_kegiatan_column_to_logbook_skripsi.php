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
        Schema::table('log_book_skripsi', function (Blueprint $table) {
            $table->date('tanggal_kegiatan')->after('hasil_kegiatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_book_skripsi', function (Blueprint $table) {
            $table->dropColumn('tanggal_kegiatan');
        });
    }
};
