<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Room;
use App\Rules\NoTimeOverlap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index()
    {
        $asignaciones = Assignment::with(['group', 'teacher.user', 'room'])->get();
        return view('asignaciones.index', ['asignaciones' => $asignaciones]);
    }

    public function create()
    {
        $grupos = Group::all();
        $profesores = Teacher::with('user')->get();
        $salones = Room::all();
        return view('asignaciones.create', [
            'grupos' => $grupos,
            'profesores' => $profesores,
            'salones' => $salones,
        ]);
    }

    public function store(Request $request)
    {
        dd('Estoy dentro del método store'); // <-- AÑADE ESTA LÍNEA ESPÍA
        $validatedData = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
                new NoTimeOverlap(), // La regla personalizada se encarga de todo
            ],
        ]);

        Assignment::create($validatedData);

        return redirect('/asignaciones');
    }

    public function show(Assignment $assignment){}

    public function edit(Assignment $asignacione)
    {
        return view('asignaciones.edit', [
            'asignacione' => $asignacione,
            'grupos' => Group::all(),
            'profesores' => Teacher::with('user')->get(),
            'salones' => Room::all(),
        ]);
    }

    public function update(Request $request, Assignment $asignacione)
    {
        $validatedData = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        $asignacione->update($validatedData);
        return redirect('/asignaciones');
    }

    public function destroy(Assignment $asignacione)
    {
        $asignacione->delete();
        return redirect('/asignaciones');
    }

    public function showHorario()
    {
        $days = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        $timeSlots = [];
        for ($hour = 7; $hour <= 21; $hour++) {
            $timeSlots[] = sprintf('%02d:00:00', $hour);
        }
        $assignments = Assignment::with(['group', 'teacher.user', 'room'])->get();
        $horario = [];
        foreach ($assignments as $assignment) {
            $startTime = strtotime($assignment->start_time);
            $endTime = strtotime($assignment->end_time);
            $durationInHours = round(($endTime - $startTime) / 3600);
            $assignment->duration = $durationInHours > 0 ? $durationInHours : 1;
            $startTimeFormatted = date('H:00:00', $startTime);
            $horario[$startTimeFormatted][$assignment->day_of_week] = $assignment;
        }
        return view('horario.show', [
            'days' => $days,
            'timeSlots' => $timeSlots,
            'horario' => $horario,
        ]);
    }
}