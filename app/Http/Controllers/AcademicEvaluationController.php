<?php

namespace App\Http\Controllers;

use App\Models\AcademicEvaluation;
use Illuminate\Http\Request;

class AcademicEvaluationController extends Controller
{
    // Save academic evaluation record
    public function store(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required|exists:athletes,id',
            'passed'     => 'nullable|integer',
            'enrolled'   => 'nullable|integer',
            'percentage' => 'nullable|string',
            'remark'     => 'nullable|string',
        ]);

        $record = AcademicEvaluation::create($request->all());

        return response()->json([
            'message' => 'Academic evaluation saved successfully.',
            'data' => $record
        ]);
    }

    // Get all academic evaluations for a selected athlete
    public function show($athlete_id)
    {
        $records = AcademicEvaluation::where('athlete_id', $athlete_id)->get();

        return response()->json($records);
    }
}
