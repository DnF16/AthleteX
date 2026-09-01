<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Sport;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function coachIndex()
    {
        if (auth()->user()->role !== 'coach') {
            abort(403);
        }

        // 1. Get the coach profile and their specific sport
        $coach = auth()->user()->coach;
        $coachSport = $coach->coach_sport_event ?? null;

        // Fallback: If the testing account has no linked profile, show an empty dashboard safely
        if (!$coach || !$coachSport) {
            $attendances = collect();
            $athletes = collect();
            $athletesWithStatus = collect();
            $today = now()->toDateString();
            return view('features.attendance', compact('attendances', 'athletes', 'athletesWithStatus', 'today'));
        }

        // 2. Strict Sport Filter: Get attendances ONLY for this coach's sport
        $attendances = Attendance::whereHas('athlete', function ($query) use ($coachSport) {
            $query->where('sport_event', $coachSport);
        })->get();

        // 3. ONLY ACTIVE ATHLETES: Ignore Alumni, Inactive, and Tryouts
        $athletes = \App\Models\Athlete::where('sport_event', $coachSport)
            ->where('status', 'Active')
            ->where('classification', '!=', 'Tryout')
            ->get();

        // 4. Enrich athletes with today's attendance status
        $today = now()->toDateString();
        $athletesWithStatus = $athletes->map(function ($athlete) use ($today) {
            $todayAttendance = $athlete->attendances()
                ->whereDate('date', $today)
                ->first();
            return [
                'id' => $athlete->id,
                'first_name' => $athlete->first_name,
                'last_name' => $athlete->last_name,
                'sport_event' => $athlete->sport_event,
                'status' => $todayAttendance?->status ?? 'Not Marked',
                'remarks' => $todayAttendance?->remarks ?? '—',
                'attendance_date' => $todayAttendance?->date ?? $today,
                'isEditable' => true, // Today's records are always editable
            ];
        });

        // Pass both attendances and athletes to the view
        return view('features.attendance', compact('attendances', 'athletes', 'athletesWithStatus', 'today'));
    }

    public function adminIndex(Request $request)
    {
        $sportId = $request->query('sport');
        $month = $request->query('month'); 
        $date = $request->query('date');   

        // 1. SMART SPORT FILTER
        $sportName = null;
        if (!empty($sportId)) {
            if (is_numeric($sportId)) {
                $sport = Sport::find($sportId);
                $sportName = $sport ? $sport->name : null;
            } else {
                $sportName = $sportId; 
            }
        }

        $today = now()->toDateString();
        $targetDate = $date ?: $today;
        $sports = Sport::all();

        // 2. CHECK WHAT WE ARE VIEWING
        // If no date is picked (or it's exactly today) AND no month is picked, we are viewing "Today"
        $isTodayView = (empty($date) || $date === $today) && empty($month);

        if ($isTodayView) {
            // ==========================================
            // TODAY'S VIEW: Show full roster to see who is "Not Marked"
            // ==========================================
            $athletes = \App\Models\Athlete::where('approval_status', 'approved')
                ->where('status', 'Active')
                ->where('classification', '!=', 'Tryout')
                ->when($sportName, function($q) use ($sportName) {
                    $q->where('sport_event', $sportName);
                })->get();

            $athletesWithStatus = $athletes->map(function ($athlete) use ($today) {
                $attendance = $athlete->attendances()
                    ->whereDate('date', $today)
                    ->first();

                return [
                    'id' => $athlete->id,
                    'first_name' => $athlete->first_name,
                    'last_name' => $athlete->last_name,
                    'sport_event' => $athlete->sport_event,
                    'status' => $attendance?->status ?? 'Not Marked',
                    'remarks' => $attendance?->remarks ?? '—',
                    'attendance_date' => $attendance?->date ?? $today,
                ];
            });
        } else {
            // ==========================================
            // PAST/FUTURE or MONTH VIEW: ONLY show actual recorded data
            // ==========================================
            $query = \App\Models\Attendance::with('athlete');

            if ($sportName) {
                $query->whereHas('athlete', function($q) use ($sportName) {
                    $q->where('sport_event', $sportName);
                });
            }

            if (!empty($month)) {
                $query->whereMonth('date', $month);
            }

            if (!empty($date)) {
                $query->whereDate('date', $date);
            }

            $attendances = $query->orderBy('date', 'desc')->get();

            // Format data exactly how the blade file expects it
            $athletesWithStatus = $attendances->filter(function($att) {
                // Safety check in case an athlete was hard-deleted from DB
                return $att->athlete != null;
            })->map(function ($att) {
                return [
                    'id' => $att->athlete->id,
                    'first_name' => $att->athlete->first_name,
                    'last_name' => $att->athlete->last_name,
                    'sport_event' => $att->athlete->sport_event,
                    'status' => $att->status,
                    'remarks' => $att->remarks ?? '—',
                    'attendance_date' => $att->date,
                ];
            })->values();
        }

        return view('features.attendance', compact(
            'sports', 'athletesWithStatus', 'targetDate', 'today'
        ));
    }

    public function store(Request $request)
    {
        $attendanceDate = $request->input('attendance_date');
        $today = now()->toDateString();

        // Only allow attendance recording for today
        if ($attendanceDate !== $today) {
            return back()->withErrors(['attendance_date' => 'Attendance can only be recorded for today.']);
        }

        $attendanceData = $request->input('attendance', []);
        $coachId = null;

        // Get coach ID if user is a coach
        if (auth()->user()->role === 'coach' && auth()->user()->coach) {
            $coachId = auth()->user()->coach->id;
        }

        foreach ($attendanceData as $athleteId => $data) {
            Attendance::updateOrCreate(
                [
                    'athlete_id' => $athleteId,
                    'date' => $attendanceDate,
                ],
                [
                    'status' => $data['status'] ?? 'present',
                    'remarks' => $data['remarks'] ?? null,
                    'coach_id' => $coachId,
                ]
            );
        }

        return back()->with('success', 'Attendance saved successfully.');
    }

    public function history(Request $request)
    {
        $backRoute = auth()->user()->role === 'admin' 
            ? route('admin.attendance') 
            : route('coach.attendance.index');

        // Month & Year selection
        $selectedMonth = $request->query('month') ?? date('F');
        $selectedYear  = $request->query('year') ?? date('Y');

        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Convert month name to month number
        $monthNumber = date('m', strtotime($selectedMonth));

        $start = \Carbon\Carbon::create($selectedYear, $monthNumber, 1)->startOfMonth();
        $end   = \Carbon\Carbon::create($selectedYear, $monthNumber, 1)->endOfMonth();

        $daysInMonth = $start->daysInMonth;

        // Initialize variables
        $sports = collect();
        $sportId = null;

        // ================= ADMIN =================
        if(auth()->user()->role === 'admin') {
            $sportId = $request->query('sport_id'); // get selected sport from request

            // Get ALL attendance records for this month
            $attendances = \App\Models\Attendance::with('athlete') // Load athlete data!
                ->whereBetween('date', [$start, $end])
                ->when($sportId, function($q) use ($sportId) {
                    $q->whereHas('athlete', function($q2) use ($sportId) {
                        $q2->where('sport_event', $sportId);
                    });
                })
                ->get();

            $sports = \App\Models\Sport::all(); // pass sports for dropdown
        }
        // ================= COACH =================
        else {
            // Grab the coach's specific sport
            $coachSport = auth()->user()->coach->coach_sport_event ?? null;

            // Strict Sport Filter for History Attendances
            $attendances = \App\Models\Attendance::with('athlete') // Load athlete data!
                ->whereHas('athlete', function($q) use ($coachSport){
                    $q->where('sport_event', $coachSport);
                })
                ->whereBetween('date', [$start, $end])
                ->get();
        }

        // ================= THE MAGIC FIX =================
        // Instead of pulling the active roster, we extract the unique athletes 
        // directly from the attendance records we just found!
        $athletes = $attendances->pluck('athlete')
            ->filter() // Remove any nulls (if an athlete was hard-deleted)
            ->unique('id') // Make sure each athlete only appears once
            ->values(); // Reset array keys

        // Build attendance map (VERY IMPORTANT)
        $attendanceMap = [];

        foreach($attendances as $attendance){
            $key = $attendance->athlete_id . '_' . \Carbon\Carbon::parse($attendance->date)->format('Y-m-d');
            $attendanceMap[$key] = $attendance;
        }

        return view('features.attendance_history', compact(
            'athletes',
            'attendanceMap',
            'daysInMonth',
            'selectedMonth',
            'selectedYear',
            'months',
            'backRoute',
            'sports',
            'sportId'
        ));
    }
}