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
        Schema::table('proposal_dosen_mahasiswa', function (Blueprint $table) {
            $table->foreignId("status_proposal_mahasiswa_id")->after('dosen_id')->constrained("status_proposal_mahasiswa", "id")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_dosen_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['status_proposal_mahasiswa_id']);
            $table->dropColumn('status_proposal_mahasiswa_id');
        });
    }
};
