<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'coach_id',
        'date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    // Check if this attendance record is for today
    public function isToday()
    {
        return $this->date->isToday();
    }

    // Check if this attendance record is editable (only today)
    public function isEditable()
    {
        return $this->isToday();
    }
    
}
