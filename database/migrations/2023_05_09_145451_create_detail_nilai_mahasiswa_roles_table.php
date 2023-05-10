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
        Schema::create('detail_nilai_mahasiswa_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nilai_role_id');
            $table->foreign('nilai_role_id')->references('id')->on('nilai_mahasiswa_roles')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('komponen_role_penilaian_id');
            $table->foreign('komponen_role_penilaian_id')->references('id')->on('role_kelompok_penilaians')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detail_nilai_mahasiswa_roles');
    }
};
