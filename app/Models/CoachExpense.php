<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'year',
        'date',
        'title',
        'estimate_budget',
        'actual_budget',
        'variance',
        'remark',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
