<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Other routes...
use App\Http\Controllers\UserController;

// ... (puede haber otras rutas aquí)

Route::resource('usuarios', UserController::class);