<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

// Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AcademicEvaluationController;
use App\Http\Controllers\FeesDiscountController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\SportsController;
use App\Http\Controllers\TryoutScheduleController; // <--- ADDED THIS!

// Coach Sub-Controllers
use App\Http\Controllers\CoachAchievementController;
use App\Http\Controllers\CoachScheduleController;
use App\Http\Controllers\CoachExpenseController;
use App\Http\Controllers\CoachMembershipController;
use App\Http\Controllers\CoachSeminarController;
use App\Http\Controllers\CoachWorkHistoryController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ReportController;


// ==============================================================
// PUBLIC ROUTES (No Login Required)
// ==============================================================

Route::get('/', function () { return view('log.login'); })->name('log.login');
Route::get('/login', function () { return view('log.login'); })->name('login');

// Handle Login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
})->name('login.post');

// PUBLIC ALUMNI REGISTRATION
Route::get('/alumni-registration', [AthleteController::class, 'showPublicRegistrationForm'])->name('alumni.register.show');
Route::post('/alumni-registration', [AthleteController::class, 'storePublicRegistration'])->name('alumni.register.submit');


// ==============================================================
// AUTHENTICATED ROUTES (Login Required)
// ==============================================================
Route::middleware(['auth'])->group(function () {

    // General Views
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/schedule', function () { return view('features.schedule'); })->name('schedule');
    Route::get('/sports', function () { return view('features.sports'); })->name('sports');

    // Athlete Profile & Lists (Shared)
    Route::get('/student-athlete', [AthleteController::class, 'create'])->name('student.athlete');
    Route::get('/student-athletes', [AthleteController::class, 'index'])->name('student.athletes');
    
    // Athlete CRUD
    Route::get('/athletes', [AthleteController::class, 'index'])->name('athletes.index');
    Route::get('/athletes/create', [AthleteController::class, 'create'])->name('athletes.create');
    Route::post('/athletes', [AthleteController::class, 'store'])->name('athletes.store');
    Route::get('/athletes/search', [AthleteController::class, 'search'])->name('athletes.search');
    Route::get('/athletes/{athlete}', [AthleteController::class, 'show'])->name('athletes.show');
    Route::put('/athletes/{athlete}', [AthleteController::class, 'update'])->name('athletes.update');
    Route::get('/athlete/{id}/print', [AthleteController::class, 'printProfile'])->name('athlete.print');

    // Related Athlete Tables
    Route::post('/academic-evaluation', [AcademicEvaluationController::class, 'store']);
    Route::get('/academic-evaluation/{athlete_id}', [AcademicEvaluationController::class, 'show']);
    Route::post('/fees-discounts', [FeesDiscountController::class, 'store']);
    Route::get('/fees-discounts/{athlete_id}', [FeesDiscountController::class, 'show']);
    Route::post('/work-history', [WorkHistoryController::class, 'store']);
    Route::get('/work-history/{athlete_id}', [WorkHistoryController::class, 'show']);

    // Shared Attendance
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');

    // Shared Reports
    Route::get('/reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');
    Route::patch('/reports/{report}/mark-received', [ReportController::class, 'markReceived'])->name('reports.mark-received');
    Route::patch('/reports/{report}/mark-rejected', [ReportController::class, 'markRejected'])->name('reports.mark-rejected');

    // ==============================================================
    // COACH ROUTES
    // ==============================================================
    Route::get('/coach', function () { return view('features.coach'); })->name('coach');
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

    // Coach-Specific Attendance & Reports
    Route::prefix('coach')->name('coach.')->group(function () {
        Route::get('/attendance', [AttendanceController::class, 'coachIndex'])->name('attendance.index');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/reports', [ReportController::class, 'coachIndex'])->name('reports.index');
        Route::post('/reports', [ReportController::class, 'coachStore'])->name('reports.store');
    });

    // ==============================================================
    // ADMIN PANEL ROUTES (Protected)
    // ==============================================================
    Route::prefix('admin')->name('admin.')->middleware([AdminMiddleware::class])->group(function () {
        
        Route::get('/general', [AdminController::class, 'general'])->name('general');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
        Route::get('/scheduling', [AdminController::class, 'scheduling'])->name('scheduling');
        Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');
        Route::get('/grades', [AdminController::class, 'grades'])->name('grades');
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');

        // Approvals
        Route::get('/approvals', [AthleteController::class, 'showApprovals'])->name('approvals');
        Route::get('/approvals/{id}/view', [AthleteController::class, 'show'])->name('approvals.show');
        Route::post('/approvals/{id}/approve', [AthleteController::class, 'approve'])->name('approve.athlete');
        Route::post('/approvals/{id}/decline', [AthleteController::class, 'decline'])->name('reject.athlete');

        // Admin Other Actions
        Route::post('/save-settings', [AdminController::class, 'saveSettings'])->name('saveSettings');
        Route::post('/add-class', [AdminController::class, 'addClass'])->name('addClass');
        Route::post('/add-transaction', [AdminController::class, 'addTransaction'])->name('addTransaction');
        Route::post('/save-grades', [AdminController::class, 'saveGrades'])->name('saveGrades');
        Route::post('/users/update', [AdminController::class, 'updateUserPermissions'])->name('updateUserPermissions');
        Route::post('/users/create-coach', [AdminController::class, 'createCoachUser'])->name('createCoachUser');
        Route::post('/add-holiday', [AdminController::class, 'addHoliday'])->name('addHoliday');
        Route::post('/add-certificate', [AdminController::class, 'addCertificate'])->name('addCertificate');
        
        // Admin specific attendance and reports
        Route::get('/attendance', [AttendanceController::class, 'adminIndex'])->name('attendance');
        Route::get('/reports', [ReportController::class, 'adminIndex'])->name('reports');
    });

    // ==============================================================
    // MANAGE TRYOUTS ROUTES (Admin Only) -> ADDED THIS! 🚀
    // ==============================================================
    Route::middleware([AdminMiddleware::class])->group(function() {
        Route::get('/tryouts', [TryoutScheduleController::class, 'index'])->name('tryouts.index');
        Route::post('/tryouts', [TryoutScheduleController::class, 'store'])->name('tryouts.store');
        Route::post('/tryouts/{id}/delete', [TryoutScheduleController::class, 'destroy'])->name('tryouts.destroy'); 
    });

    Route::get('/sports/filter/{sport}', [SportsController::class, 'filter'])->name('sports.filter');
});