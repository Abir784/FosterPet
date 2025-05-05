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
        Schema::create('applicant_types', function (Blueprint $table) {
            $table->id();
            
           
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
           
            $table->foreignId('adoption_request_id')->constrained('adoption_requests')->onDelete('cascade');
            
           
            $table->enum('foster_type', ['short-term', 'permanent']);
            
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_types');
    }
};
