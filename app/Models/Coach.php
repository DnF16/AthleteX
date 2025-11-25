<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_last_name',
        'coach_first_name',
        'coach_middle_initial',
        'coach_gender',
        'coach_birthdate',
        'coach_age',
        'coach_blood_type',
        'coach_place_of_birth',
        'coach_marital_status',
        'coach_email',
        'coach_facebook',
        'coach_tba',
        'coach_contact_number',
        'coach_address',
        'coach_city_municipality',
        'coach_province_state',
        'coach_zip_code',
        'coach_emergency_person',
        'coach_emergency_contact',
        'post_graduate',
        'course_graduated',
        'coach_year_graduated',
        'name_collage',
        'coach_course_graduated',
        'coach_graduated',
        'coach_highschool',
        'strand_graduated',
        'highschool_graduated',
        'date_hired',
        'honorarium_payment',
        'date_resigned',
        'occupation',
        'coach_current_company',
        'coach_sport_event',
        'position',
        'coach_status',
        'coach_picture',
        'coach_inactive_date',
        'coach_notes',
    ];

    protected $casts = [
        'coach_birthdate' => 'date',
        'coach_year_graduated' => 'date',
        'coach_graduated' => 'date',
        'highschool_graduated' => 'date',
        'date_hired' => 'date',
        'date_resigned' => 'date',
        'coach_inactive_date' => 'date',
        'coach_age' => 'integer',
    ];

    // Relationships
    public function achievements()
    {
        return $this->hasMany(CoachAchievement::class);
    }

    public function workHistories()
    {
        return $this->hasMany(CoachWorkHistory::class);
    }

    public function memberships()
    {
        return $this->hasMany(CoachMembership::class); 
    }
    public function seminars()
    {
        return $this->hasMany(CoachSeminar::class); 
    }
    public function schedule()
    {
        return $this->hasMany(CoachSchedule::class);
    }
    public function expenses()
    {
        return $this->hasMany(CoachExpense::class);
    }

}
