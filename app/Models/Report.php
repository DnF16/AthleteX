<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'status',
        'received_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
