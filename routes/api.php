<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
          'id' => $request->user()->id,
          'username' => $request->user()->username,
          'role' => $request->user()->role
    ]);
});

// Route::post('/login', [AuthConroller::class, 'login']);  

Route::post('/login', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'Logout'])->middleware('auth:sanctum');


Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    Route::post('/create-teacher',[TeacherController::class,'store']);
    Route::get('/teacher-list',[TeacherController::class,'index']);

    // Subject
     Route::post('/create-subject',[SubjectController::class,'store']);
      Route::get('/list-subject',[SubjectController::class,'index']);
});
