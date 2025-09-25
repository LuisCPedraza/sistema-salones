@extends('layouts.app')

@section('content')
    <h1>Horario del Salón: {{ $room->name ?? 'Sala '.$room->id }}</h1>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Día</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Grupo</th>
                <th>Profesor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asigs as $a)
                <tr>
                    <td>{{ ucfirst($a->day_of_week) }}</td>
                    <td>{{ $a->start_time }}</td>
                    <td>{{ $a->end_time }}</td>
                    <td>{{ $a->group->name ?? 'Grupo '.$a->group_id }}</td>
                    <td>{{ $a->teacher->user->name ?? 'Profesor '.$a->teacher_id }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay asignaciones para este salón.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
