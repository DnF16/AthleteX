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
            $table->smallInteger('year')->nullable();
            $table->date('date')->nullable();
            $table->string('title')->nullable();  // e.g., Travel, Bonus, Supplies
            $table->decimal('estimate_budget', 12, 2)->nullable();
            $table->decimal('actual_budget')->nullable(); // Event name or Athlete name/ID
            $table->text('variance')->nullable();
            $table->text('remark')->nullable();
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
