<?php

namespace App\Http\Controllers;

use App\Models\FeesDiscount;
use Illuminate\Http\Request;

class FeesDiscountController extends Controller
{
    // Save new record
    public function store(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'athlete_id' => 'required|exists:athletes,id',
            'academic_year' => 'required|string|max:50',
            'total_units' => 'nullable|integer',
            'tuition_fee' => 'nullable|numeric',
            'miscellaneous_fee' => 'nullable|numeric',
            'other_charges' => 'nullable|numeric',
            'total_assessment' => 'nullable|numeric',
            'total_discount' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Create record
        $record = FeesDiscount::create($validated);

        return response()->json([
            'message' => 'Fee / Discount added successfully.',
            'data' => $record
        ]);
    }

    // Load table rows for selected athlete
    public function show($athlete_id)
    {
        $records = FeesDiscount::where('athlete_id', $athlete_id)->get();

        return response()->json($records);
    }
}
