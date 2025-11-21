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
        Schema::create('fees_discounts', function (Blueprint $table) {
            $table->id();

            // FK → athlete
            $table->unsignedBigInteger('athlete_id');
            $table->foreign('athlete_id')
                ->references('id')
                ->on('athletes')
                ->onDelete('cascade');

            // Form fields
            $table->string('academic_year');        // Example: 2025–2026
            $table->integer('total_units')->nullable();
            $table->decimal('tuition_fee', 12, 2)->nullable();
            $table->decimal('miscellaneous_fee', 12, 2)->nullable();
            $table->decimal('other_charges', 12, 2)->nullable();
            $table->decimal('total_assessment', 12, 2)->nullable();
            $table->decimal('total_discount', 12, 2)->nullable();
            $table->string('remarks')->nullable(); // Paid, Pending, Waived

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_discounts');
    }
};
