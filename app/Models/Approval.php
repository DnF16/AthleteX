<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_id',
        'status',
        'notes',
        'approved_by',
        'approved_at',
    ];

    // Relationships
    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
