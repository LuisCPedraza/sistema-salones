<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherAvailability;
use Illuminate\Http\Request;

class TeacherAvailabilityController extends Controller
{
    public function index(Teacher $teacher)
    {
        $availabilities = $teacher->availabilities;
        return view('teachers.availabilities.index', compact('teacher', 'availabilities'));
    }

    public function create(Teacher $teacher)
    {
        return view('teachers.availabilities.create', compact('teacher'));
    }

    public function store(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'day_of_week' => 'required|integer|min:1|max:7',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        $teacher->availabilities()->create($data);

        return redirect()->route('teachers.availabilities.index', $teacher)
            ->with('success', 'Disponibilidad agregada correctamente.');
    }

    public function destroy(Teacher $teacher, TeacherAvailability $availability)
    {
        $availability->delete();
        return redirect()->route('teachers.availabilities.index', $teacher)
            ->with('success', 'Disponibilidad eliminada correctamente.');
    }
}
