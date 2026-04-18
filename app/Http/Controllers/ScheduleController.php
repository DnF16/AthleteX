<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query();

        // Filter by month if provided
        if ($request->has('month') && $request->month) {
            $month = date('m', strtotime($request->month));
            $year = date('Y', strtotime($request->month));
            $query->whereYear('event_date', $year)
                  ->whereMonth('event_date', $month);
        }

        $schedules = $query->orderBy('event_date')->orderBy('event_time')->get();

        return view('features.schedule', compact('schedules'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'activity' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sport' => 'nullable|string|max:255',
            'coach' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $schedule = Schedule::create($request->all());

        return response()->json([
            'success' => true,
            'schedule' => $schedule,
            'message' => 'Schedule created successfully'
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'activity' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sport' => 'nullable|string|max:255',
            'coach' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $schedule->update($request->all());

        return response()->json([
            'success' => true,
            'schedule' => $schedule,
            'message' => 'Schedule updated successfully'
        ]);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule deleted successfully'
        ]);
    }

    public function getEvents(Request $request)
    {
        $query = Schedule::query();

        if ($request->has('month') && $request->month) {
            $month = date('m', strtotime($request->month));
            $year = date('Y', strtotime($request->month));
            $query->whereYear('event_date', $year)
                  ->whereMonth('event_date', $month);
        }

        $schedules = $query->orderBy('event_date')->orderBy('event_time')->get();

        return response()->json($schedules);
    }
}
