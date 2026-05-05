<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 100)->nullable()->after('email');
            $table->string('country', 100)->nullable()->after('phone');
            $table->string('state', 100)->nullable()->after('country');
            $table->string('pcode', 100)->nullable()->after('state');
            $table->string('photo', 100)->nullable()->after('pcode');
            $table->string('dob', 100)->nullable()->after('photo');
            $table->string('pin', 100)->nullable()->after('dob');
            $table->string('address', 100)->nullable()->after('pin');
            $table->string('usertype', 100)->default('0')->after('address');
            $table->string('eth_address', 100)->nullable()->after('usertype');
            $table->string('btc_address', 100)->nullable()->after('eth_address');
            $table->string('usdt_address', 100)->nullable()->after('btc_address');
            $table->string('btcImage', 100)->nullable()->after('usdt_address');
            $table->string('ethImage', 100)->nullable()->after('btcImage');
            $table->string('usdtImage', 100)->nullable()->after('ethImage');
            $table->string('signal_strength', 100)->nullable()->after('usdtImage');
            $table->string('update_escrow', 250)->nullable()->after('signal_strength');
            $table->string('update_notification', 1000)->nullable()->after('update_escrow');
            $table->string('id_card', 250)->nullable()->after('update_notification');
            $table->string('user_status', 250)->default('0')->after('id_card');
            $table->string('passport', 250)->nullable()->after('user_status');
            $table->string('kyc_status', 250)->default('0')->after('passport');
            $table->string('is_activated', 250)->default('0')->after('kyc_status');
            $table->string('bot_image', 100)->default('0')->after('is_activated');
            $table->string('withdrawal_code', 250)->nullable()->after('bot_image');
            $table->string('withdrawal_amount', 250)->nullable()->after('withdrawal_code');
            $table->string('withdrawal_tax_amount', 250)->nullable()->after('withdrawal_amount');
            $table->string('withdrawal_percentage', 250)->nullable()->after('withdrawal_tax_amount');
            $table->string('bot_status', 100)->nullable()->after('withdrawal_percentage');
            $table->string('token', 250)->nullable()->after('bot_status');
            $table->string('withdrawal_tax_code', 250)->nullable()->after('token');
            $table->string('profit_limit_status', 250)->default('0')->after('withdrawal_tax_code');
            $table->string('show_password', 250)->nullable()->after('profit_limit_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'country', 'state', 'pcode', 'photo', 'dob', 'pin', 'address',
                'usertype', 'eth_address', 'btc_address', 'usdt_address', 'btcImage',
                'ethImage', 'usdtImage', 'signal_strength', 'update_escrow',
                'update_notification', 'id_card', 'user_status', 'passport', 'kyc_status',
                'is_activated', 'bot_image', 'withdrawal_code', 'withdrawal_amount',
                'withdrawal_tax_amount', 'withdrawal_percentage', 'bot_status', 'token',
                'withdrawal_tax_code', 'profit_limit_status', 'show_password',
            ]);
        });
    }
};
