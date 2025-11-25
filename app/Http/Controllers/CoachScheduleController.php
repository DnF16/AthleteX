<?php

namespace App\Http\Controllers;

use App\Models\CoachSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachScheduleController extends Controller
{
    // Fetch all schedules for a specific coach
    public function show($coach_id)
    {
        $schedules = CoachSchedule::where('coach_id', $coach_id)->get();
        return response()->json($schedules);
    }

    // Store a new schedule
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coach_id' => 'required|exists:coaches,id',
            'event' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'athlete_list' => 'nullable|string', // or JSON if sending array
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $schedule = CoachSchedule::create($request->all());
        return response()->json(['success' => true, 'schedule' => $schedule]);
    }

    // Update schedule
    public function update(Request $request, $id)
    {
        $schedule = CoachSchedule::findOrFail($id);
        $schedule->update($request->all());
        return response()->json(['success' => true, 'schedule' => $schedule]);
    }

    // Delete schedule
    public function destroy($id)
    {
        $schedule = CoachSchedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['success' => true]);
    }
}
