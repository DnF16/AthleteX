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
    
    // Get the permissions data array from the request input
    $permissionsData = $request->input('permissions'); 

    // Check if the permissions data exists before processing (This is the fix!)
    if ($permissionsData) {
        foreach ($permissionsData as $userId => $perms) {
            $user = \App\Models\User::find($userId);
            
            if ($user) {
                // $perms is an array like ['admin' => 'Edit', 'athletes' => 'View']
                $user->permissions = $perms; 
                $user->save();
            }
        }
        return back()->with('success', 'Security Rights Updated!');
    }
    
    // If no permissions array was submitted (e.g., table was empty or no changes were made), 
    // we still return a success message to prevent the unhandled exception (500 error).
    return back()->with('success', 'No changes detected or permissions already updated!'); 
}
    
    public function addClass(Request $request) {
        // Simplified creation for demonstration
        Course::forceCreate($request->except('_token'));
        return back()->with('success', 'Class Added');
    }
    
    public function addTransaction(Request $request) {
        // Simplified creation for demonstration
        TransactionItem::forceCreate($request->except('_token'));
        return back()->with('success', 'Item Added');
    }
}