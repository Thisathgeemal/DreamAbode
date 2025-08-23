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
        Schema::create('subscription_types', function (Blueprint $table) {
            $table->bigIncrements('type_id');
            $table->string('type_name');
            $table->integer('duration_days')->check('duration_days > 0');
            $table->decimal('base_amount', 10, 2)->check('base_amount >= 0');
            $table->decimal('discount_percent', 5, 2)->check('discount_percent >= 0');
            $table->decimal('final_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_types');
    }
};
