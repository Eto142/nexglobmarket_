<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image', 250);
            $table->string('win_rate', 250)->nullable();
            $table->string('profit_share', 250)->nullable();
            $table->string('copier')->nullable();
            $table->string('gains')->nullable();
            $table->string('risk')->nullable();
            $table->string('loss')->nullable();
            $table->string('commission')->nullable();
            $table->string('total_transactions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('traders');
    }
};
