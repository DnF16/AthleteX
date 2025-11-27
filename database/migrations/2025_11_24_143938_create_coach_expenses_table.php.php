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
        Schema::create('coach_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');
            $table->string('academic_year')->nullable();
            $table->string('term')->nullable();
            $table->string('type')->nullable();  // e.g., Travel, Bonus, Supplies
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('event_athlete')->nullable(); // Event name or Athlete name/ID
            $table->text('notes')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
