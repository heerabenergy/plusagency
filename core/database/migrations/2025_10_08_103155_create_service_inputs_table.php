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
        Schema::create('service_inputs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('service_id');
            $table->tinyInteger('type')->comment('1-text, 2-select, 3-checkbox, 4-textarea, 5-file');
            $table->string('label')->nullable();
            $table->string('name')->nullable();
            $table->string('placeholder')->nullable();
            $table->tinyInteger('required')->default(0)->comment('1 - required, 0 - optional');
            $table->tinyInteger('active')->default(1)->comment('0 - deactive, 1 - active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_inputs');
    }
};
