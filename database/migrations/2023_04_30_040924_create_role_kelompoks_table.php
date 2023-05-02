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
        Schema::create('role_kelompoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_group_id');
            $table->foreign('role_group_id')->references('id')->on('role_group_kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('kelompok_id');
            $table->foreign('kelompok_id')->references('id')->on('kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nidn');
            $table->foreign('nidn')->references('nidn')->on('dosens')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_role');
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
        Schema::dropIfExists('role_kelompoks');
    }
};
