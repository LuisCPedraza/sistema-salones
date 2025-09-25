<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User; // <-- Importar User
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carga los profesores y su relación con 'user' para evitar consultas N+1
        $profesores = Teacher::with('user')->get();
        return view('profesores.index', ['profesores' => $profesores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtenemos solo los usuarios con el rol 'profesor' que aún no tienen un perfil de profesor creado
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'profesor');
        })->whereDoesntHave('teacher')->get();

        return view('profesores.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id|unique:teachers',
            'specialty' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // 2. Crear el perfil del profesor
        Teacher::create($validatedData);

        // 3. Redirigir
        return redirect('/profesores');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $profesore)
    {
        $validatedData = $request->validate([
            'specialty' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $profesore->update($validatedData);

        return redirect('/profesores');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $profesore)
    {
        // Primero, borramos el perfil del profesor
        $profesore->delete();

        // Opcional: También podríamos borrar el usuario asociado si quisiéramos
        // $profesore->user->delete();

        return redirect('/profesores');
    }
}
