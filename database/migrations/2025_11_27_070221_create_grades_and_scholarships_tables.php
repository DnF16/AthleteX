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
        // 1. Grades Table
        if (!Schema::hasTable('grade_scales')) {
            Schema::create('grade_scales', function (Blueprint $table) {
                $table->id();
                $table->string('grade')->nullable();       // A, B, C
                $table->string('min_percent')->nullable(); // 90
                $table->string('min_score')->nullable();   // 90
                $table->timestamps();
            });
        }

        // 2. Scholarships Table
        if (!Schema::hasTable('scholarship_criteria')) {
            Schema::create('scholarship_criteria', function (Blueprint $table) {
                $table->id();
                $table->string('level')->nullable();             // 1st Year
                $table->string('criteria_pts')->nullable();      // 100
                $table->string('criteria_percent')->nullable();  // 100%
                $table->string('certificate_award')->nullable(); // Full Scholarship
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('grade_scales');
        Schema::dropIfExists('scholarship_criteria');
    }
};
