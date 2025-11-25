<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AcademicEvaluationController;
use App\Http\Controllers\FeesDiscountController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\CoachController;

Route::get('/', function () {
	return view('features.dashboard');
})->name('dashboard');

Route::get('/coach', function () {
	return view('features.coach');
})->name('coach');

Route::get('/schedule', function () {
	return view('features.schedule');
})->name('schedule');

// Log Routes
Route::get('/login', function () {
	return view('log.login');
})->name('log.login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
	return redirect()->route('dashboard');
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



// ================================================================================================================================
// Coach CRUD routes
Route::get('/coaches', [CoachController::class, 'index'])->name('coaches.index');
Route::get('/coaches/create', [CoachController::class, 'create'])->name('coaches.create');
Route::post('/coaches', [CoachController::class, 'store'])->name('coaches.store');
// Live search endpoint used by the coach page (AJAX)
Route::get('/coaches/search', [CoachController::class, 'search'])->name('coaches.search');
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

