<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Course;
use App\Models\User;
use App\Models\TransactionItem;
use App\Models\Holiday; 
use App\Models\Certificate; 
use App\Models\GradeScale;
use App\Models\ScholarshipCriteria;

class AdminController extends Controller
{
    // --- VIEW LOADERS ---
    public function general() { return view('admin.general'); }
    public function settings() { return view('admin.settings'); }
    public function users() { $users = User::all(); return view('admin.users', compact('users')); }
    public function classes() { $courses = Course::all(); return view('admin.classes', compact('courses')); }
    
    public function scheduling() { 
        $holidays = Holiday::all(); 
        return view('admin.scheduling', compact('holidays')); 
    }
    
    public function certificates() { 
        $certs = Certificate::all(); 
        return view('admin.certificates', compact('certs'));
    }
    
    public function grades() { 
    $grades = GradeScale::all();
    $scholarships = ScholarshipCriteria::all();
    return view('admin.grades', compact('grades', 'scholarships')); 
    }

    public function saveGrades(Request $request) {
    // 1. Save Grades
    if ($request->has('grades')) {
        // Delete old records to replace with new list
        \App\Models\GradeScale::truncate(); 
        
        foreach ($request->grades as $grade) {
            // FIX: Only save if ALL fields have data
            if (!empty($grade['grade']) && !empty($grade['min_percent']) && !empty($grade['min_score'])) {
                \App\Models\GradeScale::create($grade);
            }
        }
    }

    // 2. Save Scholarships
    if ($request->has('scholarships')) {
        // Delete old records
        \App\Models\ScholarshipCriteria::truncate();
        
        foreach ($request->scholarships as $scholarship) {
            // FIX: Only save if the Level field is not empty
            if (!empty($scholarship['level'])) {
                \App\Models\ScholarshipCriteria::create($scholarship);
                    }
                }
            }

            return back()->with('success', 'Grades & Scoring Updated!');
        }
            

    public function transactions() { $items = TransactionItem::all(); return view('admin.transactions', compact('items')); }

    // --- ACTIONS ---

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
        $permissionsData = $request->input('permissions'); 

        if ($permissionsData) {
            foreach ($permissionsData as $userId => $perms) {
                $user = User::find($userId);
                if ($user) {
                    $user->permissions = $perms; 
                    $user->save();
                }
            }
            return back()->with('success', 'Security Rights Updated!');
        }
        return back()->with('success', 'No changes detected.'); 
    }
    
    public function addClass(Request $request) {
        $request->validate([
            'subject' => 'required|string|max:255',
        ]);
        Course::forceCreate($request->except('_token'));
        return back()->with('success', 'Class Added!');
    }
    
    public function addTransaction(Request $request) {
        TransactionItem::forceCreate($request->except('_token'));
        return back()->with('success', 'Item Added');
    }

    public function addHoliday(Request $request) {
        Holiday::forceCreate($request->except('_token'));
        return back()->with('success', 'Holiday Added Successfully!');
    }

    public function addCertificate(Request $request) {
    // 1. Validate input
    $request->validate([
        'name' => 'required|string',
        'type' => 'required|string',
        'file' => 'required|file|max:10240' // Max 10MB
    ]);

    // 2. Upload the file to storage
    // This will save to: storage/app/public/certificates/
    $path = $request->file('file')->store('certificates', 'public');

    // 3. Save info to Database
    \App\Models\Certificate::create([
        'name' => $request->name,
        'type' => $request->type,
        'filename' => $path // We save the path, not just the name
    ]);

    return back()->with('success', 'Certificate Added Successfully!');
}
}