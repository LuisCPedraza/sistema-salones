@extends('layouts.app')

@section('content')
    <h1>Gestión de Grupos</h1>
    <a href="{{ route('grupos.create') }}">Crear Nuevo Grupo</a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Grupo</th>
                <th>Nivel</th>
                <th>N° Estudiantes</th>
                <th>Características Especiales</th> <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grupos as $grupo)
                <tr>
                    <td>{{ $grupo->id }}</td>
                    <td>{{ $grupo->name }}</td>
                    <td>{{ $grupo->level }}</td>
                    <td>{{ $grupo->students_count }}</td>
                    <td>{{ $grupo->special_characteristics }}</td> <td>
                        <a href="{{ route('grupos.edit', $grupo) }}">Editar</a>
                        <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este grupo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay grupos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection