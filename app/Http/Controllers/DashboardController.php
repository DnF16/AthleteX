<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Achievement;

class DashboardController extends Controller
{
    public function index()
    {
        // Count active athletes
        $activeAthletesCount = Athlete::where('status', 'Active')->count();

        // Count alumni
        $alumniCount = Athlete::where('status', 'Alumni')->count();

        $coachesCount = Coach::count();

        // Count achievements
        $totalAchievements = Achievement::count();

        // Return the correct Blade file
        return view('features.dashboard', compact('activeAthletesCount', 'alumniCount', 'coachesCount', 'totalAchievements'));
    }
}
