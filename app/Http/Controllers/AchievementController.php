<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

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

        return response()->json([
            'message' => 'Achievement added successfully.',
            'data' => $achievement
        ]);
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

        return response()->json([
            'message' => 'Achievement updated successfully.',
            'data' => $achievement
        ]);
    }

    /**
     * Delete an achievement.
     */
    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();

        return response()->json([
            'message' => 'Achievement deleted successfully.'
        ]);
    }
}
