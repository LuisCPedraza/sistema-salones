@extends('layouts.app')

@section('content')
    <h1>Crear Nuevo Salón</h1>

    <form action="{{ route('salones.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nombre/Número del Salón:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <br>
        <div>
            <label for="location">Ubicación:</label>
            <input type="text" id="location" name="location" required>
        </div>
        <br>
        <div>
            <label for="capacity">Capacidad:</label>
            <input type="number" id="capacity" name="capacity" required>
        </div>
        <br>
        <div>
            <label for="resources">Recursos (separados por comas):</label>
            <textarea id="resources" name="resources"></textarea>
        </div>
        <br>
        <button type="submit">Guardar Salón</button>
    </form>
@endsection