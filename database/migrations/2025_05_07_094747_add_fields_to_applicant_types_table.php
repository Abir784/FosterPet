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
        Schema::table('applicant_types', function (Blueprint $table) {
            $table->integer('duration')->nullable()->comment('Duration in weeks for short-term foster');
            $table->text('temporary_address')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('housing_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_types', function (Blueprint $table) {
            $table->dropColumn([
                'duration',
                'temporary_address',
                'employment_status',
                'housing_status'
            ]);
        });
    }
};
