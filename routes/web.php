<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
// Other routes...
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RoomController;

// ... (puede haber otras rutas aquí)

Route::resource('usuarios', UserController::class);
Route::resource('grupos', GroupController::class);
Route::resource('salones', RoomController::class);

