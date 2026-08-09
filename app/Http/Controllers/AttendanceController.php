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

        // 1. SMART SPORT FILTER: Convert numeric ID back to the Sport Name
        $sportName = null;
        if (!empty($sportId)) {
            if (is_numeric($sportId)) {
                $sport = Sport::find($sportId);
                $sportName = $sport ? $sport->name : null;
            } else {
                $sportName = $sportId; // Fallback just in case it already sends text
            }
        }

        // 2. TARGET DATE: Use the requested date, or default to today
        $targetDate = $date ?: now()->toDateString();

        // Fetch all sports for the dropdown
        $sports = Sport::all();

        // 3. ONLY ACTIVE ATHLETES: Filter by sport, ignore Alumni/Inactive/Tryouts
        $athletes = \App\Models\Athlete::where('approval_status', 'approved')
            ->where('status', 'Active')
            ->where('classification', '!=', 'Tryout')
            ->when($sportName, function($q) use ($sportName) {
                $q->where('sport_event', $sportName);
            })->get();

        // 4. ENRICH DATA: Map every athlete to their attendance status for the target date
        $athletesWithStatus = $athletes->map(function ($athlete) use ($targetDate) {
            $attendance = $athlete->attendances()
                ->whereDate('date', $targetDate)
                ->first();

            return [
                'id' => $athlete->id,
                'first_name' => $athlete->first_name,
                'last_name' => $athlete->last_name,
                'sport_event' => $athlete->sport_event,
                'status' => $attendance?->status ?? 'Not Marked',
                'remarks' => $attendance?->remarks ?? '—',
                'attendance_date' => $attendance?->date ?? $targetDate,
                'isEditable' => false,
            ];
        });

        // 5. FETCH RAW LOGS
        $attendances = Attendance::when($sportName, function($query, $sportName){
            $query->whereHas('athlete', function($q) use ($sportName) {
                $q->where('sport_event', $sportName);
            });
        })
        ->when($month, function($query, $month){
            $query->whereMonth('date', $month);
        })
        ->when($date, function($query, $date){
            $query->whereDate('date', $date);
        })
        ->get();

        return view('features.attendance', compact(
            'attendances', 'sports', 'athletes', 'athletesWithStatus', 'targetDate'
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

            // ONLY ACTIVE ATHLETES
            $athletes = \App\Models\Athlete::where('status', 'Active')
                ->where('classification', '!=', 'Tryout')
                ->when($sportId, function($q) use ($sportId) {
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
            // Grab the coach's specific sport
            $coachSport = auth()->user()->coach->coach_sport_event ?? null;

            // ONLY ACTIVE ATHLETES for History
            $athletes = \App\Models\Athlete::where('sport_event', $coachSport)
                ->where('status', 'Active')
                ->where('classification', '!=', 'Tryout')
                ->get();

            // Strict Sport Filter for History Attendances
            $attendances = \App\Models\Attendance::whereHas('athlete', function($q) use ($coachSport){
                    $q->where('sport_event', $coachSport);
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