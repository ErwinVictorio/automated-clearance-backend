<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RequirmentController;
use App\Http\Controllers\RequirmentSubmitedController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'username' => $request->user()->username,
        'full_name' => $request->user()->full_name,
        'role' => $request->user()->role
    ]);
});

// Route::post('/login', [AuthConroller::class, 'login']);  

Route::post('/register', [AuthController::class, 'Regiter']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'Logout'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    Route::post('/create-teacher', [TeacherController::class, 'store']);
    Route::get('/teacher-list', [TeacherController::class, 'index']);

    // Subject
    Route::post('/create-subject', [SubjectController::class, 'store']);
    Route::get('/list-subject', [SubjectController::class, 'ShowToAdmin']);
    Route::get('/total-subject', [SubjectController::class, 'TotalSibject']);
    Route::get('/total-teacher', [TeacherController::class, 'TotalTeacher']);

    Route::get('/get-students-by-teacher/{id}',[TeacherController::class,'show']);
});



// Routes For Teacher
Route::middleware(['auth:sanctum', 'role:teacher'])->prefix('teacher')->group(function () {

    Route::get('/subjects', [SubjectController::class, 'index']);
    Route::post('/requirment', [RequirmentController::class, 'store']);
    Route::post('/create-announcement', [AnnouncementController::class, 'store']);
    Route::get('/annoucements-list', [AnnouncementController::class, 'index']);
    Route::get('/requirments-list', [RequirmentController::class, 'index']);
    Route::delete('/delete-requirment/{id}', [RequirmentController::class, 'destroy']);

    // show the announcement list
    Route::get('/get-annoucement-by-teacher', [AnnouncementController::class, 'ShowByTeacherId']);
    Route::delete('/deleterequirment/{id}', [AnnouncementController::class, 'destroy']);


    //  list of requirment submited
    Route::get('/get-submmited-requirment', [RequirmentSubmitedController::class, 'showAll']);
    Route::post('/update-status/{id}', [RequirmentSubmitedController::class, 'UpdateStatus']);
    Route::get('/counte-requirment', [RequirmentController::class, 'CounteTotalRequirmentByTeacherId']);
    Route::get('/count-announcemnt', [AnnouncementController::class, 'CounteTotalAnnouncementByTeacherId']);
});


//  For Student
Route::middleware(['auth:sanctum', 'role:student'])->prefix('student')->group(function () {

    Route::get('/teacher-list', [TeacherController::class, 'showTeacherName']);
    Route::get('/annoucements', [AnnouncementController::class, 'index']);
    Route::get('/requirment/{teacherId}', [RequirmentController::class, 'showByTeacherId']);
    Route::post('/store-requirment', [RequirmentSubmitedController::class, 'store']);
    Route::get('/requirments', [RequirmentController::class, 'index']);
    Route::post('/submit-requirment', [RequirmentSubmitedController::class, 'store']);

    //  sho the submited requirment by student
    Route::get('/submited-requirment', [RequirmentSubmitedController::class, 'index']);
    Route::delete('/delete-requirment/{id}', [RequirmentSubmitedController::class, 'destroy']);
});
