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
        Schema::create('payments', function (Blueprint $table) {
            $table->string('slug', 255)->primary()->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('payment_method_id')->default(1);
            $table->unsignedBigInteger('payment_status_id')->default(1);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
