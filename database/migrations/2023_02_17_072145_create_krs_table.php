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
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mk_id');
            $table->foreign('mk_id')->references('id')->on('kategoris')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori_proyeks')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('config_id');
            $table->foreign('config_id')->references('id')->on('configs')->onUpdate('cascade')->onDelete('cascade');
            $table->string('dosen_mk');
            $table->foreign('dosen_mk')->references('nidn')->on('dosens')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('prodi_id');
            $table->foreign('prodi_id')->references('id')->on('prodis')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('angkatan');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
