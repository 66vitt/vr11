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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->char('model', 50);
            $table->char('number', 50);
            $table->char('color', 50);
            $table->date('assicurazione')->nullable();
            $table->date('takho_to')->nullable();
            $table->date('to_date')->nullable();
            $table->date('service_date')->nullable();
            $table->integer('to_km')->nullable();
            $table->integer('now_km')->nullable();
            $table->integer('total_height')->nullable();
            $table->integer('body_height')->nullable();
            $table->integer('body_width')->nullable();
            $table->integer('body_length')->nullable();
            $table->integer('tonnage')->nullable();

            $table->unsignedInteger('image_id')->nullable();
            $table->foreign('image_id')
                ->references('id')
                ->on('attachments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
