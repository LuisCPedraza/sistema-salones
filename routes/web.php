<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Other routes...
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;

// ... (puede haber otras rutas aquí)

Route::resource('usuarios', UserController::class);
Route::resource('grupos', GroupController::class);

