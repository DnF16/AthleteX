<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\Athlete;

class SportsController extends Controller
{
    public function filter($sport)
    {
        // Get coaches who manage the selected sport
        $coaches = Coach::with(['athletes' => function($query) use ($sport) {
            if ($sport !== 'All') {
                $query->where('sport', $sport);
            }
        }])->when($sport !== 'All', function($query) use ($sport) {
            $query->where('sport', $sport);
        })->get();

        return response()->json($coaches);
    }
}
