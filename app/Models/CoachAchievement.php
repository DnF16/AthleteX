<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'year',
        'month_day',
        'sports_event',
        'venue',
        'award',
        'category',
        'remarks',
    ];

    // Relationship back to Coach
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
