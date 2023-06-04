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
        Schema::table('template_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('krs_id')->after('id');
            $table->foreign('krs_id')->references('id')->on('krs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_documents', function (Blueprint $table) {
            //
        });
    }
};
