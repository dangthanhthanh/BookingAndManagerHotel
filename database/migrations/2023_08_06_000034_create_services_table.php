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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->index();
            $table->string('name', 255);
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('category_id');
            $table->text('short_description');
            $table->text('description');
            $table->tinyInteger('active')->default(1);
            $table->integer('rate')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
