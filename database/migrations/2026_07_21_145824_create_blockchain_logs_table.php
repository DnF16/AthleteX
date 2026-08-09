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
        Schema::create('blockchain_logs', function (Blueprint $table) {
            $table->id();
            
            // Who made the change? (Nullable in case the system itself does something)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // What did they do? (e.g., 'Updated Athlete Tuition')
            $table->string('action');
            
            // The exact data they saved (Stored as JSON/Text)
            $table->longText('payload')->nullable();
            
            // The secret math codes (SHA-256 produces exactly 64 characters)
            // 'previous_hash' is nullable ONLY for the very first "Genesis" block
            $table->string('previous_hash', 64)->nullable(); 
            $table->string('current_hash', 64)->unique();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blockchain_logs');
    }
};
