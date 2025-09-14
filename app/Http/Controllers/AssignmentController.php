<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;     // <-- Añadir/Verificar esta línea
use App\Models\Teacher;   // <-- Añadir/Verificar esta línea
use App\Models\Room;      // <-- Añadir/Verificar esta línea
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carga anticipada de relaciones para optimizar consultas
        $asignaciones = Assignment::with(['group', 'teacher', 'room'])->get();
        return view('asignaciones.index', ['asignaciones' => $asignaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtenemos todos los recursos para los menús desplegables del formulario
        $grupos = Group::all();
        $profesores = Teacher::with('user')->get();
        $salones = Room::all();

        return view('asignaciones.create', [
            'grupos' => $grupos,
            'profesores' => $profesores,
            'salones' => $salones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos
        $validatedData = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // 2. Crear la asignación
        Assignment::create($validatedData);

        // 3. Redirigir
        return redirect('/asignaciones');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
