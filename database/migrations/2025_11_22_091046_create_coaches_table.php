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
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('coach_last_name');
            $table->string('coach_first_name');
            $table->string('coach_middle_name')->nullable();
            $table->string('coach_gender')->nullable();
            $table->string('coach_birthdate')->nullable();
            $table->string('coach_age')->nullable();
            $table->string('coach_blood_type')->nullable();
            $table->string('coach_place_of_birth')->nullable();
            $table->string('coach_sport_event')->nullable();
            $table->string('coach_marital_status')->nullable();
            $table->string('coach_email')->nullable();
            $table->string('coach_facebook')->nullable();
            $table->string('coach_tba')->nullable();
            $table->string('coach_contact_number')->nullable();
            $table->string('coach_address')->nullable();
            $table->string('coach_city_municipality')->nullable();
            $table->string('coach_province_state')->nullable();
            $table->string('coach_zip_code')->nullable();
            $table->string('coach_emergency_person')->nullable();
            $table->string('coach_emergency_contact')->nullable();
            $table->string('post_graduate')->nullable();
            $table->string('course_graduated')->nullable();
            $table->string('coach_year_graduated')->nullable();
            $table->string('name_collage')->nullable();
            $table->string('coach_course_graduated')->nullable();
            $table->string('coach_graduated')->nullable();
            $table->string('coach_highschool')->nullable();
            $table->string('strand_graduated')->nullable();
            $table->string('highschool_graduated')->nullable();
            $table->string('date_hired')->nullable();
            $table->string('honorarium_payment')->nullable();
            $table->string('date_resigned')->nullable();
            $table->string('occupation')->nullable();
            $table->string('coach_current_company')->nullable();
            $table->string('coach_selected_name')->nullable();
            $table->string('coach_picturePreview')->nullable();
            $table->string('coach_noPictureText')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
};
