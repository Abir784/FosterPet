<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('donations', 'paypal_payment_id')) {
                $table->string('paypal_payment_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('donations', 'paypal_payer_id')) {
                $table->string('paypal_payer_id')->nullable()->after('paypal_payment_id');
            }
            if (!Schema::hasColumn('donations', 'paypal_token')) {
                $table->string('paypal_token')->nullable()->after('paypal_payer_id');
            }
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['transaction_id', 'paypal_payment_id', 'paypal_payer_id', 'paypal_token']);
        });
    }
};
