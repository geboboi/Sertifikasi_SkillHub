<?php

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Participant routes
Route::resource('participants', ParticipantController::class);

// Class routes
Route::resource('classes', ClassesController::class);

// Enrollment routes
Route::resource('enrollments', EnrollmentController::class)->except(['show', 'edit', 'update']);

// Custom enrollment routes
Route::get('/participants/{participant}/classes', [EnrollmentController::class, 'participantClasses'])
     ->name('participants.classes');
     
Route::get('/classes/{class}/participants', [EnrollmentController::class, 'classParticipants'])
     ->name('classes.participants');