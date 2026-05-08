<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('show_kyc_notice')->default(1)->after('show_password');
            $table->tinyInteger('show_signal_strength')->default(1)->after('show_kyc_notice');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['show_kyc_notice', 'show_signal_strength']);
        });
    }
};
