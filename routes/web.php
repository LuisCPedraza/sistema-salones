<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
// Other routes...
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignmentController;

// ... (puede haber otras rutas aquí)

Route::resource('usuarios', UserController::class);
Route::resource('grupos', GroupController::class);
Route::resource('salones', RoomController::class);
Route::resource('profesores', TeacherController::class);
Route::resource('asignaciones', AssignmentController::class);
