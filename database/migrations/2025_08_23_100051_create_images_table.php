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
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('image_id');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('property_id')->references('property_id')->on('property_ads')->onDelete('set null');
            $table->foreign('project_id')->references('project_id')->on('project_ads')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
