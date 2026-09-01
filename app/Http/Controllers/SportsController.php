<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\Athlete;

class SportsController extends Controller
{
    public function index()
    {
        return view('features.sports');
    }

    public function filter($sport)
    {
        $coaches = Coach::with(['athletes' => function($query) use ($sport) {
            if ($sport !== 'All') {
                $query->where('sport_event', $sport); 
            }
            $query->where('status', 'Active'); 
        }])
        ->whereHas('athletes', function($query) use ($sport) {
            if ($sport !== 'All') {
                $query->where('sport_event', $sport);
            }
        })
        ->get()
        ->map(function($coach) {
            
            $coachName = trim($coach->coach_first_name . ' ' . $coach->coach_last_name);
            
            if (empty($coachName)) {
                $coachName = 'Coach ID: ' . $coach->id;
            }

            return [
                'name' => $coachName, 
                'assistant_coach' => 'N/A', 
                'class_a' => $coach->athletes->where('classification', 'Class_A')->count(),
                'class_b' => $coach->athletes->where('classification', 'Class_B')->count(),
                'class_c' => $coach->athletes->where('classification', 'Class_C')->count(),
                'remarks' => 'Active Roster'
            ];
        });

        return response()->json($coaches);
    }
}