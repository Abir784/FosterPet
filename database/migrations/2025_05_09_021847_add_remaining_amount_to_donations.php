<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemainingAmountToDonations extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->decimal('remaining_amount', 10, 2)->after('amount');
        });

        // Update existing donations
        DB::statement('UPDATE donations SET remaining_amount = amount WHERE remaining_amount IS NULL');
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('remaining_amount');
        });
    }
}
