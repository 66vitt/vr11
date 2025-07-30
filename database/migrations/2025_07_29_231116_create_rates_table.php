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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('city');
            $table->unsignedSmallInteger('region100');
            $table->unsignedSmallInteger('region150');
            $table->unsignedSmallInteger('region200');
            $table->unsignedSmallInteger('region250');
            $table->unsignedSmallInteger('region300');
            $table->unsignedSmallInteger('region350');
            $table->unsignedSmallInteger('region400');
            $table->unsignedSmallInteger('region450');
            $table->unsignedSmallInteger('city_limit_time');
            $table->unsignedSmallInteger('hour_cost_over_limit');
            $table->unsignedSmallInteger('ot_cost');
            $table->unsignedSmallInteger('self_cost');
            $table->unsignedSmallInteger('odd_point_cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
