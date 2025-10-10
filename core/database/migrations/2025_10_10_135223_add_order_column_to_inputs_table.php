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
        Schema::table('service_inputs', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('active');
        });
        Schema::table("package_inputs", function (Blueprint $table) {
            $table->integer('order')->default(0);
        });
        Schema::table("quote_inputs", function (Blueprint $table) {
            $table->integer('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_inputs', function (Blueprint $table) {
            $table->dropColumn('order');
        });
        Schema::table("package_inputs", function (Blueprint $table) {
            $table->dropColumn('order');
        });
        Schema::table("quote_inputs", function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
