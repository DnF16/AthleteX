<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    
    // 1. Explicitly link to the correct table name
    protected $table = 'certificates'; 

    // 2. Define the columns that can be written to
    protected $fillable = [
        'name', 
        'type', 
        'filename', 
        'thumbnail_path' // Assuming your migration used this column name
    ];
}