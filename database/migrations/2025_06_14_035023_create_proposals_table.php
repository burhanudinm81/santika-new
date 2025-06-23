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
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->foreignId("prodi_id")->constrained("prodi", "id")->onDelete("cascade");
            $table->foreignId("periode_id")->constrained("periode", "id")->onDelete("cascade");
            $table->foreignId("tahap_id")->nullable(true)->constrained("tahap", "id")->onDelete("cascade");
            $table->foreignId("bidang_minat_id")->constrained("bidang_minat", "id")->onDelete("cascade");
            $table->foreignId("jenis_judul_id")->constrained("jenis_judul", "id")->onDelete("cascade");
            $table->string("judul", 255)->nullable(false);
            $table->string("topik", 255)->nullable(false);
            $table->string("tujuan", 255)->nullable(false);
            $table->text("latar_belakang")->nullable(false);
            $table->string("blok_diagram_sistem", 255)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};
