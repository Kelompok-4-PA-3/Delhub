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
        Schema::create('detail_nilai_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nilai_id');
            $table->foreign('nilai_id')->references('id')->on('nilai_mahasiswas')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('komponen_id');
            $table->foreign('komponen_id')->references('id')->on('komponen_penilaians')->onUpdate('cascade')->onDelete('cascade');
            $table->double('nilai');
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
        Schema::dropIfExists('detail_nilai_mahasiswas');
    }
};
