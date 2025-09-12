<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Role; // <-- ESTA LÍNEA ES LA CLAVE
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios.
     */
    public function index()
    {
        $usuarios = User::all(); // Obtiene todos los usuarios de la base de datos
        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Role::all(); // Obtenemos todos los roles de la BD
        return view('usuarios.create', ['roles' => $roles]); // Se los pasamos a la vista
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos, incluyendo el role_id
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id', // <-- AÑADE ESTA REGLA
        ]);

        // 2. Crear el usuario con TODOS los datos validados
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => $validatedData['role_id'], // <-- AÑADE ESTA LÍNEA
        ]);

        // 3. Redirigir a la lista de usuarios
        return redirect(route('usuarios.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario) // <-- Laravel inyecta el usuario automáticamente
    {
        $roles = Role::all(); // También necesitamos la lista de roles para el dropdown
        return view('usuarios.edit', [
            'usuario' => $usuario,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario) // Laravel nos da el usuario a actualizar
    {
        // 1. Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // El email debe ser único, pero ignorando al usuario actual
                Rule::unique('users')->ignore($usuario->id),
            ],
            'role_id' => 'required|exists:roles,id',
        ]);

        // 2. Actualizar el usuario en la base de datos
        $usuario->update($validatedData);

        // 3. Redirigir a la lista de usuarios
        return redirect(route('usuarios.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}