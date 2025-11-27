<?php

namespace App\Http\Controllers;

use App\Models\CoachAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachAchievementController extends Controller
{
    // Fetch achievements for a specific coach
    public function show($coach_id)
    {
        $achievements = CoachAchievement::where('coach_id', $coach_id)->get();
        return response()->json($achievements);
    }

    // Store new achievement
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coach_id' => 'required|exists:coaches,id',
            'year' => 'nullable|string|max:10',
            'month_day' => 'nullable|string|max:20',
            'sports_event' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'award' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $achievement = CoachAchievement::create($request->all());

        return response()->json(['success' => true, 'achievement' => $achievement]);
    }

    // Update existing achievement
    public function update(Request $request, $id)
    {
        $achievement = CoachAchievement::findOrFail($id);
        $achievement->update($request->all());
        return response()->json(['success' => true, 'achievement' => $achievement]);
    }

    // Delete achievement
    public function destroy($id)
    {
        $achievement = CoachAchievement::findOrFail($id);
        $achievement->delete();
        return response()->json(['success' => true]);
    }
}
