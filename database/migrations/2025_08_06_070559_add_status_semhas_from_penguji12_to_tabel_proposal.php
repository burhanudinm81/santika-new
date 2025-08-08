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
        Schema::table('proposal', function (Blueprint $table) {
            $table->foreignId('status_semhas_penguji_1_id')->nullable(true)->constrained('status_proposal')->onDelete('cascade');
            $table->foreignId('status_semhas_penguji_2_id')->nullable(true)->constrained('status_proposal')->onDelete('cascade');
            $table->foreignId('status_semhas_proposal_id')->nullable(true)->constrained('status_proposal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropForeign('status_semhas_penguji_1_id');
            $table->dropForeign('status_semhas_penguji_2_id');
            $table->dropForeign('status_semhas_proposal_id');
            $table->dropColumn('status_semhas_penguji_1_id');
            $table->dropColumn('status_semhas_penguji_2_id');
            $table->dropColumn('status_semhas_proposal_id');
        });
    }
};
