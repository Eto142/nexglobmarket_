<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id', 100);
            $table->integer('amount');
            $table->string('bot')->nullable();
            $table->string('payment_method');
            $table->string('trading_name', 250)->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=approved');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
