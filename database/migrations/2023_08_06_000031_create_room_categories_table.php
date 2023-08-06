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
        Schema::create('room_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255);
            $table->string('name', 100);
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('cost')->nullable();
            $table->unsignedBigInteger('image_id');
            $table->softDeletes();

            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_categories');
    }
};
