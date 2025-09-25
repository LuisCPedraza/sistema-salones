@extends('layouts.app')

@section('content')
    <h1>Editar Grupo: {{ $grupo->name }}</h1>

    <form action="{{ route('grupos.update', $grupo) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nombre del Grupo:</label>
            <input type="text" id="name" name="name" value="{{ $grupo->name }}" required>
        </div>
        <br>
        <div>
            <label for="level">Nivel:</label>
            <input type="text" id="level" name="level" value="{{ $grupo->level }}" required>
        </div>
        <br>
        <div>
            <label for="students_count">Número de Estudiantes:</label>
            <input type="number" id="students_count" name="students_count" value="{{ $grupo->students_count }}" required>
        </div>
        <br>
        <div>
            <label for="special_characteristics">Características Especiales:</label>
            <textarea id="special_characteristics" name="special_characteristics">{{ $grupo->special_characteristics }}</textarea>
        </div>
        <br>
        <button type="submit">Actualizar Grupo</button>
    </form>
@endsection