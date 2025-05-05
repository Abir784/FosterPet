<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoption_requests', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('adoptionID');
            $table->unsignedBigInteger('adopterID');
            $table->string('status');
            $table->timestamps();
           // $table->foreignId('adoption_request_id')->constrained('adoption_requests')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoption_requests');
    }
};