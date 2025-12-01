<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    // Show admin dashboard with pending athletes for approval
    public function pendingApprovals()
    {
        $pendingAthletes = Athlete::where('approval_status', 'pending')
            ->with('coach')
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedAthletes = Athlete::where('approval_status', 'approved')
            ->with('coach', 'approver')
            ->orderBy('approved_at', 'desc')
            ->limit(10)
            ->get();

        $declinedAthletes = Athlete::where('approval_status', 'declined')
            ->with('coach', 'approver')
            ->orderBy('approved_at', 'desc')
            ->limit(10)
            ->get();

        return view('features.approvals', compact('pendingAthletes', 'approvedAthletes', 'declinedAthletes'));
    }

    // Approve an athlete submission
    public function approve(Request $request, Athlete $athlete)
    {
        $request->validate([
            'approval_notes' => 'nullable|string|max:500',
        ]);

        $athlete->update([
            'approval_status' => 'approved',
            'approval_notes' => $request->approval_notes,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Athlete {$athlete->first_name} {$athlete->last_name} has been approved.");
    }

    // Decline an athlete submission
    public function decline(Request $request, Athlete $athlete)
    {
        $request->validate([
            'approval_notes' => 'required|string|max:500',
        ]);

        $athlete->update([
            'approval_status' => 'declined',
            'approval_notes' => $request->approval_notes,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Athlete {$athlete->first_name} {$athlete->last_name} has been declined.");
    }

    // View single athlete for approval review
    public function show(Athlete $athlete)
    {
        $athlete->load('coach', 'achievements', 'academicEvaluations', 'feesDiscounts', 'workHistories');
        return view('features.athlete-approval-detail', compact('athlete'));
    }
}
