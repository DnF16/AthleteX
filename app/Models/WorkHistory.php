<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'year',
        'date',
        'position',
        'company',
        'remarks',
    ];

    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
