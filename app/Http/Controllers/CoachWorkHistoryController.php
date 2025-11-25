<?php

namespace App\Http\Controllers;

use App\Models\CoachWorkHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachWorkHistoryController extends Controller
{
    // Show all work histories for a coach
    public function show($coach_id)
    {
        $workHistories = CoachWorkHistory::where('coach_id', $coach_id)->get();
        return response()->json($workHistories);
    }

    // Store new work history
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coach_id' => 'required|exists:coaches,id',
            'year' => 'nullable|date',
            'date' => 'nullable|date',
            'work_position' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $workHistory = CoachWorkHistory::create($request->all());
        return response()->json(['success' => true, 'workHistory' => $workHistory]);
    }

    // Update existing work history
    public function update(Request $request, $id)
    {
        $workHistory = CoachWorkHistory::findOrFail($id);
        $workHistory->update($request->all());
        return response()->json(['success' => true, 'workHistory' => $workHistory]);
    }

    // Delete a work history
    public function destroy($id)
    {
        $workHistory = CoachWorkHistory::findOrFail($id);
        $workHistory->delete();
        return response()->json(['success' => true]);
    }
}
