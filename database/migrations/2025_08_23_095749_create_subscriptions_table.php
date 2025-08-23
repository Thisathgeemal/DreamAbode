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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('subscription_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('payment_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'active', 'expired', 'canceled'])->default('pending');
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('type_id')->on('subscription_types')->onDelete('cascade');
            $table->foreign('payment_id')->references('payment_id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
