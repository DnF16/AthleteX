<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'academic_year',
        'total_units',
        'tuition_fee',
        'miscellaneous_fee',
        'other_charges',
        'total_assessment',
        'total_discount',
        'remarks',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
