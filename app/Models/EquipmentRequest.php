<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'date_requested',
        'items',
        'requested_by',
        'status'
    ];

    protected $casts = [
        'items' => 'array',
        'date_requested' => 'date',
    ];
}