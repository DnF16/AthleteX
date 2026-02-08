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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('coach_id')->nullable()->constrained('coaches')->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('course')->nullable();
            $table->string('year_level')->nullable();
            $table->string('sport')->nullable();

            // Additional fields used by views/forms
            $table->string('full_name')->nullable();
            $table->string('athlete_id')->nullable();
            $table->string('middle_initial')->nullable();
            $table->string('sport_event')->nullable();
            $table->string('status')->nullable();
            $table->string('classification')->nullable();
            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('age')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('province_state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('emergency_person')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('coach_name')->nullable();
            $table->string('date_joined')->nullable();
            $table->string('term_graduated')->nullable();
            $table->string('asst_coach')->nullable();
            $table->string('total_unit')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('tuition_fee')->nullable();
            $table->string('misc_fee')->nullable();
            $table->string('other_charges')->nullable();
            $table->string('total_assessment')->nullable();
            $table->string('total_discount')->nullable();
            $table->string('balance')->nullable();
            $table->string('current_work')->nullable();
            $table->string('current_company')->nullable();
            $table->string('picture_path')->nullable();
            $table->text('notes')->nullable();
            $table->date('inactive_date')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
