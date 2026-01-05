<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// All necessary models for the Admin module must be imported here:
use App\Models\Setting;
use App\Models\Course;
use App\Models\User;
use App\Models\TransactionItem;
use App\Models\Holiday; // Added for scheduling
use App\Models\Certificate; // Added for certificates
use App\Models\GradeScale; 
use App\Models\ScholarshipCriteria;

class AdminController extends Controller
{
    // --- VIEW LOADERS (Fetch data for the specific tab) ---
    public function general() { 
        return view('admin.general'); 
    }
    
    public function settings() { 
        return view('admin.settings'); 
    }
    
    public function users() { 
        $users = User::all(); 
        return view('admin.users', compact('users')); 
    }
    
    public function classes() { 
        $courses = Course::all(); 
        return view('admin.classes', compact('courses')); 
    }
    
    public function scheduling() { 
        // Loads data for the Holidays table
        $holidays = Holiday::all(); 
        return view('admin.scheduling', compact('holidays')); 
    }
    
    public function certificates() { 
        // Loads data for the Certificates table
        $certs = Certificate::all(); 
        return view('admin.certificates', compact('certs'));
    }
    
    public function grades() { 
        return view('admin.grades'); 
    }
    
    public function transactions() { 
        $items = TransactionItem::all(); 
        return view('admin.transactions', compact('items')); 
    }

    // --- ACTIONS (Save Logic) ---
    public function saveSettings(Request $request) 
    {
        $data = $request->except(['_token', 'logo']);
        
        if ($request->hasFile('logo')) {
             $path = $request->file('logo')->store('uploads', 'public');
             Setting::set('logo', $path);
        }
        
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Settings Saved!');
    }

    public function updateUserPermissions(Request $request) {
    // 1. Get the array of permissions from the form
    $permissionsData = $request->input('permissions'); 

        if ($permissionsData) {
            foreach ($permissionsData as $userId => $perms) {
                // 2. Find the user
                $user = User::find($userId);
                
                if ($user) {
                    // 3. Save the array (Laravel automatically converts this to JSON because of the Model Cast)
                    $user->permissions = $perms; 
                    $user->save();
                }
            }
            return back()->with('success', 'Security Rights Updated!');
        }
        
        return back()->with('success', 'No changes detected.'); 
    }

    public function createCoachUser(Request $request)
    {
        // 1. Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'coach_sport' => 'required|string|in:Basketball,Volleyball,Athletics,Swimming,Taekwondo,Chess,Football,Boxing',
        ]);

        // 2. Create the user account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'coach',
            'coach_sport' => $validated['coach_sport'],
        ]);

        return back()->with('success', "Coach user account '{$user->email}' created successfully for {$validated['coach_sport']}! They can now login.");
    }
    
    public function addClass(Request $request) {
        // Simplified creation for demonstration
        Course::forceCreate($request->except('_token'));
        return back()->with('success', 'Class Added');
    }

    public function saveGrades(Request $request) {
        // 1. Save Grades
        if ($request->has('grades')) {
            \App\Models\GradeScale::truncate(); // Deletes old rows
            
            foreach ($request->grades as $grade) {
                // Only save if the Grade letter is typed in
                if (!empty($grade['grade'])) {
                    \App\Models\GradeScale::create($grade);
                }
            }
        }

        // 2. Save Scholarships
        if ($request->has('scholarships')) {
            \App\Models\ScholarshipCriteria::truncate(); // Deletes old rows
            
            foreach ($request->scholarships as $scholarship) {
                // Only save if the Level is typed in
                if (!empty($scholarship['level'])) {
                    \App\Models\ScholarshipCriteria::create($scholarship);
                }
            }
        }

        return back()->with('success', 'Grades & Scoring Updated!');
    }

    public function addCertificate(Request $request) {
        // 1. Validate input
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'file' => 'required|file|max:10240' // Max 10MB
        ]);

        // 2. Upload the file
        // Saves to storage/app/public/certificates/
        $path = $request->file('file')->store('certificates', 'public');

        // 3. Save to Database
        \App\Models\Certificate::create([
            'name' => $request->name,
            'type' => $request->type,
            'filename' => $path
        ]);

        return back()->with('success', 'Certificate Added Successfully!');
    }
    
    public function addTransaction(Request $request) {
        // Simplified creation for demonstration
        TransactionItem::forceCreate($request->except('_token'));
        return back()->with('success', 'Item Added');
    }

    public function addHoliday(Request $request) {
        \App\Models\Holiday::forceCreate($request->except('_token'));
        return back()->with('success', 'Holiday Added Successfully!');
    }

    // Approve the pending registration
    public function approveAthlete($id)
    {
        $athlete = \App\Models\Athlete::findOrFail($id);
        
        // Change status to 'approved' so they appear in the main list
        $athlete->approval_status = 'approved';
        $athlete->save();

        return back()->with('success', 'Athlete has been successfully verified and added to the official list.');
    }

    // Reject and delete the registration
    public function rejectAthlete($id)
    {
        $athlete = \App\Models\Athlete::findOrFail($id);
        $athlete->delete();

        return back()->with('success', 'Registration request rejected and removed.');
    }

    public function approvals() {
    return view('features.admin_approvals');
    }
}