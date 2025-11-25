<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AcademicEvaluationController;
use App\Http\Controllers\FeesDiscountController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route as Router;

Route::get('/', function () {
	return view('features.dashboard');
})->name('dashboard');

Route::get('/coaches', function () {
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


//==================================================================
// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    
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
    Route::post('/users/update', [AdminController::class, 'updateUserPermissions'])->name('updateUserPermissions');
});