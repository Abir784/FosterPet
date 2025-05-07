<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('message_reports')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->text('response_content');
            $table->boolean('email_sent')->default(false);
            $table->string('action_taken')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_responses');
    }
};
