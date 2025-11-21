<?php

namespace App\Http\Controllers;

use App\Models\FeesDiscount;
use Illuminate\Http\Request;

class FeesDiscountController extends Controller
{
    // Save new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'athlete_id' => 'required|exists:athletes,id'
        ]);

        $record = FeesDiscount::create($request->all());

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
