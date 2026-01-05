<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Achievement;
use App\Models\AcademicEvaluation;
use App\Models\FeesDiscount;
use App\Models\WorkHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AthleteController extends Controller
{
    public function index()
    {
        // Admins see all athletes with all statuses
        // Coaches see only approved athletes
        if (auth()->user()->role === 'admin') {
            $athletes = Athlete::all();
        } else {
            // Non-admin users (coaches) only see approved athletes
            $athletes = Athlete::where('approval_status', 'approved')->get();
        }
        return view('features.athlete_lists', compact('athletes'));
    }

    public function create()
    {
        return view('features.student_athlete');
    }

    public function store(Request $request)
    {
        // If frontend sends an aggregated JSON payload, fields may be nested
        // under `generalInfo`. Normalize so validation and create use the
        // same flat structure.
        $payload = $request->all();
        $general = is_array($payload) && array_key_exists('generalInfo', $payload) && is_array($payload['generalInfo'])
            ? $payload['generalInfo']
            : $payload;

        // validate required fields before attempting create
        $rules = [
            'student_id' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ];

        $validator = Validator::make($general, $rules);

        if ($validator->fails()) {
            Log::warning('Athlete store validation failed', ['errors' => $validator->errors()->toArray(), 'payload' => $payload]);

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        // mass-assign all known fields from the (possibly nested) general info
        $data = [];
        $fields = [
            'student_id', 'first_name', 'last_name', 'course', 'year_level', 'sport',
            'full_name', 'athlete_id', 'middle_initial', 'sport_event', 'status', 'classification',
            'gender', 'birthdate', 'age', 'blood_type', 'email', 'facebook', 'marital_status',
            'contact_number', 'address', 'city_municipality', 'province_state', 'zip_code',
            'emergency_person', 'emergency_contact', 'coach_id', 'date_joined', 'term_graduated',
            'asst_coach', 'total_unit', 'year_graduated', 'tuition_fee', 'misc_fee', 'other_charges',
            'total_assessment', 'total_discount', 'balance', 'current_work', 'current_company',
            'picture_path', 'notes', 'inactive_date'
        ];

        foreach ($fields as $f) {
            if (array_key_exists($f, $general)) {
                $data[$f] = $general[$f];
            }
        }

        // Set approval_status to pending for all new athletes
        $data['approval_status'] = 'pending';

        // Assign the logged-in coach automatically if user has a coach role
        if (auth()->check() && auth()->user()->role === 'coach' && auth()->user()->coach) {
            $data['coach_id'] = auth()->user()->coach->id;
        }
        

        try {
            $athlete = DB::transaction(function () use ($data, $payload) {
                $a = Athlete::create($data);

                // achievements
                if (!empty($payload['achievements']) && is_array($payload['achievements'])) {
                    foreach ($payload['achievements'] as $ach) {
                        Achievement::create([
                            'athlete_id' => $a->id,
                            'year' => $ach['year'] ?? null,
                            'month_day' => $ach['monthDay'] ?? ($ach['month_day'] ?? null),
                            'event' => $ach['event'] ?? null,
                            'venue' => $ach['venue'] ?? null,
                            'award' => $ach['award'] ?? null,
                            'category' => $ach['category'] ?? null,
                            'remarks' => $ach['remarks'] ?? null,
                        ]);
                    }
                }

                // academic records
                if (!empty($payload['academicRecords']) && is_array($payload['academicRecords'])) {
                    foreach ($payload['academicRecords'] as $rec) {
                        AcademicEvaluation::create([
                            'athlete_id' => $a->id,
                            'passed' => $rec['passed'] ?? null,
                            'enrolled' => $rec['enrolled'] ?? null,
                            'percentage' => $rec['percentage'] ?? null,
                            'remark' => $rec['remark'] ?? null,
                        ]);
                    }
                }

                // fees / discounts
                if (!empty($payload['fees']) && is_array($payload['fees'])) {
                    foreach ($payload['fees'] as $f) {
                        FeesDiscount::create([
                            'athlete_id' => $a->id,
                            'academic_year' => $f['academic_year'] ?? null,
                            'total_units' => $f['total_units'] ?? null,
                            'tuition_fee' => $f['tuition_fee'] ?? null,
                            'miscellaneous_fee' => $f['miscellaneous_fee'] ?? ($f['misc_fee'] ?? null),
                            'other_charges' => $f['other_charges'] ?? null,
                            'total_assessment' => $f['total_assessment'] ?? null,
                            'total_discount' => $f['total_discount'] ?? null,
                            'remarks' => $f['remarks'] ?? null,
                        ]);
                    }
                }

                // work history
                if (!empty($payload['workHistory']) && is_array($payload['workHistory'])) {
                    foreach ($payload['workHistory'] as $w) {
                        WorkHistory::create([
                            'athlete_id' => $a->id,
                            'year' => $w['year'] ?? null,
                            'date' => $w['date'] ?? null,
                            'position' => $w['position'] ?? null,
                            'company' => $w['company'] ?? null,
                            'remarks' => $w['remarks'] ?? null,
                        ]);
                    }
                }

                return $a;
            });

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => true,
                    'athlete' => $athlete,
                ], 201);
            }

            return redirect()->route('athletes.index')
                         ->with('success', 'Athlete added successfully!');

        } catch (\Throwable $e) {
            Log::error('Athlete store error: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $payload,
            ]);

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create athlete',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return back()->withErrors('Failed to create athlete.');
        }
    }

    /**
     * AJAX live search for athletes by name or student id.
     * Returns JSON array of matches (limit 15).
     */
    public function search(Request $request)
{
    $term = trim($request->get('q', ''));

    $query = Athlete::query();

    if ($term !== '') {
        $query->where(function ($q) use ($term) {
            $q->where('first_name', 'like', "%{$term}%")
              ->orWhere('last_name', 'like', "%{$term}%")
              ->orWhere('full_name', 'like', "%{$term}%")
              ->orWhere('student_id', 'like', "%{$term}%");
        });
    }

    $results = $query->limit(15)->get()->map(function ($a) {
        return [
            'id' => $a->id,
            'student_id' => $a->student_id,
            'first_name' => $a->first_name,
            'last_name' => $a->last_name,
            'full_name' => $a->full_name,
            'age' => $a->age,
            'gender' => $a->gender,
            'birthdate' => $a->birthdate,
            'blood_type' => $a->blood_type,
            'course' => $a->course,
            'year_level' => $a->year_level,
            'email' => $a->email,
            'facebook' => $a->facebook,
            'marital_status' => $a->marital_status,
            'contact_number' => $a->contact_number,
            'address' => $a->address,
            'city_municipality' => $a->city_municipality,
            'province_state' => $a->province_state,
            'zip_code' => $a->zip_code,
            'emergency_person' => $a->emergency_person,
            'emergency_contact' => $a->emergency_contact,
            'coach_name' => $a->coach
            ? $a->coach->coach_first_name . ' ' . $a->coach->coach_last_name
            : null,

            'date_joined' => $a->date_joined,
            'term_graduated' => $a->term_graduated,
            'asst_coach' => $a->asst_coach,
            'total_unit' => $a->total_unit,
            'year_graduated' => $a->year_graduated,
            'tuition_fee' => $a->tuition_fee,
            'misc_fee' => $a->misc_fee,
            'other_charges' => $a->other_charges,
            'total_assessment' => $a->total_assessment,
            'total_discount' => $a->total_discount,
            'balance' => $a->balance,
            'current_work' => $a->current_work,
            'current_company' => $a->current_company,

            // right-side fields
            'sport_event' => $a->sport_event,
            'status' => $a->status,
            'classification' => $a->classification,
            'inactive_date' => $a->inactive_date,

            // picture
            'picture_url' => $a->picture_path ? asset('storage/' . $a->picture_path) : null,

        ];
    });

    return response()->json($results);
}


    /**
     * Return full athlete with related records (achievements, academics, fees, work history)
     */
    public function show(Request $request, Athlete $athlete)
    {
        // eager load relations
        $athlete->load(['achievements', 'academicEvaluations', 'feesDiscounts', 'workHistories']);

        // normalize picture url
        $athlete->picture_url = $athlete->picture_path ? asset('storage/' . $athlete->picture_path) : null;

        return response()->json($athlete);
    }



    /**
     * Update an existing athlete.
     */
    public function update(Request $request, Athlete $athlete)
    {
        // Accept aggregated JSON payload similar to store()
        $payload = $request->all();
        $general = is_array($payload) && array_key_exists('generalInfo', $payload) && is_array($payload['generalInfo'])
            ? $payload['generalInfo']
            : $payload;

        $fields = [
            'student_id', 'first_name', 'last_name', 'course', 'year_level', 'sport',
            'full_name', 'athlete_id', 'middle_initial', 'sport_event', 'status', 'classification',
            'gender', 'birthdate', 'age', 'blood_type', 'email', 'facebook', 'marital_status',
            'contact_number', 'address', 'city_municipality', 'province_state', 'zip_code',
            'emergency_person', 'emergency_contact', 'coach_id', 'date_joined', 'term_graduated',
            'asst_coach', 'total_unit', 'year_graduated', 'tuition_fee', 'misc_fee', 'other_charges',
            'total_assessment', 'total_discount', 'balance', 'current_work', 'current_company',
            'picture_path', 'notes', 'inactive_date'
        ];

        $data = [];
        foreach ($fields as $f) {
            if (array_key_exists($f, $general)) {
                $data[$f] = $general[$f];
            }
        }

        try {
            $updated = DB::transaction(function () use ($athlete, $data, $payload) {
                $athlete->update($data);

                // replace child records: delete existing, then recreate from payload arrays
                $athlete->achievements()->delete();
                $athlete->academicEvaluations()->delete();
                $athlete->feesDiscounts()->delete();
                $athlete->workHistories()->delete();

                if (!empty($payload['achievements']) && is_array($payload['achievements'])) {
                    foreach ($payload['achievements'] as $ach) {
                        Achievement::create([
                            'athlete_id' => $athlete->id,
                            'year' => $ach['year'] ?? null,
                            'month_day' => $ach['monthDay'] ?? ($ach['month_day'] ?? null),
                            'event' => $ach['event'] ?? null,
                            'venue' => $ach['venue'] ?? null,
                            'award' => $ach['award'] ?? null,
                            'category' => $ach['category'] ?? null,
                            'remarks' => $ach['remarks'] ?? null,
                        ]);
                    }
                }

                if (!empty($payload['academicRecords']) && is_array($payload['academicRecords'])) {
                    foreach ($payload['academicRecords'] as $rec) {
                        AcademicEvaluation::create([
                            'athlete_id' => $athlete->id,
                            'passed' => $rec['passed'] ?? null,
                            'enrolled' => $rec['enrolled'] ?? null,
                            'percentage' => $rec['percentage'] ?? null,
                            'remark' => $rec['remark'] ?? null,
                        ]);
                    }
                }

                if (!empty($payload['fees']) && is_array($payload['fees'])) {
                    foreach ($payload['fees'] as $f) {
                        FeesDiscount::create([
                            'athlete_id' => $athlete->id,
                            'academic_year' => $f['academic_year'] ?? null,
                            'total_units' => $f['total_units'] ?? null,
                            'tuition_fee' => $f['tuition_fee'] ?? null,
                            'miscellaneous_fee' => $f['miscellaneous_fee'] ?? ($f['misc_fee'] ?? null),
                            'other_charges' => $f['other_charges'] ?? null,
                            'total_assessment' => $f['total_assessment'] ?? null,
                            'total_discount' => $f['total_discount'] ?? null,
                            'remarks' => $f['remarks'] ?? null,
                        ]);
                    }
                }

                if (!empty($payload['workHistory']) && is_array($payload['workHistory'])) {
                    foreach ($payload['workHistory'] as $w) {
                        WorkHistory::create([
                            'athlete_id' => $athlete->id,
                            'year' => $w['year'] ?? null,
                            'date' => $w['date'] ?? null,
                            'position' => $w['position'] ?? null,
                            'company' => $w['company'] ?? null,
                            'remarks' => $w['remarks'] ?? null,
                        ]);
                    }
                }

                return true;
            });

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => true, 'athlete' => $athlete]);
            }

            return redirect()->route('athletes.index')
                             ->with('success', 'Athlete updated successfully!');

        } catch (\Throwable $e) {
            Log::error('Athlete update error: ' . $e->getMessage(), ['exception' => $e, 'id' => $athlete->id, 'payload' => $payload]);

            if ($request->expectsJson() || $request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to update athlete', 'error' => $e->getMessage()], 500);
            }

            return back()->withErrors('Failed to update athlete.');
        }
    }

    // =================================================================
    // PUBLIC REGISTRATION FUNCTIONS (The "Google Form" Logic)
    // =================================================================

    // 1. Show the blank form
    public function showPublicRegistrationForm()
    {
        return view('features.alumni_registration');
    }

    // 2. Save the data as "Pending"
    public function storePublicRegistration(Request $request)
    {
        // 1. DEFINE VALIDATION RULES
        $rules = [
            'classification' => 'required|in:Active,Alumni',
            'student_id' => 'required|string|unique:athletes,student_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sport_event' => 'required|string',
        ];

        // 2. ADD STRICT RULES FOR ACTIVE STUDENTS
        if ($request->classification === 'Active') {
            $rules['birthdate'] = 'required|date';
            $rules['sex'] = 'required|string';
            $rules['contact_number'] = 'required|string';
            $rules['address'] = 'required|string';
            $rules['emergency_person'] = 'required|string';
            $rules['emergency_contact'] = 'required|string';
        }

        $validated = $request->validate($rules);

        try {
            // 3. SAVE TO DATABASE
            \App\Models\Athlete::create([
                // Basic Info
                'student_id' => $validated['student_id'],
                'first_name' => $validated['first_name'],
                'middle_name' => $request->input('middle_name'),
                'last_name' => $validated['last_name'],
                'suffix' => $request->input('suffix'),
                'email' => $validated['email'],
                'sport' => $validated['sport_event'],
                
                // System Status
                'status' => $validated['classification'],
                'approval_status' => 'pending', 

                // Personal Details
                'birthdate' => $request->input('birthdate'),
                'age' => $request->input('age'),
                'sex' => $request->input('sex'),
                'civil_status' => $request->input('civil_status'),
                'place_of_birth' => $request->input('place_of_birth'),
                'nationality' => $request->input('nationality'),
                
                // Physical
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'blood_type' => $request->input('blood_type'),

                // Contact
                'contact_number' => $request->input('contact_number'),
                'facebook' => $request->input('facebook_link'), // Ensure DB column is 'facebook' or 'facebook_link'
                'address' => $request->input('address'),
                'city_municipality' => $request->input('city_municipality'),
                'province' => $request->input('province'),
                'zip_code' => $request->input('zip_code'),

                // Academic
                'college' => $request->input('college'),
                'course' => $request->input('course'),
                'year_level' => $request->input('year_level'),

                // Emergency
                'emergency_person' => $request->input('emergency_person'),
                'emergency_contact' => $request->input('emergency_contact'),
                'emergency_relationship' => $request->input('emergency_relationship'),
            ]);

            return back()->with('success', 'Registration submitted successfully! Please wait for SDO verification.');

        } catch (\Exception $e) {
            // This will help you find missing columns if the database crashes
            return back()->with('error', 'Database Error: ' . $e->getMessage())->withInput();
        }
    }
}
