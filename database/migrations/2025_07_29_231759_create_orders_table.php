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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('start_km');
            $table->unsignedBigInteger('end_km')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('ot_number')->nullable()->default(0);
            $table->integer('self_number')->nullable()->default(0);
            $table->integer('odd_point_number')->nullable()->default(0);

            $table->unsignedBigInteger('user_id');
            $table->index('user_id', 'order_user_idx');
            $table->foreign('user_id', 'order_user_fk')->on('users')->references('id');

            $table->unsignedBigInteger('client_id');
            $table->index('client_id', 'order_client_idx');
            $table->foreign('client_id', 'order_client_fk')->references('id')->on('clients');

            $table->unsignedBigInteger('truck_id');
            $table->index('truck_id', 'order_truck_idx');
            $table->foreign('truck_id', 'order_truck_fk')->references('id')->on('trucks');
            $table->text('description')->nullable();
            $table->integer('cash')->default(0);

            $table->integer('sum')->nullable();
            $table->integer('confirmed_sum')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
