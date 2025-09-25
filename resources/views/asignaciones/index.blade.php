@extends('layouts.app')

@section('content')
    <h1>Gestión de Asignaciones</h1>
    <a href="{{ route('horario.show') }}" style="font-weight: bold; margin-bottom: 1em; display: inline-block;">Ver Horario Semanal</a>
    <br>
    <a href="{{ route('asignaciones.create') }}">Crear Nueva Asignación</a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Profesor</th>
                <th>Salón</th>
                <th>Día</th>
                <th>Horario</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asignaciones as $asignacion)
                <tr>
                    <td>{{ $asignacion->group->name }}</td>
                    <td>{{ $asignacion->teacher->user->name }}</td>
                    <td>{{ $asignacion->room->name }}</td>
                    <td>{{ $asignacion->day_of_week }}</td>
                    <td>{{ date('h:i A', strtotime($asignacion->start_time)) }} - {{ date('h:i A', strtotime($asignacion->end_time)) }}</td>
                    <td>
                        <a href="{{ route('asignaciones.edit', ['asignacione' => $asignacion]) }}">Editar</a>
                        <form action="{{ route('asignaciones.destroy', ['asignacione' => $asignacion]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay asignaciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
