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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_id')
                  ->constrained('athletes')
                  ->onDelete('cascade');
            $table->foreignId('coach_id')
                  ->nullable()
                  ->constrained('coaches')
                  ->onDelete('set null');
            $table->date('date')->default(\Carbon\Carbon::today());
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('absent');
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Unique constraint to prevent duplicate records for the same athlete/date
            $table->unique(['athlete_id', 'date']);
            
            // Index for faster queries
            $table->index('date');
            $table->index('coach_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};