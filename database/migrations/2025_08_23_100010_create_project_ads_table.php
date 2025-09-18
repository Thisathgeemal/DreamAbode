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
        Schema::create('project_ads', function (Blueprint $table) {
            $table->bigIncrements('project_id');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->json('buyer_ids')->nullable();
            $table->string('project_name');
            $table->string('location');
            $table->decimal('price', 15, 2)->check('price > 0');
            $table->enum('property_type', ['apartment', 'commercial']);
            $table->integer('total_units')->check('total_units > 0');
            $table->integer('available_units')->check('available_units >= 0');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->decimal('measurement', 10, 2)->check('measurement > 0');
            $table->enum('project_status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
            $table->date('completion_date')->nullable();
            $table->enum('status', ['pending', 'approve', 'reject', 'complete'])->default('pending');
            $table->timestamps();

            // Foreign keys
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
        Schema::dropIfExists('project_ads');
    }
};
