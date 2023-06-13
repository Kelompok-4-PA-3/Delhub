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
        Schema::create('nilai_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_id');
            $table->foreign('kelompok_id')->references('id')->on('kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('poin_penilaian_id');
            $table->foreign('poin_penilaian_id')->references('id')->on('poin_penilaians')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('role_dosen_kelompok_id');
            $table->foreign('role_dosen_kelompok_id')->references('id')->on('role_kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswas')->onUpdate('cascade')->onDelete('cascade');
            $table->double('nilai');
            $table->integer('approved_status');
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
        Schema::dropIfExists('nilai_mahasiswas');
    }
};
