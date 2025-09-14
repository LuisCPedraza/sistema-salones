@extends('layouts.app')

@section('content')
    <h1>Gestión de Profesores</h1>
    <a href="{{ route('profesores.create') }}">Crear Nuevo Perfil de Profesor</a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($profesores as $profesor)
                <tr>
                    <td>{{ $profesor->user_id }}</td>
                    <td>{{ $profesor->user->name }}</td>
                    <td>{{ $profesor->user->email }}</td>
                    <td>{{ $profesor->specialty }}</td>
                    <td>
                        <a href="{{ route('profesores.edit', ['profesore' => $profesor]) }}">Editar</a>
                        <form action="{{ route('profesores.destroy', ['profesore' => $profesor]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay perfiles de profesor registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
