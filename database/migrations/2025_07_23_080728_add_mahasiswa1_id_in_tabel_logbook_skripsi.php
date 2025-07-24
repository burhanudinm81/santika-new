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
            $table->foreignId('mahasiswa2_id')->nullable(true)->after('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_book_skripsi', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa2_id']);
            $table->dropColumn('mahasiswa2_id');
        });
    }
};
