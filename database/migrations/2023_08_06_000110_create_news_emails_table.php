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
        Schema::create('news_emails', function (Blueprint $table) {
            $table->string('email', 255)->primary()->index();
            $table->string('hash_token', 255)->nullable();
            $table->timestamp('verificated_at')->nullable();
            $table->boolean('sent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_emails');
    }
};
