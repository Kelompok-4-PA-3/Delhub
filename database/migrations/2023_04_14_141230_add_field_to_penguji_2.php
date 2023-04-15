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
        Schema::table('pembimbings', function (Blueprint $table) {
            $table->unsignedBigInteger('kelompok_id')->before('pembimbing_1');
            $table->foreign('kelompok_id')->references('id')->on('kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn('krs_id');
        });

        Schema::table('pengujis', function (Blueprint $table) {
            $table->unsignedBigInteger('kelompok_id')->before('penguji_1');
            $table->foreign('kelompok_id')->references('id')->on('kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn('krs_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengujis', function (Blueprint $table) {
            //
        });
    }
};
