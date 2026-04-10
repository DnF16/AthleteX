<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Achievement;
use App\Models\CoachSchedule;
use Carbon\Carbon;
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

        // Count inactive (status != 'Active' for athletes + coaches)
        $inactiveAthletes = Athlete::where('status', '!=', 'Active')->count();
        $inactive = $inactiveAthletes + 0; // Add coaches if they have a status field

        // Get achievements grouped by month for the current year
        $achievementsMonthly = [];
        for ($month = 1; $month <= 12; $month++) {
            $count = Achievement::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $month)
                ->count();
            $achievementsMonthly[$month] = $count;
        }

        // Get schedule events (if you have CoachSchedule or similar)
        $scheduleEvents = [];
        try {
            if (class_exists('App\Models\CoachSchedule')) {
                $schedules = CoachSchedule::all();
                foreach ($schedules as $schedule) {
                    $scheduleEvents[] = [
                        'title' => $schedule->title ?? 'Event',
                        'start' => $schedule->date ?? $schedule->created_at,
                    ];
                }
            }
        } catch (\Exception $e) {
            $scheduleEvents = [];
        }

        // Athlete categories (e.g., by sport or year level)
        $athleteCategories = [];
        try {
            $athleteCategories = Athlete::where('status', 'Active')
                ->groupBy('sport')
                ->selectRaw('sport, COUNT(*) as count')
                ->pluck('count', 'sport')
                ->toArray();
        } catch (\Exception $e) {
            $athleteCategories = [];
        }

        // Return the correct Blade file
        return view('features.dashboard', compact(
            'activeAthletesCount',
            'alumniCount',
            'coachesCount',
            'totalAchievements',
            'inactive',
            'achievementsMonthly',
            'scheduleEvents',
            'athleteCategories'
        ));
    }
}
