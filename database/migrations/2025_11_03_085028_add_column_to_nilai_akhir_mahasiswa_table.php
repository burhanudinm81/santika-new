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
        Schema::table('nilai_akhir_mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger("pembimbing_1_id")->nullable();
            $table->unsignedBigInteger("pembimbing_2_id")->nullable();
            $table->unsignedBigInteger("penguji_1_id")->nullable();
            $table->unsignedBigInteger("penguji_2_id")->nullable();

            $table->foreign("pembimbing_1_id")->references("id")->on("dosen")
                ->onDelete("set null");
            $table->foreign("pembimbing_2_id")->references("id")->on("dosen")
                ->onDelete("set null");
            $table->foreign("penguji_1_id")->references("id")->on("dosen")
                ->onDelete("set null");
            $table->foreign("penguji_2_id")->references("id")->on("dosen")
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_akhir_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(["pembimbing_1_id"]);
            $table->dropForeign(["pembimbing_2_id"]);
            $table->dropForeign(["penguji_1_id"]);
            $table->dropForeign(["penguji_2_id"]);

            $table->dropColumn([
                "pembimbing_1_id", "pembimbing_2_id", "penguji_1_id", "penguji_2_id"
            ]);
        });
    }
};
