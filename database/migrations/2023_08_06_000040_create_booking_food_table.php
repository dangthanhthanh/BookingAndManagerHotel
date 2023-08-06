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
        Schema::create('booking_food', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique()->index();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('food_id');
            $table->unsignedBigInteger('cost')->nullable();
            $table->unsignedInteger('qty')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('food_id')->references('id')->on('food');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_food');
    }
};
