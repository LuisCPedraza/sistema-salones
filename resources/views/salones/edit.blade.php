@extends('layouts.app')

@section('content')
    <h1>Editar Salón: {{ $salon->name }}</h1>

    <form action="{{ route('salones.update', ['salone' => $salon]) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nombre/Número del Salón:</label>
            <input type="text" id="name" name="name" value="{{ $salon->name }}" required>
        </div>
        <br>
        <div>
            <label for="location">Ubicación:</label>
            <input type="text" id="location" name="location" value="{{ $salon->location }}" required>
        </div>
        <br>
        <div>
            <label for="capacity">Capacidad:</label>
            <input type="number" id="capacity" name="capacity" value="{{ $salon->capacity }}" required>
        </div>
        <br>
        <div>
            <label for="resources">Recursos (separados por comas):</label>
            <textarea id="resources" name="resources">{{ $salon->resources }}</textarea>
        </div>
        <br>
        <button type="submit">Actualizar Salón</button>
    </form>
@endsection
