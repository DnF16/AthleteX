<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeScale extends Model
{
    use HasFactory;

    // 1. ALLOW MASS ASSIGNMENT
    protected $fillable = [
        'grade', 
        'min_percent', 
        'min_score'
    ];
}