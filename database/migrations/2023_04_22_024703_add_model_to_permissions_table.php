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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('model_type');
            $table->unsignedBigInteger('model_id')->uni;
        });
    }

    /**
     * Reverse the migrations.x
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
};
