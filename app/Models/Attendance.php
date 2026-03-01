<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'date',
        'status',
    ];

    // Relationship to athlete
    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
    
}
