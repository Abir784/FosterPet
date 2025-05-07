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
        Schema::create('adoption_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adoption_request_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comment');
            $table->enum('response', ['support', 'neutral', 'oppose']);
            $table->timestamps();
            
            $table->foreign('adoption_request_id')->references('id')->on('adoption_requests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_responses');
    }
};
