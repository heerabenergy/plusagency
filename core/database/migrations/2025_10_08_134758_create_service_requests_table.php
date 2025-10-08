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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->text('user_agent');
            $table->ipAddress();
            $table->string('status')->default('pending');
            $table->json('fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
