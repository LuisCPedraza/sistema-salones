@extends('layouts.app')

@section('content')
    <h1>Crear Nueva Asignación</h1>

    {{-- Formulario manual (HU11 – Asignación Manual) --}}
    <form action="{{ route('asignaciones.store') }}" method="POST">
        @csrf
        <div>
            <label for="group_id">Grupo:</label>
            <select name="group_id" id="group_id" required>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="teacher_id">Profesor:</label>
            <select name="teacher_id" id="teacher_id" required>
                @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}">{{ $profesor->user->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="room_id">Salón:</label>
            <select name="room_id" id="room_id" required>
                @foreach ($salones as $salon)
                    <option value="{{ $salon->id }}">{{ $salon->name }} (Cap: {{ $salon->capacity }})</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="day_of_week">Día de la Semana:</label>
            <select name="day_of_week" id="day_of_week" required>
                <option value="lunes">Lunes</option>
                <option value="martes">Martes</option>
                <option value="miércoles">Miércoles</option>
                <option value="jueves">Jueves</option>
                <option value="viernes">Viernes</option>
                <option value="sábado">Sábado</option>
            </select>
        </div>
        <br>
        <div>
            <label for="start_time">Hora de Inicio:</label>
            <input type="time" name="start_time" id="start_time" required>
        </div>
        <br>
        <div>
            <label for="end_time">Hora de Fin:</label>
            <input type="time" name="end_time" id="end_time" required>
        </div>
        <br>
        <button type="submit">Guardar Asignación</button>
    </form>

    <hr>

    {{-- Formulario Autoasignación (HU9 – HU10) --}}
    <h3>Autoasignación de Grupos</h3>
    <form method="POST" action="{{ route('asignaciones.auto') }}">
        @csrf
        <div>
            <label>Duración de clase (horas):</label>
            <input type="number" name="duracion_horas" value="2" min="1" max="6">
        </div>
        <div>
            <label>Hora inicio:</label>
            <input type="time" name="hora_inicio" value="07:00">
            <label>Hora fin:</label>
            <input type="time" name="hora_fin" value="19:00">
        </div>
        <br>
        <button type="submit">Ejecutar Autoasignación</button>
    </form>
@endsection
