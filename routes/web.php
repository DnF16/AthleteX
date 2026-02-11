<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

// Controllers
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AcademicEvaluationController;
use App\Http\Controllers\FeesDiscountController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\SportsController;

// Coach Sub-Controllers
use App\Http\Controllers\CoachAchievementController;
use App\Http\Controllers\CoachScheduleController;
use App\Http\Controllers\CoachExpenseController;
use App\Http\Controllers\CoachMembershipController;
use App\Http\Controllers\CoachSeminarController;
use App\Http\Controllers\CoachWorkHistoryController;

// ==============================================================
// PUBLIC ROUTES (No Login Required)
// ==============================================================

// Login Page (Home)
Route::get('/', function () {
    return view('log.login');
})->name('log.login');

// Handle Login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
})->name('login');


// ==============================================================
// PUBLIC ALUMNI REGISTRATION (The "Public Form")
// ==============================================================
Route::get('/alumni-registration', [AthleteController::class, 'showPublicRegistrationForm'])->name('alumni.register.show');
Route::post('/alumni-registration', [AthleteController::class, 'storePublicRegistration'])->name('alumni.register.submit');


// ==============================================================
// AUTHENTICATED ROUTES (Login Required)
// ==============================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () { return view('features.dashboard'); })->name('dashboard');
    Route::get('/coach', function () { return view('features.coach'); })->name('coach');
    Route::get('/schedule', function () { return view('features.schedule'); })->name('schedule');
    Route::get('/sports', function () { return view('features.sports'); })->name('sports');
    Route::get('/student-athlete', function () { return view('features.student_athlete'); })->name('student.athlete');

    // Student Athlete Logic
    Route::get('/student-athletes', [AthleteController::class, 'index'])->name('student.athletes');

    // Athlete CRUD
    Route::get('/athletes', [AthleteController::class, 'index'])->name('athletes.index');
    Route::get('/athletes/create', [AthleteController::class, 'create'])->name('athletes.create');
    Route::post('/athletes', [AthleteController::class, 'store'])->name('athletes.store');
    Route::get('/athletes/search', [AthleteController::class, 'search'])->name('athletes.search');
    Route::get('/athletes/{athlete}', [AthleteController::class, 'show'])->name('athletes.show');
    Route::put('/athletes/{athlete}', [AthleteController::class, 'update'])->name('athletes.update');
    Route::get('/athlete/{id}/print', [AthleteController::class, 'printProfile'])->name('athlete.print');

    // Sub-tables
    Route::post('/academic-evaluation', [AcademicEvaluationController::class, 'store']);
    Route::get('/academic-evaluation/{athlete_id}', [AcademicEvaluationController::class, 'show']);

    Route::post('/fees-discounts', [FeesDiscountController::class, 'store']);
    Route::get('/fees-discounts/{athlete_id}', [FeesDiscountController::class, 'show']);

    Route::post('/work-history', [WorkHistoryController::class, 'store']);
    Route::get('/work-history/{athlete_id}', [WorkHistoryController::class, 'show']);
});


// ==============================================================
// COACH ROUTES
// ==============================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/coaches', [CoachController::class, 'index'])->name('coaches.index');
    Route::get('/coaches/create', [CoachController::class, 'create'])->name('coaches.create');
    Route::post('/coaches', [CoachController::class, 'store'])->name('coaches.store');
    Route::get('/coaches/search', [CoachController::class, 'search'])->name('coaches.search');
    Route::get('/coaches-api/available-sports', [CoachController::class, 'getAvailableSports'])->name('coaches.available-sports');
    Route::get('/coaches/{coach}', [CoachController::class, 'show'])->name('coaches.show');
    Route::put('/coaches/{coach}', [CoachController::class, 'update'])->name('coaches.update');

    // Coach Sub-features
    Route::get('/coaches/{id}/achievements', [CoachAchievementController::class, 'show'])->name('coach.achievements.show');
    Route::post('/coach-achievements', [CoachAchievementController::class, 'store'])->name('coach.achievements.store');
    Route::put('/coach-achievements/{id}', [CoachAchievementController::class, 'update'])->name('coach.achievements.update');
    Route::delete('/coach-achievements/{id}', [CoachAchievementController::class, 'destroy'])->name('coach.achievements.destroy');

    Route::get('/coach-schedules/{coach_id}', [CoachScheduleController::class, 'show']);
    Route::post('/coach-schedules', [CoachScheduleController::class, 'store']);
    Route::put('/coach-schedules/{id}', [CoachScheduleController::class, 'update']);
    Route::delete('/coach-schedules/{id}', [CoachScheduleController::class, 'destroy']);

    Route::get('/coach-expenses/{coach_id}', [CoachExpenseController::class, 'show']);
    Route::post('/coach-expenses', [CoachExpenseController::class, 'store']);
    Route::put('/coach-expenses/{id}', [CoachExpenseController::class, 'update']);
    Route::delete('/coach-expenses/{id}', [CoachExpenseController::class, 'destroy']);

    Route::get('/coach-memberships/{coach_id}', [CoachMembershipController::class, 'show']);
    Route::post('/coach-memberships', [CoachMembershipController::class, 'store']);
    Route::put('/coach-memberships/{id}', [CoachMembershipController::class, 'update']);
    Route::delete('/coach-memberships/{id}', [CoachMembershipController::class, 'destroy']);

    Route::get('/coach-seminars/{coach_id}', [CoachSeminarController::class, 'show']);
    Route::post('/coach-seminars', [CoachSeminarController::class, 'store']);
    Route::put('/coach-seminars/{id}', [CoachSeminarController::class, 'update']);
    Route::delete('/coach-seminars/{id}', [CoachSeminarController::class, 'destroy']);

    Route::get('/coach-work-history/{coach_id}', [CoachWorkHistoryController::class, 'show']);
    Route::post('/coach-work-history', [CoachWorkHistoryController::class, 'store']);
    Route::put('/coach-work-history/{id}', [CoachWorkHistoryController::class, 'update']);
    Route::delete('/coach-work-history/{id}', [CoachWorkHistoryController::class, 'destroy']);
});


// ==============================================================
// ADMIN PANEL ROUTES (Protected)
// ==============================================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', AdminMiddleware::class]) 
    ->group(function () {
    
    // 1. Dashboard Views
    Route::get('/general', [AdminController::class, 'general'])->name('general');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/scheduling', [AdminController::class, 'scheduling'])->name('scheduling');
    Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');
    Route::get('/grades', [AdminController::class, 'grades'])->name('grades');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');

    // 2. APPROVALS (UPDATED: Using AthleteController to match your Blade file)
    // This is the Page
    Route::get('/approvals', [AthleteController::class, 'showApprovals'])->name('approvals.index');
    
    // This is the View Profile button
    Route::get('/approvals/{id}/view', [AthleteController::class, 'show'])->name('approvals.show');

    // These are the Actions (Approve/Reject)
    // Note: I mapped these to match the names in your approvals.blade.php
    Route::post('/approvals/{id}/approve', [AthleteController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{id}/decline', [AthleteController::class, 'decline'])->name('approvals.decline');

    // 3. Other Admin Actions
    Route::post('/save-settings', [AdminController::class, 'saveSettings'])->name('saveSettings');
    Route::post('/add-class', [AdminController::class, 'addClass'])->name('addClass');
    Route::post('/add-transaction', [AdminController::class, 'addTransaction'])->name('addTransaction');
    Route::post('/save-grades', [AdminController::class, 'saveGrades'])->name('saveGrades');
    Route::post('/users/update', [AdminController::class, 'updateUserPermissions'])->name('updateUserPermissions');
    Route::post('/users/create-coach', [AdminController::class, 'createCoachUser'])->name('createCoachUser');
    Route::post('/add-holiday', [AdminController::class, 'addHoliday'])->name('addHoliday');
    Route::post('/add-certificate', [AdminController::class, 'addCertificate'])->name('addCertificate');

    Route::get('/sports/filter/{sport}', [SportsController::class, 'filter'])->name('sports.filter');
});