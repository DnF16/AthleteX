<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteController;

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

// Athlete CRUD routes
Route::get('/athletes', [AthleteController::class, 'index'])->name('athletes.index');
Route::get('/athletes/create', [AthleteController::class, 'create'])->name('athletes.create');
Route::post('/athletes', [AthleteController::class, 'store'])->name('athletes.store');
// Live search endpoint used by the student athlete page (AJAX)
Route::get('/athletes/search', [AthleteController::class, 'search'])->name('athletes.search');
// Update athlete
Route::put('/athletes/{athlete}', [AthleteController::class, 'update'])->name('athletes.update');
