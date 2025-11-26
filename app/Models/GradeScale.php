<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeScale extends Model
{
    protected $fillable = ['grade', 'min_percent', 'min_score'];
}
