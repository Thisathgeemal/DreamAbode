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
        Schema::create('property_ads', function (Blueprint $table) {
            $table->bigIncrements('property_id');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->string('property_name');
            $table->enum('property_type', ['house', 'apartment', 'land', 'bungalow', 'villa', 'commercial']);
            $table->string('location');
            $table->decimal('measurement', 10, 2)->check('measurement > 0')->nullable();
            $table->decimal('perches', 10, 2)->check('perches > 0')->nullable();
            $table->integer('bedrooms')->check('bedrooms > 0')->nullable();
            $table->integer('bathrooms')->check('bathrooms > 0')->nullable();
            $table->integer('floors')->check('floors >= 0')->nullable();
            $table->decimal('price', 15, 2)->check('price > 0');
            $table->enum('post_type', ['sale', 'rent']);
            $table->enum('status', ['pending', 'approve', 'reject', 'done'])->default('pending');
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_ads');
    }
};
