<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'passed',
        'enrolled',
        'percentage',
        'remark',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
