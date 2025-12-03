<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'term',
        'academic_year',
        'count_a',
        'count_b',
        'count_c',
        'remarks',
    ];

    // Relationship back to Coach
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
