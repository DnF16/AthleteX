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
}
