<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'athlete_id',
        'year',
        'month_day',
        'event',
        'venue',
        'award',
        'category',
        'remarks',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
