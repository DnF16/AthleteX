<?php

namespace App\Http\Controllers;

use App\Models\CoachExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachExpenseController extends Controller
{
    // Fetch all expenses for a coach
    public function show($coach_id)
    {
        $expenses = CoachExpense::where('coach_id', $coach_id)->get();
        return response()->json($expenses);
    }

    // Store a new expense
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coach_id' => 'required|exists:coaches,id',
            'academic_year' => 'nullable|string|max:255',
            'term' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:100',
            'amount' => 'nullable|numeric',
            'event_athlete' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $expense = CoachExpense::create($request->all());
        return response()->json(['success' => true, 'expense' => $expense]);
    }

    // Update an expense
    public function update(Request $request, $id)
    {
        $expense = CoachExpense::findOrFail($id);
        $expense->update($request->all());
        return response()->json(['success' => true, 'expense' => $expense]);
    }

    // Delete an expense
    public function destroy($id)
    {
        $expense = CoachExpense::findOrFail($id);
        $expense->delete();
        return response()->json(['success' => true]);
    }
}
