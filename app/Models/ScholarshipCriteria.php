<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipCriteria extends Model
{
    use HasFactory;

    // FIX: Tell Laravel the exact table name
    protected $table = 'scholarship_criteria';

    protected $fillable = [
        'level', 
        'criteria_pts', 
        'criteria_percent', 
        'certificate_award'
    ];
}