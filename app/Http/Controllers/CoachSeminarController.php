<?php

namespace App\Http\Controllers;

use App\Models\CoachSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachSeminarController extends Controller
{
    // Fetch all seminars for a coach
    public function show($coach_id)
    {
        $seminars = CoachSeminar::where('coach_id', $coach_id)->get();
        return response()->json($seminars);
    }

    // Store a new seminar
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

        $seminar = CoachSeminar::create($request->all());
        return response()->json(['success' => true, 'seminar' => $seminar]);
    }

    // Update an existing seminar
    public function update(Request $request, $id)
    {
        $seminar = CoachSeminar::findOrFail($id);
        $seminar->update($request->all());
        return response()->json(['success' => true, 'seminar' => $seminar]);
    }

    // Delete a seminar
    public function destroy($id)
    {
        $seminar = CoachSeminar::findOrFail($id);
        $seminar->delete();
        return response()->json(['success' => true]);
    }
}
