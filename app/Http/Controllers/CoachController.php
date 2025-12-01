<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\CoachAchievement;
use App\Models\CoachWorkHistory;
use App\Models\CoachMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CoachController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // If user is a coach, show only their own profile
        if (auth()->check() && auth()->user()->role === 'coach') {
            $user = auth()->user();

            // If coach_id specified in the request (after redirect), prefer that
            $requestedCoachId = $request->query('coach_id');
            if ($requestedCoachId) {
                $coach = Coach::with('achievements', 'workHistories', 'memberships')->find($requestedCoachId);
            } else {
                // Prefer explicit coach_id (in case session user relation is stale).
                if ($user->coach_id) {
                    $coach = Coach::with('achievements', 'workHistories', 'memberships')
                        ->find($user->coach_id);
                } else {
                    // fallback to relation
                    $coach = $user->coach ? $user->coach->load('achievements', 'workHistories', 'memberships') : null;
                }
            }

            // If no coach record, show the creation form
            if (!$coach) {
                return view('features.coach', compact('coach'));
            }

            return view('features.coach', compact('coach'));
        }
        
        // Admins see all coaches
        $coaches = Coach::all();
        return view('c_lists.coach_lists', compact('coaches'));
    }

    public function create()
    {
        // If coach user, redirect to index (their profile page)
        if (auth()->check() && auth()->user()->role === 'coach') {
            return redirect()->route('coaches.index');
        }
        return view('features.coach');
    }

    public function store(Request $request)
    {
        // Normalize payload (in case frontend sends nested structure)
        $payload = $request->all();
        $general = is_array($payload) && array_key_exists('generalInfo', $payload) && is_array($payload['generalInfo'])
            ? $payload['generalInfo']
            : $payload;

        // Validate required fields
        $rules = [
            'coach_first_name' => 'required|string|max:255',
            'coach_last_name' => 'required|string|max:255',
        ];

        $validator = Validator::make($general, $rules);

        if ($validator->fails()) {
            Log::warning('Coach store validation failed', ['errors' => $validator->errors()->toArray()]);

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        // If coach user is updating their own profile
        $isCoachUser = auth()->check() && auth()->user()->role === 'coach';
        $coach = $isCoachUser ? auth()->user()->coach : null;

        // Mass assign coach data from general info
        $fields = [
            'coach_last_name', 'coach_first_name', 'coach_middle_initial',
            'coach_gender', 'coach_birthdate', 'coach_age', 'coach_blood_type',
            'coach_place_of_birth', 'coach_marital_status',
            'coach_email', 'coach_facebook', 'coach_tba', 'coach_contact_number',
            'coach_address', 'coach_city_municipality', 'coach_province_state', 'coach_zip_code',
            'coach_emergency_person', 'coach_emergency_contact', 'post_graduate',
            'course_graduated', 'coach_year_graduated', 'name_collage',
            'coach_course_graduated', 'coach_graduated', 'coach_highschool',
            'strand_graduated', 'highschool_graduated', 'date_hired',
            'honorarium_payment', 'date_resigned', 'occupation', 'coach_current_company',
            'coach_sport_event', 'position', 'coach_status', 'coach_inactive_date', 'coach_notes'
        ];

        $data = [];
        foreach ($fields as $f) {
            if (array_key_exists($f, $general)) {
                $data[$f] = $general[$f];
            }
        }

        try {
            // If coach user updating their own profile, update instead of create
            if ($isCoachUser && $coach) {
                $coach->update($data);
                
                if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                    return response()->json(['success' => true, 'coach' => $coach], 200);
                }
                return redirect()->route('coaches.index')->with('success', 'Your profile has been updated successfully!');
            }

            // Otherwise, create new coach (for admins or first-time coach setup)
            $coachData = DB::transaction(function () use ($data, $payload) {
                $c = Coach::create($data);

                // ACHIEVEMENTS
                if (!empty($payload['achievements']) && is_array($payload['achievements'])) {
                    foreach ($payload['achievements'] as $ach) {
                        CoachAchievement::create([
                            'coach_id' => $c->id,
                            'year' => $ach['year'] ?? null,
                            'month_day' => $ach['month_day'] ?? null,
                            'sports_event' => $ach['sports_event'] ?? null,
                            'venue' => $ach['venue'] ?? null,
                            'award' => $ach['award'] ?? null,
                            'category' => $ach['category'] ?? null,
                            'remarks' => $ach['remarks'] ?? null,
                        ]);
                    }
                }

                // SCHEDULES
                if (!empty($payload['schedules']) && is_array($payload['schedules'])) {
                    foreach ($payload['schedules'] as $sch) {
                        $c->schedule()->create([
                            'event' => $sch['Event'] ?? null,          
                            'date' => $sch['Date'] ?? null,
                            'athlete_list' => $sch['List'] ?? null,    
                            'remarks' => $sch['coachRemark'] ?? null,   
                        ]);
                    }
                }

                // EXPENSES
                if (!empty($payload['expenses']) && is_array($payload['expenses'])) {
                    foreach ($payload['expenses'] as $exp) {
                        $c->expenses()->create([
                            'academic_year' => $exp['Academic'] ?? null,          
                            'term' => $exp['Term'] ?? null,
                            'type' => $exp['Type'] ?? null,
                            'amount' => $exp['Amount'] ?? null,
                            'notes' => $exp['notes'] ?? null,
                            'event_athlete' => $exp['EventAthlete'] ?? null,     
                            'remarks' => $exp['coachRemark'] ?? null,             
                        ]);
                    }
                }

                // MEMBERSHIPS
                if (!empty($payload['memberships']) && is_array($payload['memberships'])) {
                    foreach ($payload['memberships'] as $mem) {
                        $c->memberships()->create([
                            'academic_term_year' => $mem['AcademicTerm'] ?? null,     
                            'total_units_enrolled' => $mem['UnitsEnrolled'] ?? null,
                            'tuition_fee' => $mem['CoachTuition'] ?? null,          
                            'misc_fee' => $mem['CoachMiscellaneous'] ?? null,         
                            'other_charges' => $mem['CoachOtherCharges'] ?? null,    
                            'total_assessment' => $mem['CoachAssessment'] ?? null,
                            'total_discount' => $mem['CoachTotalDiscount'] ?? null,
                            'remarks' => $mem['coachRemark'] ?? null,                 
                        ]);
                    }
                }

                // SEMINARS
                if (!empty($payload['seminars']) && is_array($payload['seminars'])) {
                    foreach ($payload['seminars'] as $sem) {
                        $c->seminars()->create([
                            'Year' => $sem['Year'] ?? null,
                            'date' => $sem['date'] ?? null,
                            'work_position' => $sem['WorkPosition'] ?? null,  
                            'company_name' => $sem['NameCompany'] ?? null,     
                            'remarks' => $sem['coachRemark'] ?? null,         
                        ]);
                    }
                }

                // WORK HISTORY
                if (!empty($payload['workHistory']) && is_array($payload['workHistory'])) {
                    foreach ($payload['workHistory'] as $w) {
                        CoachWorkHistory::create([
                            'coach_id' => $c->id,
                            'year' => $w['year'] ?? null,
                            'date' => $w['date'] ?? null,
                            'work_position' => $w['work_position'] ?? null,    
                            'company_name' => $w['company_name'] ?? null,     
                            'remarks' => $w['coachRemark'] ?? null,       
                        ]);
                    }
                }

                return $c;
            });

            // Handle picture upload if present
            if ($request->hasFile('coach_picture')) {
                $coachData->update(['coach_picture' => $path]);
            }

            // If the creator is the coach user themselves, link the created coach record
            if (auth()->check()) {
                $user = auth()->user();
                $user->coach_id = $coachData->id;
                // if coach_sport_event was set on the coach, copy it to user.coach_sport
                if (!empty($coachData->coach_sport_event)) {
                    $user->coach_sport = $coachData->coach_sport_event;
                }
                // Ensure the user's role is set to 'coach' so index() loads their profile
                if ($user->role !== 'coach') {
                    $user->role = 'coach';
                }
                $user->save();
            }

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Coach created successfully',
                    'coach' => $coachData
                ], 201);
            }

            return redirect()->route('coaches.show', $coachData->id)->with('success', 'Coach created successfully');
        } catch (\Exception $e) {
            Log::error('Coach creation failed', ['exception' => $e->getMessage()]);

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to create coach'], 500);
            }

            return back()->with('error', 'Failed to create coach');
        }
    }

    // public function show(Request $request, Coach $coach)
    // {
    //     $coach->load(['achievements', 'workHistories', 'memberships', 'schedule', 'expenses', 'seminars']);

    //     $coach->picture_url = $coach->coach_picture ? asset('storage/' . $coach->coach_picture) : null;

    //     return response()->json([
    //         'id' => $coach->id,
    //         'coach_first_name' => $coach->coach_first_name,
    //         'coach_last_name' => $coach->coach_last_name,
    //         'coach_middle_initial' => $coach->coach_middle_initial,
    //         'coach_gender' => $coach->coach_gender,
    //         'coach_birthdate' => $coach->coach_birthdate,
    //         'coach_email' => $coach->coach_email,
    //         'coach_contact_number' => $coach->coach_contact_number,
    //         'coach_sport_event' => $coach->coach_sport_event,
    //         'coach_picture' => $coach->coach_picture,
    //         'achievements' => $coach->achievements->toArray(),
    //         'workHistories' => $coach->workHistories->toArray(),
    //         'memberships' => $coach->memberships->toArray(),
    //         'schedule' => $coach->schedule->toArray(),
    //         'expenses' => $coach->expenses->toArray(),
    //         'seminars' => $coach->seminars->toArray(),
    //     ]);
    // }


    public function update(Request $request, Coach $coach)
    {
        // Normalize payload
        $payload = $request->all();
        $general = is_array($payload) && array_key_exists('generalInfo', $payload) && is_array($payload['generalInfo'])
            ? $payload['generalInfo']
            : $payload;

        // Validate required fields
        $rules = [
            'coach_first_name' => 'required|string|max:255',
            'coach_last_name' => 'required|string|max:255',
        ];

        $validator = Validator::make($general, $rules);

        if ($validator->fails()) {
            Log::warning('Coach update validation failed', ['errors' => $validator->errors()->toArray()]);

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        // Update coach fields
        $fields = [
            'coach_last_name', 'coach_first_name', 'coach_middle_initial',
            'coach_gender', 'coach_birthdate', 'coach_age', 'coach_blood_type',
            'coach_place_of_birth', 'coach_marital_status',
            'coach_email', 'coach_facebook', 'coach_tba', 'coach_contact_number',
            'coach_address', 'coach_city_municipality', 'coach_province_state', 'coach_zip_code',
            'coach_emergency_person', 'coach_emergency_contact', 'post_graduate',
            'course_graduated', 'coach_year_graduated', 'name_collage',
            'coach_course_graduated', 'coach_graduated', 'coach_highschool',
            'strand_graduated', 'highschool_graduated', 'date_hired',
            'honorarium_payment', 'date_resigned', 'occupation', 'coach_current_company',
            'coach_sport_event', 'position', 'coach_status', 'coach_inactive_date', 'coach_notes'
        ];

        $data = [];
        foreach ($fields as $f) {
            if (array_key_exists($f, $general)) {
                $data[$f] = $general[$f];
            }
        }

        try {
            DB::transaction(function () use ($coach, $data, $payload) {
                $coach->update($data);

                // DELETE AND REPLACE ALL MODULES
                $coach->achievements()->delete();
                $coach->schedule()->delete();
                $coach->expenses()->delete();
                $coach->memberships()->delete();
                $coach->seminars()->delete();
                $coach->workHistories()->delete();

                // ACHIEVEMENTS
                if (!empty($payload['achievements']) && is_array($payload['achievements'])) {
                    foreach ($payload['achievements'] as $ach) {
                        CoachAchievement::create([
                            'coach_id' => $coach->id,
                            'year' => $ach['year'] ?? null,
                            'month_day' => $ach['month_day'] ?? null,
                            'sports_event' => $ach['sports_event'] ?? null,
                            'venue' => $ach['venue'] ?? null,
                            'award' => $ach['award'] ?? null,
                            'category' => $ach['category'] ?? null,
                            'remarks' => $ach['remarks'] ?? null,
                        ]);
                    }
                }

                // SCHEDULES
                if (!empty($payload['schedules']) && is_array($payload['schedules'])) {
                    foreach ($payload['schedules'] as $sch) {
                        $c->schedule()->create([
                            'event' => $sch['Event'] ?? null,          
                            'date' => $sch['Date'] ?? null,
                            'athlete_list' => $sch['List'] ?? null,    
                            'remarks' => $sch['coachRemark'] ?? null,   
                        ]);
                    }
                }

                // EXPENSES
                if (!empty($payload['expenses']) && is_array($payload['expenses'])) {
                    foreach ($payload['expenses'] as $exp) {
                        $c->expenses()->create([
                            'academic_year' => $exp['Academic'] ?? null,          
                            'term' => $exp['Term'] ?? null,
                            'type' => $exp['Type'] ?? null,
                            'amount' => $exp['Amount'] ?? null,
                            'notes' => $exp['notes'] ?? null,
                            'event_athlete' => $exp['EventAthlete'] ?? null,     
                            'remarks' => $exp['coachRemark'] ?? null,             
                        ]);
                    }
                }

                // MEMBERSHIPS
                if (!empty($payload['memberships']) && is_array($payload['memberships'])) {
                    foreach ($payload['memberships'] as $mem) {
                        $c->memberships()->create([
                            'academic_term_year' => $mem['AcademicTerm'] ?? null,     
                            'total_units_enrolled' => $mem['UnitsEnrolled'] ?? null,
                            'tuition_fee' => $mem['CoachTuition'] ?? null,          
                            'misc_fee' => $mem['CoachMiscellaneous'] ?? null,         
                            'other_charges' => $mem['CoachOtherCharges'] ?? null,    
                            'total_assessment' => $mem['CoachAssessment'] ?? null,
                            'total_discount' => $mem['CoachTotalDiscount'] ?? null,
                            'remarks' => $mem['coachRemark'] ?? null,                 
                        ]);
                    }
                }

                // SEMINARS
                if (!empty($payload['seminars']) && is_array($payload['seminars'])) {
                    foreach ($payload['seminars'] as $sem) {
                        $c->seminars()->create([
                            'Year' => $sem['Year'] ?? null,
                            'date' => $sem['date'] ?? null,
                            'work_position' => $sem['WorkPosition'] ?? null,  
                            'company_name' => $sem['NameCompany'] ?? null,     
                            'remarks' => $sem['coachRemark'] ?? null,         
                        ]);
                    }
                }

                // WORK HISTORY
                if (!empty($payload['workHistory']) && is_array($payload['workHistory'])) {
                    foreach ($payload['workHistory'] as $w) {
                        CoachWorkHistory::create([
                            'coach_id' => $c->id,
                            'year' => $w['year'] ?? null,
                            'date' => $w['date'] ?? null,
                            'work_position' => $w['work_position'] ?? null,    
                            'company_name' => $w['company_name'] ?? null,     
                            'remarks' => $w['coachRemark'] ?? null,       
                        ]);
                    }
                }
            });

            // Handle picture upload if present
            if ($request->hasFile('coach_picture')) {
                $path = $request->file('coach_picture')->store('coaches', 'public');
                $coach->update(['coach_picture' => $path]);
            }

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Coach updated successfully',
                    'coach' => $coach
                ]);
            }

            return redirect()->route('coaches.show', $coach->id)->with('success', 'Coach updated successfully');
        } catch (\Exception $e) {
            Log::error('Coach update failed', ['exception' => $e->getMessage()]);

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to update coach'], 500);
            }

            return back()->with('error', 'Failed to update coach');
        }
    }

    /**
     * Search coaches (AJAX endpoint).
     */
    public function search(Request $request)
{
    $query = $request->input('q', '');

    if (strlen($query) < 2) {
        return response()->json([]);
    }

    return Coach::where('coach_first_name', 'like', "%{$query}%")
        ->orWhere('coach_last_name', 'like', "%{$query}%")
        ->orWhereRaw("CONCAT(coach_first_name, ' ', coach_last_name) LIKE ?", ["%{$query}%"])
        ->limit(10)
        ->get(['id', 'coach_first_name', 'coach_last_name', 'coach_sport_event']);
}

public function show(Request $request, Coach $coach)
{
    // Load relationships - use exact method names from Coach model
    $coach->load([
        'achievements', 
        'schedule',       // This will be 'schedule' in JSON
        'expenses', 
        'memberships', 
        'seminars', 
        'workHistories'   // This will be 'workHistories' in JSON (plural)
    ]);

    $coach->picture_url = $coach->coach_picture ? asset('storage/' . $coach->coach_picture) : null;

    // Return the model - Laravel auto-includes all loaded relationships
    return response()->json($coach);
}

// Get available sports (exclude already assigned sports)
public function getAvailableSports()
{
    // All available sports
    $allSports = [
        'Basketball',
        'Volleyball',
        'Athletics',
        'Swimming',
        'Taekwondo',
        'Chess',
        'Football',
        'Boxing',
    ];

    // Get sports already assigned to coaches
    $assignedSports = Coach::whereNotNull('coach_sport_event')
        ->pluck('coach_sport_event')
        ->unique()
        ->toArray();

    // Filter out assigned sports
    $availableSports = array_diff($allSports, $assignedSports);

    return response()->json([
        'available' => array_values($availableSports),
        'assigned' => $assignedSports,
    ]);
}
}
