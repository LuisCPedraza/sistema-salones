@extends('layouts.app')

@section('content')
    <h1>Gestión de Asignaciones</h1>
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
                    <td>{{ $asignacion->start_time }} - {{ $asignacion->end_time }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay asignaciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
