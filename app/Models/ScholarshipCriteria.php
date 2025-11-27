<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipCriteria extends Model
{
    use HasFactory;

    // 1. LINK TO CORRECT TABLE
    protected $table = 'scholarship_criteria';

    // 2. ALLOW MASS ASSIGNMENT
    protected $fillable = [
        'level', 
        'criteria_pts', 
        'criteria_percent', 
        'certificate_award'
    ];
}