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
        'term',
        'fee_type',
        'discount_type',
        'amount',
        'notes',
        'remarks',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
