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
        Schema::create('regulasis', function (Blueprint $table) {
            $table->id();

            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('krs_id');
            $table->foreign('krs_id')->references('id')->on('krs')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('seminar')->nullable();
            $table->integer('sidang')->nullable();
            $table->integer('prasidang')->nullable();
            $table->integer('proposal')->nullable();
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
        Schema::dropIfExists('regulasis');
    }
};
