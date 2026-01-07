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
        'course',
        'year_level',
        'sport',

        // additional fields used by views/forms
        'full_name',
        'athlete_id',
        'middle_initial',
        'sport_event',
        'status',
        'classification',
        'gender',
        'birthdate',
        'age',
        'blood_type',
        'email',
        'facebook',
        'marital_status',
        'contact_number',
        'address',
        'city_municipality',
        'province_state',
        'zip_code',
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
        
        // Approval workflow
        'approval_status',
        'approval_notes',
        'approved_at',
        'approved_by',
    ];

    // Cast fields to proper types
    protected $casts = [
        'birthdate' => 'date',
        'approved_at' => 'datetime',
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
