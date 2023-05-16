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
        Schema::create('role_kelompok_penilaians', function (Blueprint $table) {
            $table->id();
            $table->web('role_group_id');
            $table->foreign('role_group_id')->references('id')->on('role_groups')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama');
            $table->double('bobot');
            $table->boolean('is_verified')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_kelompok_penilaians');
    }
};
