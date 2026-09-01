<?php

namespace App\Http\Controllers;

use App\Models\TryoutSchedule;
use Illuminate\Http\Request;

class TryoutScheduleController extends Controller
{
    // 1. Show the page with the form and the list of schedules
    public function index()
    {
        // 1. Get the schedules
        $schedules = TryoutSchedule::orderBy('tryout_date', 'asc')->get();
        
        // 2. Get the students who PASSED the tryout (Status is Active, but Classification is still Tryout)
        $recruits = \App\Models\Athlete::where('status', 'Active')
                                       ->where('classification', 'Tryout')
                                       ->latest()
                                       ->get();

        return view('features.tryout_schedules', compact('schedules', 'recruits'));
    }

    // 2. Save a new schedule
    public function store(Request $request)
    {
        $request->validate([
            'sport_event' => 'required|string',
            'tryout_date' => 'required|date',
            'tryout_time' => 'required',
            'venue'       => 'required|string',
            'notes'       => 'nullable|string',
        ]);

        TryoutSchedule::create($request->all());

        return redirect()->back()->with('success', 'Tryout schedule added successfully!');
    }

    // 3. Update an existing schedule (NEW EDIT FEATURE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'sport_event' => 'required|string',
            'tryout_date' => 'required|date',
            'tryout_time' => 'required',
            'venue'       => 'required|string',
            'notes'       => 'nullable|string',
        ]);

        $schedule = TryoutSchedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->back()->with('success', 'Tryout schedule updated successfully!');
    }

    // 4. Delete a schedule (Using POST to avoid the DELETE method error we had before!)
    public function destroy($id)
    {
        TryoutSchedule::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Schedule removed.');
    }
}