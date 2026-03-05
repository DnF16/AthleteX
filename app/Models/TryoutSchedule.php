<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_event',
        'tryout_date',
        'tryout_time',
        'venue',
        'notes',
    ];
}