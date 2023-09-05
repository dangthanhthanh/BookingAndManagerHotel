<?php

use App\Models\Role;
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
        Schema::create('role_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id')->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->timestamps();

            $table->primary(['staff_id', 'role_id']);
            $table->unique(['staff_id', 'role_id']); 

            $table->foreign('staff_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_lists');
    }
};
