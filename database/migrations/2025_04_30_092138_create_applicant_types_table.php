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
            
            // Reference to the users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Reference to the adoption_requests table instead of pets
            $table->foreignId('adoption_request_id')->constrained('adoption_requests')->onDelete('cascade');
            
            // Enum for foster type: short-term or permanent
            $table->enum('foster_type', ['short-term', 'permanent']);
            
            // Enum for status: pending, approved, or rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Timestamps for tracking created and updated times
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
