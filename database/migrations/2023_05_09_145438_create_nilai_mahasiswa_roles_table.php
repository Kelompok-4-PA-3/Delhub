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
        Schema::create('nilai_mahasiswa_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_kelompok_id');    
            $table->foreign('role_kelompok_id')->references('id')->on('role_kelompoks')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nim');    
            $table->foreign('nim')->references('nim')->on('mahasiswas')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('nilai_mahasiswa_roles');
    }
};
