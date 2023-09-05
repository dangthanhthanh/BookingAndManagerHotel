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
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->unsignedBigInteger('customer_id');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->unsignedBigInteger('room_category_id');
            $table->unsignedInteger('num_person');
            $table->unsignedInteger('num_child')->nullable();
            $table->unsignedBigInteger('status_id');//1 <=> not contacted yet 
            $table->string('status_history')->nullable();//1 <=> not contacted yet 
            $table->text('note')->nullable();
            $table->text('request')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status_contacts');
            $table->foreign('room_category_id')->references('id')->on('room_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_requests');
    }
};
