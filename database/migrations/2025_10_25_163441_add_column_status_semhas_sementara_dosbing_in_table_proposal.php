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
            $table->foreignId('status_semhas_dosbing_1_id')->nullable()->constrained('status_proposal')->onDelete('cascade');
            $table->foreignId('status_semhas_dosbing_2_id')->nullable()->constrained('status_proposal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->dropForeign('status_semhas_dosbing_1_id');
            $table->dropForeign('status_semhas_dosbing_2_id');
            $table->dropColumn('status_semhas_dosbing_1_id');
            $table->dropColumn('status_semhas_dosbing_2_id');
        });
    }
};
