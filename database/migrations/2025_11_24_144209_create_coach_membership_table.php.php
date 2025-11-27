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
        Schema::create('coach_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');
            $table->string('academic_term_year')->nullable();
            $table->decimal('total_units_enrolled', 8, 2)->nullable();
            $table->decimal('tuition_fee', 12, 2)->nullable();
            $table->decimal('misc_fee', 12, 2)->nullable();
            $table->decimal('other_charges', 12, 2)->nullable();
            $table->decimal('total_assessment', 12, 2)->nullable();
            $table->decimal('total_discount', 12, 2)->nullable();
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
