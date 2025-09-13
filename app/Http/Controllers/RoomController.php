<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salones = Room::all();
        return view('salones.index', ['salones' => $salones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('salones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'resources' => 'nullable|string',
        ]);

        // 2. Crear
        Room::create($validatedData);

        // 3. Redirigir
        return redirect('/salones');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $salone)
    {
        return view('salones.edit', ['salon' => $salone]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $salone)
    {
        // 1. Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'resources' => 'nullable|string',
        ]);

        // 2. Actualizar el salón en la base de datos
        $salone->update($validatedData);

        // 3. Redirigir
        return redirect('/salones');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
