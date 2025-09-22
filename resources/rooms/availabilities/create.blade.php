@extends('layouts.app')

@section('content')
<h2>Nueva disponibilidad para {{ $room->name }}</h2>

<form action="{{ route('rooms.availabilities.store', $room) }}" method="POST">
    @csrf
    <label>Día de la semana (1=lunes, 7=domingo):</label>
    <input type="number" name="day_of_week" min="1" max="7" required>

    <label>Hora inicio:</label>
    <input type="time" name="start_time" required>

    <label>Hora fin:</label>
    <input type="time" name="end_time" required>

    <button type="submit">Guardar</button>
</form>
@endsection
