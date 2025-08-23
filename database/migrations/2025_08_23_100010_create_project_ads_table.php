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
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('member_id');
            $table->string('project_name');
            $table->enum('property_type', ['apartment', 'commercial']);
            $table->string('location');
            $table->integer('total_units')->check('total_units > 0');
            $table->decimal('measurement', 10, 2)->check('measurement > 0');
            $table->decimal('price', 15, 2)->check('price > 0');
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
            $table->date('completion_date')->nullable();
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
        Schema::dropIfExists('project_ads');
    }
};
