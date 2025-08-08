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
        Schema::create('nilai_akhir_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            // pembimbing total
            $table->float('avg_nilai_dospem1')->nullable();
            $table->float('avg_nilai_dospem2')->nullable();
            $table->float('avg_nilai_totalDospem')->nullable();
            // pembimbing 1
            $table->float('nilai_sikap_pemb1')->nullable();
            $table->float('nilai_kemampuan_pemb1')->nullable();
            $table->float('nilai_hasilKarya_pemb1')->nullable();
            $table->float('nilai_laporan_pemb1')->nullable();
            // pembimbing 2
            $table->float('nilai_sikap_pemb2')->nullable();
            $table->float('nilai_kemampuan_pemb2')->nullable();
            $table->float('nilai_hasilKarya_pemb2')->nullable();
            $table->float('nilai_laporan_pemb2')->nullable();
            // penguji total
            $table->float('avg_nilai_penguji1')->nullable();
            $table->float('avg_nilai_penguji2')->nullable();
            $table->float('avg_nilai_totalPenguji')->nullable();
            // penguji 1
            $table->float('nilai_sikap_peng1')->nullable();
            $table->float('nilai_kemampuan_peng1')->nullable();
            $table->float('nilai_hasilKarya_peng1')->nullable();
            $table->float('nilai_laporan_peng1')->nullable();
            // penguji 2
            $table->float('nilai_sikap_peng2')->nullable();
            $table->float('nilai_kemampuan_peng2')->nullable();
            $table->float('nilai_hasilKarya_peng2')->nullable();
            $table->float('nilai_laporan_peng2')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_akhir_mahasiswa');
    }
};
