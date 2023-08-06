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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique()->index();
            $table->string('provider_name')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('cccd')->nullable();
            $table->string('phone')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('remember_token')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('avatar_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
