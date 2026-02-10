<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'coach_id',
        'first_name',
        'last_name',     
        'middle_initial',
        'suffix',           // Added
        'course',
        'college',          // ADDED (Was missing)
        'year_level',
        'sport',
        'sport_event',
        'status',
        'classification',
        
        // Personal
        'gender',           // Matches DB column
        'birthdate',
        'age',
        'blood_type',
        'email',
        'facebook',
        'marital_status',   // Matches DB column
        'nationality',      // ADDED (Was missing)
        'place_of_birth',   // ADDED (Was missing)
        
        // Physical
        'height',           // ADDED (Was missing)
        'weight',           // ADDED (Was missing)

        // Contact
        'contact_number',
        'address',
        'city_municipality',
        'province_state',
        'zip_code',
        
        // Emergency
        'emergency_person',
        'emergency_contact',

        'coach_name',
        'date_joined',
        'term_graduated',
        'asst_coach',
        'total_unit',
        'year_graduated',
        'tuition_fee',
        'misc_fee',
        'other_charges',
        'total_assessment',
        'total_discount',
        'balance',
        'current_work',
        'current_company',
        'picture_path',
        'notes',
        'inactive_date',

        'emergency_relationship', // ADDED (Was missing)

        // System
        'picture_path',

    ];

    protected $casts = [
        'birthdate' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function academicEvaluations()
    {
        return $this->hasMany(AcademicEvaluation::class);
    }

    public function feesDiscounts()
    {
        return $this->hasMany(FeesDiscount::class);
    }

    public function workHistories()
    {
        return $this->hasMany(WorkHistory::class);
    }
    public function coach() {
        return $this->belongsTo(Coach::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
