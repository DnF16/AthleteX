<?php

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AcademicEvaluationController;
use App\Http\Controllers\FeesDiscountController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route as Router;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ApprovalController;


// Route::get('/', function () {
//     return view('log.login');   
// })->name('login');
// Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/dashboard', function () {
	return view('features.dashboard');
})->name('dashboard');

Route::get('/coach', function () {
	return view('features.coach');
})->name('coach');

Route::get('/schedule', function () {
	return view('features.schedule');
})->name('schedule');

Route::get('/sports', function () {
	return view('features.sports');
})->name('sports');

// // Log Routes
// Show login form
Route::get('/', function () {
    return view('log.login');
})->name('log.login');

// Handle login form submission
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
})->name('login');


// Student athlete pages
Route::get('/student-athlete', function () {
	return view('features.student_athlete');
})->name('student.athlete');

Route::get('/student-athletes', [AthleteController::class, 'index'])->name('student.athletes');


// ==============================================================
// Athlete CRUD routes
Route::get('/athletes', [AthleteController::class, 'index'])->name('athletes.index');
Route::get('/athletes/create', [AthleteController::class, 'create'])->name('athletes.create');
Route::post('/athletes', [AthleteController::class, 'store'])->name('athletes.store');
// Live search endpoint used by the student athlete page (AJAX)
Route::get('/athletes/search', [AthleteController::class, 'search'])->name('athletes.search');
// Get full athlete (with related sections)
Route::get('/athletes/{athlete}', [AthleteController::class, 'show'])->name('athletes.show');
// Update athlete
Route::put('/athletes/{athlete}', [AthleteController::class, 'update'])->name('athletes.update');

// =================================================================
// Achievement CRUD routes
Route::get('/athletes/{id}/achievements', [AchievementController::class, 'index']);
Route::post('/achievements/store', [AchievementController::class, 'store']);
Route::put('/achievements/{id}', [AchievementController::class, 'update']);
Route::delete('/achievements/{id}', [AchievementController::class, 'destroy']);

// =================================================================
// Academic Evaluation routes
Route::post('/academic-evaluation', [AcademicEvaluationController::class, 'store']);
Route::get('/academic-evaluation/{athlete_id}', [AcademicEvaluationController::class, 'show']);

// =================================================================
// Fees and Discounts routes
Route::post('/fees-discounts', [FeesDiscountController::class, 'store']);
Route::get('/fees-discounts/{athlete_id}', [FeesDiscountController::class, 'show']);

// =================================================================
Route::post('/work-history', [WorkHistoryController::class, 'store']);
Route::get('/work-history/{athlete_id}', [WorkHistoryController::class, 'show']);


//==================================================================
// Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', AdminMiddleware::class])
    ->group(function () {
    
    
    // View Routes (The 8 Screens)
    Route::get('/general', [AdminController::class, 'general'])->name('general');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/scheduling', [AdminController::class, 'scheduling'])->name('scheduling');
    Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');
    Route::get('/grades', [AdminController::class, 'grades'])->name('grades');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');

    // Action Routes (Form Submissions)
    Route::post('/save-settings', [AdminController::class, 'saveSettings'])->name('saveSettings');
    Route::post('/add-class', [AdminController::class, 'addClass'])->name('addClass');
    Route::post('/add-transaction', [AdminController::class, 'addTransaction'])->name('addTransaction');
    Route::post('/save-settings', [AdminController::class, 'saveSettings'])->name('saveSettings');
    Route::post('/save-grades', [AdminController::class, 'saveGrades'])->name('saveGrades');
    Route::post('/users/update', [AdminController::class, 'updateUserPermissions'])->name('updateUserPermissions');
    Route::post('/users/create-coach', [AdminController::class, 'createCoachUser'])->name('createCoachUser');
    Route::post('/add-holiday', [AdminController::class, 'addHoliday'])->name('addHoliday');
    Route::post('/add-certificate', [AdminController::class, 'addCertificate'])->name('addCertificate');

    Route::get('/sports/filter/{sport}', [SportsController::class, 'filter'])->name('sports.filter');

});

// ================================================================================================================================
// Coach CRUD routes
Route::get('/coaches', [CoachController::class, 'index'])->name('coaches.index');
Route::get('/coaches/create', [CoachController::class, 'create'])->name('coaches.create');
Route::post('/coaches', [CoachController::class, 'store'])->name('coaches.store');
// Live search endpoint used by the coach page (AJAX)
Route::get('/coaches/search', [CoachController::class, 'search'])->name('coaches.search');
// Get available sports for coach assignment
Route::get('/coaches-api/available-sports', [CoachController::class, 'getAvailableSports'])->name('coaches.available-sports');
// Get full coach (with related sections)
Route::get('/coaches/{coach}', [CoachController::class, 'show'])->name('coaches.show');
// Update coach
Route::put('/coaches/{coach}', [CoachController::class, 'update'])->name('coaches.update');

// coach achievemnt routes
Route::get('/coaches/{id}/achievements', [CoachAchievementController::class, 'show'])
    ->name('coach.achievements.show');

Route::post('/coach-achievements', [CoachAchievementController::class, 'store'])
    ->name('coach.achievements.store');

Route::put('/coach-achievements/{id}', [CoachAchievementController::class, 'update'])
    ->name('coach.achievements.update');

Route::delete('/coach-achievements/{id}', [CoachAchievementController::class, 'destroy'])
    ->name('coach.achievements.destroy');


// coach assigned schedule / Athletes routes
Route::get('/coach-schedules/{coach_id}', [CoachScheduleController::class, 'show']);
Route::post('/coach-schedules', [CoachScheduleController::class, 'store']);
Route::put('/coach-schedules/{id}', [CoachScheduleController::class, 'update']);
Route::delete('/coach-schedules/{id}', [CoachScheduleController::class, 'destroy']);

// coach expenses routes
Route::get('/coach-expenses/{coach_id}', [CoachExpenseController::class, 'show']);
Route::post('/coach-expenses', [CoachExpenseController::class, 'store']);
Route::put('/coach-expenses/{id}', [CoachExpenseController::class, 'update']);
Route::delete('/coach-expenses/{id}', [CoachExpenseController::class, 'destroy']);

// coach expenses routes
Route::get('/coach-memberships/{coach_id}', [CoachMembershipController::class, 'show']);
Route::post('/coach-memberships', [CoachMembershipController::class, 'store']);
Route::put('/coach-memberships/{id}', [CoachMembershipController::class, 'update']);
Route::delete('/coach-memberships/{id}', [CoachMembershipController::class, 'destroy']);

// coach Seminars routes
Route::get('/coach-seminars/{coach_id}', [CoachSeminarController::class, 'show']);
Route::post('/coach-seminars', [CoachSeminarController::class, 'store']);
Route::put('/coach-seminars/{id}', [CoachSeminarController::class, 'update']);
Route::delete('/coach-seminars/{id}', [CoachSeminarController::class, 'destroy']);

// coach Work History routes
Route::get('/coach-work-history/{coach_id}', [CoachWorkHistoryController::class, 'show']);
Route::post('/coach-work-history', [CoachWorkHistoryController::class, 'store']);
Route::put('/coach-work-history/{id}', [CoachWorkHistoryController::class, 'update']);
Route::delete('/coach-work-history/{id}', [CoachWorkHistoryController::class, 'destroy']);


// =================================================================
// Work History routes (if coaches have it)
Route::post('/coach-work-history', [CoachWorkHistoryController::class, 'store']);
Route::get('/coach-work-history/{coach_id}', [CoachWorkHistoryController::class, 'show']);

// =================================================================
// Admin Athlete Approval Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/approvals', [ApprovalController::class, 'pendingApprovals'])->name('approvals.pending');
    Route::get('/approvals/{athlete}', [ApprovalController::class, 'show'])->name('approvals.show');
    Route::post('/approvals/{athlete}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{athlete}/decline', [ApprovalController::class, 'decline'])->name('approvals.decline');
    // --- ADMIN APPROVAL ROUTES ---
    // Approve a pending athlete
    Route::post('/admin/approve-athlete/{id}', [App\Http\Controllers\AdminController::class, 'approveAthlete'])->name('admin.approve.athlete');
    // Reject/Delete a pending athlete
    Route::delete('/admin/reject-athlete/{id}', [App\Http\Controllers\AdminController::class, 'rejectAthlete'])->name('admin.reject.athlete');
});

// --- PUBLIC ALUMNI REGISTRATION ROUTES ---

// 1. Show the registration form (GET)
Route::get('/alumni-registration', [AthleteController::class, 'showPublicRegistrationForm'])->name('alumni.register.show');

// 2. Submit the form data (POST)
Route::post('/alumni-registration', [AthleteController::class, 'storePublicRegistration'])->name('alumni.register.submit');
