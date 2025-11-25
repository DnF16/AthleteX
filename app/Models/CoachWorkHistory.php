<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachWorkHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'year',
        'date',
        'work_position',
        'company_name',
        'remarks',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
