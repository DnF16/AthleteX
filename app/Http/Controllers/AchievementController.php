<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\CoachAchievement;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator; // 🚀 Added this for combined pagination!

class AchievementController extends Controller
{
    /**
     * Display all achievements of a specific athlete.
     */
    public function index($athlete_id)
    {
        $achievements = Achievement::where('athlete_id', $athlete_id)->get();
        return response()->json($achievements);
    }

    /**
     * Store a new achievement.
     */
    public function store(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required|exists:athletes,id',
            'year' => 'required|string',
            'month_day' => 'required|string',
            'event' => 'required|string',
            'venue' => 'required|date',
            'award' => 'required|string',
            'category' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $achievement = Achievement::create([
            'athlete_id' => $request->athlete_id,
            'year' => $request->year,
            'month_day' => $request->month_day,
            'event' => $request->event,
            'venue' => $request->venue,
            'award' => $request->award,
            'category' => $request->category,
            'remarks' => $request->remarks,
        ]);

        return response()->json(['message' => 'Achievement added successfully.', 'data' => $achievement]);
    }

    /**
     * Update an achievement.
     */
    public function update(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $request->validate([
            'year' => 'required|string',
            'month_day' => 'required|string',
            'event' => 'required|string',
            'venue' => 'required|string',
            'award' => 'required|string',
            'category' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $achievement->update($request->all());

        return response()->json(['message' => 'Achievement updated successfully.', 'data' => $achievement]);
    }

    /**
     * Delete an achievement.
     */
    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        return response()->json(['message' => 'Achievement deleted successfully.']);
    }

    /**
     * Display a global view of all achievements (Master List) for the new page.
     */
    public function globalIndex(Request $request)
    {
        $user = auth()->user();
        
        // Default to 'all' if no type is selected
        $type = $request->query('type', 'all');
        $month = $request->query('month');
        $search = $request->query('search');

        // =========================================
        // 1. BUILD STUDENT-ATHLETE QUERY
        // =========================================
        $athleteQuery = Achievement::with('athlete');
        if ($user->role === 'coach') {
            $coachSport = $user->coach->coach_sport_event ?? null;
            if ($coachSport) {
                $athleteQuery->whereHas('athlete', function($q) use ($coachSport) {
                    $q->where('sport_event', $coachSport);
                });
            } else {
                $athleteQuery->whereNull('id');
            }
        }
        if ($month) { $athleteQuery->whereMonth('created_at', $month); }
        if ($search) {
            $athleteQuery->where(function($q) use ($search) {
                $q->where('event', 'LIKE', "%{$search}%")->orWhere('award', 'LIKE', "%{$search}%");
            });
        }

        // =========================================
        // 2. BUILD COACH QUERY
        // =========================================
        $coachQuery = CoachAchievement::with('coach');
        if ($user->role === 'coach') {
            $coachId = $user->coach->id ?? null;
            if ($coachId) {
                $coachQuery->where('coach_id', $coachId);
            } else {
                $coachQuery->whereNull('id');
            }
        }
        if ($month) { $coachQuery->whereMonth('created_at', $month); }
        if ($search) {
            $coachQuery->where(function($q) use ($search) {
                $q->where('sports_event', 'LIKE', "%{$search}%")->orWhere('award', 'LIKE', "%{$search}%");
            });
        }

        // =========================================
        // 3. EXECUTE BASED ON TYPE SELECTED
        // =========================================
        if ($type === 'athlete') {
            $achievements = $athleteQuery->latest()->paginate(15);
            $achievements->getCollection()->transform(function($item) { $item->model_type = 'athlete'; return $item; });
        } elseif ($type === 'coach') {
            $achievements = $coachQuery->latest()->paginate(15);
            $achievements->getCollection()->transform(function($item) { $item->model_type = 'coach'; return $item; });
        } else {
            // "ALL" SELECTED -> MERGE BOTH TABLES!
            $athletes = $athleteQuery->get()->map(function($item) { $item->model_type = 'athlete'; return $item; });
            $coaches = $coachQuery->get()->map(function($item) { $item->model_type = 'coach'; return $item; });
            
            // Combine and sort by newest first
            $combined = $athletes->merge($coaches)->sortByDesc('created_at')->values();
            
            // Manually Paginate the merged list
            $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;
            $perPage = 15;
            $achievements = new LengthAwarePaginator(
                $combined->forPage($page, $perPage),
                $combined->count(),
                $perPage,
                $page,
                ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
            );
        }

        $achievements->appends($request->all());

        return view('features.achievements', compact('achievements', 'type'));
    }
}