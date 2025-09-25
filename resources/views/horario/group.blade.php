@extends('layouts.app')

@section('content')
    <h1>Horario del Grupo: {{ $group->name ?? 'Grupo '.$group->id }}</h1>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Día</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Profesor</th>
                <th>Salón</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asigs as $a)
                <tr>
                    <td>{{ ucfirst($a->day_of_week) }}</td>
                    <td>{{ $a->start_time }}</td>
                    <td>{{ $a->end_time }}</td>
                    <td>{{ $a->teacher->user->name ?? 'Profesor '.$a->teacher_id }}</td>
                    <td>{{ $a->room->name ?? 'Sala '.$a->room_id }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay asignaciones para este grupo.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
