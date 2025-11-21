<?php

namespace App\Http\Controllers;

use App\Models\WorkHistory;
use Illuminate\Http\Request;

class WorkHistoryController extends Controller
{
    // Save Work History Record
    public function store(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required|exists:athletes,id',
        ]);

        $record = WorkHistory::create([
            'athlete_id' => $request->athlete_id,
            'year' => $request->year,
            'date' => $request->date,
            'position' => $request->position,
            'company' => $request->company,
            'remarks' => $request->remarks,
        ]);

        return response()->json([
            'message' => 'Work history saved successfully.',
            'data' => $record
        ]);
    }

    // Load all work history for specific athlete
    public function show($athlete_id)
    {
        $records = WorkHistory::where('athlete_id', $athlete_id)->get();
        return response()->json($records);
    }
}
