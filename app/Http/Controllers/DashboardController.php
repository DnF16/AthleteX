<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Achievement;
use Illuminate\Support\Facades\DB;

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

        $achievementsMonthly = Achievement::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->pluck('count', 'month');

        // Return the correct Blade file
        return view('features.dashboard', compact('activeAthletesCount', 'alumniCount', 'coachesCount', 'totalAchievements', 'achievementsMonthly'));
    }
}
