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
        Schema::create('booking_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique()->index();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('room_status_id');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->unsignedInteger('number_per')->default(1);
            $table->unsignedBigInteger('cost')->nullable();
            $table->text('cus_request')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('room_status_id')->references('id')->on('room_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_rooms');
    }
};
