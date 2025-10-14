<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            // Kolom `id` sebagai Primary Key (INT auto-increment)
            $table->id();

            // Kolom `keterangan` dengan tipe TEXT
            $table->text('keterangan');

            // Kolom Foreign Key untuk tabel `mahasiswa`. Harus nullable()
            // karena ON DELETE di-set menjadi SET NULL.
            $table->unsignedBigInteger('mahasiswa_id')->nullable();

            // Kolom Foreign Key untuk tabel `dosen`. Harus nullable() juga.
            $table->unsignedBigInteger('dosen_id')->nullable();

            // Kolom `tipe` dengan tipe VARCHAR
            $table->string('tipe')->nullable();

            // Kolom `created_at` dan `updated_at` (DATETIME/TIMESTAMP)
            $table->timestamps();

            // Definisi Foreign Key Constraint untuk mahasiswa_id
            $table->foreign('mahasiswa_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('set null');

            // Definisi Foreign Key Constraint untuk dosen_id
            $table->foreign('dosen_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
};
