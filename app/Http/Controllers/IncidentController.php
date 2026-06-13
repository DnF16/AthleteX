<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IncidentController extends Controller
{
    // 1. Coach submits the injury report
    public function createReport(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'athlete_id' => 'required|numeric',
            'coach_id' => 'required|numeric',
            'incident_title' => 'required|string',
            'incident_type' => 'required|string',
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'persons_involved' => 'required|string',
            'exact_location' => 'required|string',
            'incident_details' => 'required|string',
            'immediate_actions' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/coach/reports')->withErrors($validator)->withInput();
        }

        try {
            \Illuminate\Support\Facades\DB::table('incident_reports')->insert([
                'athlete_id' => $request->athlete_id,
                'coach_id' => $request->coach_id,
                'incident_title' => $request->incident_title,
                'incident_type' => $request->incident_type,
                'incident_type_specify' => $request->incident_type_specify, // Optional description for 'Others' or 'Accident'
                'incident_date' => $request->incident_date,
                'incident_time' => $request->incident_time,
                'persons_involved' => $request->persons_involved,
                'exact_location' => $request->exact_location,
                'incident_details' => $request->incident_details,
                'immediate_actions' => $request->immediate_actions,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect('/coach/reports')->with('success', 'Medical Incident reported to SDO successfully!');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Database Insert Failed: ' . $e->getMessage());
            return redirect('/coach/reports')->with('error', 'Database error: ' . $e->getMessage());
        }
    }
    
    // 2. SDO Admin approves and issues the ticket
    public function approveTicket($report_id)
    {
        try {
            // Generate a formal ticket number (e.g., UC-INC-2026-0001)
            $ticketNo = 'UC-INC-' . date('Y') . '-' . str_pad($report_id, 4, '0', STR_PAD_LEFT);

            // Update the specific report in the database
            \Illuminate\Support\Facades\DB::table('incident_reports')
                ->where('id', $report_id)
                ->update([
                    'status' => 'SDO_Approved',
                    'insurance_ticket_no' => $ticketNo,
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', "Success! Insurance Ticket {$ticketNo} has been generated and sent to the Coach.");
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Ticket Approval Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve ticket.');
        }
    }
}