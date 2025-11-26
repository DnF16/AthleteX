<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// --- CONTROLLER IMPORTS ---
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AcademicEvaluationController;
use App\Http\Controllers\FeesDiscountController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AchievementController; // <--- Added this missing import

// --- PUBLIC ROUTES ---
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

Route::post('/login', function (Request $request) {
    return redirect()->route('dashboard');
})->name('login');

// Student athlete pages
Route::get('/student-athlete', function () {
    return view('features.student_athlete');
})->name('student.athlete');

Route::get('/student-athletes', [AthleteController::class, 'index'])->name('student.athletes');


// --- ATHLETE CRUD ---
Route::get('/athletes', [AthleteController::class, 'index'])->name('athletes.index');
Route::get('/athletes/create', [AthleteController::class, 'create'])->name('athletes.create');
Route::post('/athletes', [AthleteController::class, 'store'])->name('athletes.store');
Route::get('/athletes/search', [AthleteController::class, 'search'])->name('athletes.search');
Route::get('/athletes/{athlete}', [AthleteController::class, 'show'])->name('athletes.show');
Route::put('/athletes/{athlete}', [AthleteController::class, 'update'])->name('athletes.update');

// --- ACHIEVEMENT CRUD ---
Route::get('/athletes/{id}/achievements', [AchievementController::class, 'index']);
Route::post('/achievements/store', [AchievementController::class, 'store']);
Route::put('/achievements/{id}', [AchievementController::class, 'update']);
Route::delete('/achievements/{id}', [AchievementController::class, 'destroy']);

// --- ACADEMIC EVALUATION ---
Route::post('/academic-evaluation', [AcademicEvaluationController::class, 'store']);
Route::get('/academic-evaluation/{athlete_id}', [AcademicEvaluationController::class, 'show']);

// --- FEES AND DISCOUNTS ---
Route::post('/fees-discounts', [FeesDiscountController::class, 'store']);
Route::get('/fees-discounts/{athlete_id}', [FeesDiscountController::class, 'show']);

// --- WORK HISTORY ---
Route::post('/work-history', [WorkHistoryController::class, 'store']);
Route::get('/work-history/{athlete_id}', [WorkHistoryController::class, 'show']);


// --- ADMIN ROUTES (Your Module) ---
Route::prefix('admin')->name('admin.')->group(function () {
    
    // View Routes
    Route::get('/general', [AdminController::class, 'general'])->name('general');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/scheduling', [AdminController::class, 'scheduling'])->name('scheduling');
    Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');
    Route::get('/grades', [AdminController::class, 'grades'])->name('grades');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');

    // Action Routes
    Route::post('/save-settings', [AdminController::class, 'saveSettings'])->name('saveSettings');
    Route::post('/add-class', [AdminController::class, 'addClass'])->name('addClass');
    Route::post('/add-transaction', [AdminController::class, 'addTransaction'])->name('addTransaction');
    Route::post('/users/update', [AdminController::class, 'updateUserPermissions'])->name('updateUserPermissions');
    Route::post('/add-holiday', [AdminController::class, 'addHoliday'])->name('addHoliday');
    Route::post('/add-certificate', [AdminController::class, 'addCertificate'])->name('addCertificate');
    Route::post('/save-grades', [AdminController::class, 'saveGrades'])->name('saveGrades');
});