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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->index();
            $table->string('name', 50);
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('cost')->default(0);
            $table->integer('capacity');
            $table->integer('bed');
            $table->text('description')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('image_id')->references('id')->on('images');
            $table->foreign('category_id')->references('id')->on('room_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
