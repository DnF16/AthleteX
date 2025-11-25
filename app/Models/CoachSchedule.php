<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'event',
        'date',
        'athlete_list',
        'remarks',
    ];

    // Relationship back to Coach
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
