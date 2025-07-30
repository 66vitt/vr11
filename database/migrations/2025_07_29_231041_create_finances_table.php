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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Пользователь, с которым проведена операция');
            $table->integer('sum');

            $table->unsignedBigInteger('order_id')->nullable()->comment('Если основание для операции находится в таблице заказов');
            $table->unsignedBigInteger('expense_id')->nullable()->comment('Если основание для операции находится в таблице расходов');
            $table->unsignedBigInteger('receipt_id')->nullable()->comment('Если основание для операции находится в таблице поступлений');
            $table->unsignedBigInteger('target')->comment('Назначение операции');
            $table->integer('total');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
