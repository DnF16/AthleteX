<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachSeminar extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'year',
        'date',
        'venue',
        'title_of_seminar_workshop',
        'level',
        'remarks',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
