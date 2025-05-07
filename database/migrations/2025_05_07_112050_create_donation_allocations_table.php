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
        Schema::create('donation_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->string('allocated_to'); // Could be a pet_id, shelter_id, or general purpose
            $table->string('allocation_type'); // e.g., 'pet_care', 'medical', 'food', 'shelter_maintenance'
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending, approved, completed
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_allocations');
    }
};
