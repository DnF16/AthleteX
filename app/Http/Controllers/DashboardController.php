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
        $user = auth()->user();
        
        // 1. Start a base query
        $athleteQuery = Athlete::query();

        // 2. 🔒 STRICT RBAC CHECK: Lock the query down to ONLY their sport!
        if ($user->role === 'coach') {
            $coachSport = $user->coach->coach_sport_event ?? null;
            
            if ($coachSport) {
                $athleteQuery->where('sport_event', $coachSport);
            } else {
                // If testing account has no sport assigned, force 0 results safely
                $athleteQuery->whereNull('id'); 
            }
        }

        // 3. Now do the counts using the (clone) trick. 
        $activeAthletesCount = (clone $athleteQuery)
            ->where('status', 'Active')
            ->where('classification', '!=', 'Tryout') 
            ->count();

        $alumniCount = (clone $athleteQuery)
            ->where('status', 'Graduated') 
            ->count();

        $inactive = (clone $athleteQuery)
            ->where('status', 'Inactive')
            ->count();

        // 4. Global Stats (Coaches and total achievements usually stay global)
        $coachesCount = Coach::count();
        $totalAchievements = Achievement::count();

        $achievementsMonthly = Achievement::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('features.dashboard', compact('activeAthletesCount', 'alumniCount', 'coachesCount', 'inactive', 'totalAchievements', 'achievementsMonthly'));
    }
}