<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos = Group::all();
        return view('grupos.index', ['grupos' => $grupos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grupos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'students_count' => 'required|integer',
            'special_characteristics' => 'nullable|string',
        ]);

        // 2. Crear el grupo
        Group::create($validatedData);

        // 3. Redirigir
        return redirect('/grupos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $grupo) // Usamos Route Model Binding de nuevo
    {
        return view('grupos.edit', ['grupo' => $grupo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $grupo)
    {
        // 1. Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'students_count' => 'required|integer',
            'special_characteristics' => 'nullable|string',
        ]);

        // 2. Actualizar el grupo en la base de datos
        $grupo->update($validatedData);

        // 3. Redirigir
        return redirect('/grupos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
    }
}
