<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentRequest;

class EquipmentRequestController extends Controller
{
    public function index()
    {
        // Fetch all requests, newest first
        $requests = EquipmentRequest::latest()->get();
        return view('features.equipment', compact('requests'));
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $request->validate([
            'event' => 'required|string|max:255',
            'date_requested' => 'required|date',
            'requested_by' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.qty' => 'required|numeric',
            'items.*.unit' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric',
        ]);

        // 2. Save it to the database
        EquipmentRequest::create([
            'event' => $request->event,
            'date_requested' => $request->date_requested,
            'requested_by' => $request->requested_by,
            'items' => $request->items, // The model's $casts will handle turning this array into JSON!
            'status' => 'Pending',
        ]);

        // 3. Redirect back with a success message
        return redirect()->back()->with('success', 'Equipment Request submitted successfully!');
    }
    
    public function approve($id)
    {
        $request = EquipmentRequest::findOrFail($id);
        $request->update(['status' => 'Approved']);
        return redirect()->back()->with('success', 'Equipment Request approved successfully!');
    }

    public function reject($id)
    {
        $request = EquipmentRequest::findOrFail($id);
        $request->update(['status' => 'Rejected']);
        return redirect()->back()->with('success', 'Equipment Request rejected.');
    }
}