@extends('layouts.app')

@section('content')
<h2>Disponibilidad del salón: {{ $room->name }}</h2>
<a href="{{ route('rooms.availabilities.create', $room) }}">Agregar disponibilidad</a>

<table>
    <tr>
        <th>Día</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Acciones</th>
    </tr>
    @foreach($availabilities as $a)
    <tr>
        <td>{{ $a->day_of_week }}</td>
        <td>{{ $a->start_time }}</td>
        <td>{{ $a->end_time }}</td>
        <td>
            <form action="{{ route('availabilities.destroy', $a) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
