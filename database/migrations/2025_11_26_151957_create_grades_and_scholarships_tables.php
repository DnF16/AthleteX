<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Table for Grades (A, B, C...)
        Schema::create('grade_scales', function (Blueprint $table) {
            $table->id();
            $table->string('grade');       // A, B, C
            $table->string('min_percent'); // 90
            $table->string('min_score');   // 90
            $table->timestamps();
        });

        // Table for Scholarships
        Schema::create('scholarship_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('level');             // 1st Year
            $table->string('criteria_pts');      // 100
            $table->string('criteria_percent');  // 100%
            $table->string('certificate_award'); // Full Scholarship
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades_and_scholarships_tables');
    }
};
