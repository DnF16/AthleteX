<?php

namespace App\Http\Controllers;

use App\Models\CoachMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachMembershipController extends Controller
{
    // Fetch all memberships for a coach
    public function show($coach_id)
    {
        $memberships = CoachMembership::where('coach_id', $coach_id)->get();
        return response()->json($memberships);
    }

    // Store a new membership
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coach_id' => 'required|exists:coaches,id',
            'academic_term_year' => 'nullable|string|max:255',
            'total_units_enrolled' => 'nullable|numeric',
            'tuition_fee' => 'nullable|numeric',
            'misc_fee' => 'nullable|numeric',
            'other_charges' => 'nullable|numeric',
            'total_assessment' => 'nullable|numeric',
            'total_discount' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $membership = CoachMembership::create($request->all());
        return response()->json(['success' => true, 'membership' => $membership]);
    }

    // Update an existing membership
    public function update(Request $request, $id)
    {
        $membership = CoachMembership::findOrFail($id);
        $membership->update($request->all());
        return response()->json(['success' => true, 'membership' => $membership]);
    }

    // Delete a membership
    public function destroy($id)
    {
        $membership = CoachMembership::findOrFail($id);
        $membership->delete();
        return response()->json(['success' => true]);
    }
}
