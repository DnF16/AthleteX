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
        'emergency_relationship', // ADDED (Was missing)

        // System
        'picture_path',
        'approval_status',
        'approval_notes',
        'approved_at',
        'approved_by',
    ];

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
