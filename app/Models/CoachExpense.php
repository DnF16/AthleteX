<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'academic_year',
        'term',
        'type',
        'amount',
        'event_athlete',
        'notes',
        'remarks',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
