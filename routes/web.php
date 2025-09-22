<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomAvailabilityController;
use App\Http\Controllers\TeacherAvailabilityController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Nuestras rutas
    Route::resource('usuarios', UserController::class);
    Route::resource('grupos', GroupController::class);
    Route::resource('salones', RoomController::class);
    Route::resource('profesores', TeacherController::class);
    Route::resource('asignaciones', AssignmentController::class);
    Route::get('/horario', [AssignmentController::class, 'showHorario'])->name('horario.show');
    //Autoasignación (Épica 5)
    Route::post('/asignaciones/auto', [AssignmentController::class, 'autoAssign'])->name('asignaciones.auto');
    // Horarios personales (Épica 7)
    Route::get('/horario/profesor/{teacher}', [AssignmentController::class, 'teacherSchedule'])->name('horario.profesor');
    Route::get('/horario/grupo/{group}', [AssignmentController::class, 'groupSchedule'])->name('horario.grupo');
    Route::get('/horario/salon/{room}', [AssignmentController::class, 'roomSchedule'])->name('horario.salon');
    // Reportes (Épica 7)
    Route::get('/reportes', [AssignmentController::class, 'reports'])->name('reportes.index');

    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->middleware(['auth'])
        ->name('dashboard');

    Route::resource('rooms.availabilities', RoomAvailabilityController::class)->shallow();
    Route::resource('teachers.availabilities', TeacherAvailabilityController::class)->shallow();
});

require __DIR__.'/auth.php';
