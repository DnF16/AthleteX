<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'academic_term_year',
        'total_units_enrolled',
        'tuition_fee',
        'misc_fee',
        'other_charges',
        'total_assessment',
        'total_discount',
        'remarks',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
