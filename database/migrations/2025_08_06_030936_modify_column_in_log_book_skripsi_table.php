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
            $table->dropColumn('status');
            $table->unsignedBigInteger('status_logbook_id')->after('catatan_khusus_dosen')
                ->default(1);
            $table->foreign('status_logbook_id')->references("id")->on("status_logbook");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_book_skripsi', function (Blueprint $table) {
            $table->dropForeign(['status_logbook_id']);
            $table->dropColumn('status_logbook_id');
            $table->boolean('status')->default(false);
        });
    }
};
