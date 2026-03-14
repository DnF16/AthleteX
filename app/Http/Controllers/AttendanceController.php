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

        // determine the coach table id rather than the user id
        $coachId = auth()->user()->coach->id ?? null;

        // Get the attendances for this coach
        $attendances = Attendance::whereHas('athlete', function ($query) use ($coachId) {
            $query->where('coach_id', $coachId);
        })->get();

        // Get the athletes assigned to this coach with their today's attendance status
        $athletes = \App\Models\Athlete::where('coach_id', $coachId)->get();

        // Enrich athletes with today's attendance status
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
                'status' => $todayAttendance?->status ?? 'unmarked',
                'remarks' => $todayAttendance?->remarks ?? '',
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
    $month = $request->query('month'); // Month filter (numeric: 01-12)
    $date = $request->query('date');   // Specific date filter (YYYY-MM-DD)

    // Fetch all sports for dropdown
    $sports = Sport::all();

    // Fetch attendances with optional filters
    $attendances = Attendance::when($sportId, function($query, $sportId){
        $query->whereHas('athlete', function($q) use ($sportId) {
            $q->where('sport_event', $sportId);
        });
    })
    ->when($month, function($query, $month){
        $query->whereMonth('date', $month);
    })
    ->when($date, function($query, $date){
        $query->whereDate('date', $date);
    })
    ->get();

    // Fetch athletes with optional sport filter
    $athletes = \App\Models\Athlete::when($sportId, function($q) use ($sportId) {
        $q->where('sport_event', $sportId);
    })->get();

    // Add today’s attendance status
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
            'status' => $todayAttendance?->status ?? 'unmarked',
            'attendance_date' => $todayAttendance?->date ?? $today,
        ];
    });

    return view('features.attendance', compact(
        'attendances', 'sports', 'athletes', 'athletesWithStatus'
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

        $athletes = \App\Models\Athlete::when($sportId, function($q) use ($sportId) {
            $q->where('sport_event', $sportId);
        })->get();

        $attendances = \App\Models\Attendance::whereBetween('date', [$start, $end])
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

        $coachId = auth()->user()->coach->id ?? null;

        $athletes = \App\Models\Athlete::where('coach_id', $coachId)->get();

        $attendances = \App\Models\Attendance::whereHas('athlete', function($q) use ($coachId){
                $q->where('coach_id', $coachId);
            })
            ->whereBetween('date', [$start, $end])
            ->get();
    }

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