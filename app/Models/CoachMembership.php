<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'year',
        'date',
        'venue',
        'name_of_organization',
        'level',
        'position',
        'remarks',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
