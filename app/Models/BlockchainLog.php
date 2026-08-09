<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockchainLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'payload',
        'previous_hash',
        'current_hash',
    ];

    // Links the log back to the Admin or Coach who made the change
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}