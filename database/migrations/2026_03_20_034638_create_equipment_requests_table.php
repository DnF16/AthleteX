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
        Schema::create('equipment_requests', function (Blueprint $table) {
            $table->id();
            
            // From the top of the form
            $table->string('event')->nullable();
            $table->date('date_requested');
            
            // The table of items (saved as JSON!)
            $table->json('items'); // This will hold Qty, Unit, Description, and Amount
            
            // Approval tracking
            $table->string('requested_by')->nullable(); // Name of coach
            $table->string('status')->default('Pending'); // Pending, Approved, Rejected
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_requests');
    }
};
