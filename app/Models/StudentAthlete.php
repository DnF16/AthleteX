<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAthlete extends Model
{
    protected $table = 'student_athletes';

    protected $fillable = [
        'student_id',
        'last_name',
        'first_name',
        'middle_initial',
        'full_name',
        'sport',
        'status',
        'classification',
        'gender',
        'birthdate',
        'age',
        'current_work',
        'current_company',
        'picture_path',
        'inactive_date',
    ];
}
