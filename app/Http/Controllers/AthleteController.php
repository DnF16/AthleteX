<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;

class AthleteController extends Controller
{
    public function index()
    {
        $athletes = Athlete::all();
        return view('athlete_lists.athlete_lists', compact('athletes'));
    }

    public function create()
    {
        return view('features.student_athlete');
    }

    public function store(Request $request)
    {
        // mass-assign all known fields from the form (no validation added here)
        $data = $request->only([
            'student_id', 'first_name', 'last_name', 'course', 'year_level', 'sport',
            'full_name', 'athlete_id', 'middle_initial', 'sport_event', 'status', 'classification',
            'gender', 'birthdate', 'age', 'blood_type', 'email', 'facebook', 'marital_status',
            'contact_number', 'address', 'city_municipality', 'province_state', 'zip_code',
            'emergency_person', 'emergency_contact', 'coach_name', 'date_joined', 'term_graduated',
            'asst_coach', 'total_unit', 'year_graduated', 'tuition_fee', 'misc_fee', 'other_charges',
            'total_assessment', 'total_discount', 'balance', 'current_work', 'current_company',
            'picture_path', 'notes', 'inactive_date'
        ]);

        Athlete::create($data);

        return redirect()->route('athletes.index')
                         ->with('success', 'Athlete added successfully!');
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
            'coach_name' => $a->coach_name,
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
            'picture_url' => $a->picture ? asset('storage/' . $a->picture) : null,
        ];
    });

    return response()->json($results);
}



    /**
     * Update an existing athlete.
     */
    public function update(Request $request, Athlete $athlete)
    {
        $data = $request->only([
            'student_id', 'first_name', 'last_name', 'course', 'year_level', 'sport',
            'full_name', 'athlete_id', 'middle_initial', 'sport_event', 'status', 'classification',
            'gender', 'birthdate', 'age', 'blood_type', 'email', 'facebook', 'marital_status',
            'contact_number', 'address', 'city_municipality', 'province_state', 'zip_code',
            'emergency_person', 'emergency_contact', 'coach_name', 'date_joined', 'term_graduated',
            'asst_coach', 'total_unit', 'year_graduated', 'tuition_fee', 'misc_fee', 'other_charges',
            'total_assessment', 'total_discount', 'balance', 'current_work', 'current_company',
            'picture_path', 'notes', 'inactive_date'
        ]);

        $athlete->update($data);

        return redirect()->route('athletes.index')
                         ->with('success', 'Athlete updated successfully!');
    }
}
