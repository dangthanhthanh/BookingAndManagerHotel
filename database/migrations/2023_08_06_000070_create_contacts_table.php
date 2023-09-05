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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->text('messenger');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('status_id');//1 <=> not contacted yet 
            $table->string('status_history')->nullable();//1 <=> not contacted yet 
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status_contacts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
