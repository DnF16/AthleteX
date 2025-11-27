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
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();

            // 1st Row
            $table->string('coach_last_name')->nullable();
            $table->string('coach_first_name')->nullable();
            $table->string('coach_middle_initial')->nullable();

            // 2nd Row
            $table->string('coach_gender')->nullable();
            $table->date('coach_birthdate')->nullable();
            $table->integer('coach_age')->nullable();

            // 3rd Row
            $table->string('coach_blood_type')->nullable();
            $table->string('coach_place_of_birth')->nullable();
            $table->string('coach_marital_status')->nullable();

            // 4th Row
            $table->string('coach_email')->nullable();
            $table->string('coach_facebook')->nullable();
            $table->string('coach_tba')->nullable();

            // 5th Row
            $table->string('coach_contact_number')->nullable();
            $table->string('coach_address')->nullable();

            // 6th Row
            $table->string('coach_city_municipality')->nullable();
            $table->string('coach_province_state')->nullable();
            $table->string('coach_zip_code')->nullable();

            // Emergency Contact
            $table->string('coach_emergency_person')->nullable();
            $table->string('coach_emergency_contact')->nullable();

            // Post Graduate
            $table->string('post_graduate')->nullable();
            $table->string('course_graduated')->nullable();
            $table->date('coach_year_graduated')->nullable();

            // College
            $table->string('name_collage')->nullable();
            $table->string('coach_course_graduated')->nullable();
            $table->date('coach_graduated')->nullable();

            // Highschool
            $table->string('coach_highschool')->nullable();
            $table->string('strand_graduated')->nullable();
            $table->date('highschool_graduated')->nullable();

            // Work Related
            $table->date('date_hired')->nullable();
            $table->string('honorarium_payment')->nullable();
            $table->date('date_resigned')->nullable();

            // Occupation
            $table->string('occupation')->nullable();
            $table->string('coach_current_company')->nullable();
<<<<<<< HEAD
            $table->string('coach_selected_name')->nullable();
            $table->string('coach_picturePreview')->nullable();
            $table->string('coach_noPictureText')->nullable();
=======

            // RIGHT SIDE — SPORTS EVENT, POSITION, STATUS, PICTURE
            $table->string('coach_sport_event')->nullable();
            $table->string('position')->nullable();
            $table->string('coach_status')->nullable();
            $table->string('coach_picture')->nullable(); // store image filename
            $table->date('coach_inactive_date')->nullable();

            // Notes
            $table->text('coach_notes')->nullable();

            $table->timestamps();
>>>>>>> af7ac3879a49a4a8dd05e88da8fbdfe72905d477
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
