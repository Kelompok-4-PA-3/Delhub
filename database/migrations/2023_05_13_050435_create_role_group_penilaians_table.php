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
        Schema::create('role_group_penilaians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_group_id');
            $table->foreign('role_group_id')->references('id')->on('role_group_kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('poin_penilaian_id');
            $table->foreign('poin_penilaian_id')->references('id')->on('poin_penilaians')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_verified')->default(false);
            $table->double('bobot');
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
        Schema::dropIfExists('role_group_penilaians');
    }
};
