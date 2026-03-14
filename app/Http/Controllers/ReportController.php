<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    // Coach views their own reports
    public function coachIndex()
    {
        if (auth()->user()->role !== 'coach') {
            abort(403);
        }

        $coachId = auth()->user()->coach->id ?? null;
        $reports = Report::where('coach_id', $coachId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('features.reports.coach_reports', compact('reports'));
    }

    // Coach uploads a report
    public function coachStore(Request $request)
    {
        if (auth()->user()->role !== 'coach') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $coachId = auth()->user()->coach->id ?? null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('reports/' . $coachId, $fileName, 'public');

            Report::create([
                'coach_id' => $coachId,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'status' => 'pending',
            ]);

            return back()->with('success', 'Report submitted successfully!');
        }

        return back()->with('error', 'Failed to upload file.');
    }

    // Admin views all reports
    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $reports = Report::with('coach')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('features.reports.admin_reports', compact('reports'));
    }

    // Admin marks report as received
    public function markReceived(Report $report)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $report->update([
            'status' => 'received',
            'received_at' => now(),
        ]);

        return back()->with('success', 'Report marked as received.');
    }

    // Admin marks report as rejected
    public function markRejected(Report $report)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $report->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Report marked as rejected.');
    }

    // Download report
    public function download(Report $report)
    {
        // Coaches can only download their own reports
        // Admins can download any report
        if (auth()->user()->role === 'coach') {
            $coachId = auth()->user()->coach->id ?? null;
            if ($report->coach_id !== $coachId) {
                abort(403);
            }
        } elseif (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if (!Storage::disk('public')->exists($report->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($report->file_path, $report->file_name);
    }
}
