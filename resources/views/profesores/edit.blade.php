@extends('layouts.app')

@section('content')
    <h1>Editar Perfil de: {{ $profesor->user->name }}</h1>

    <form action="{{ route('profesores.update', ['profesore' => $profesor]) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Usuario:</label>
            <strong>{{ $profesor->user->name }}</strong>
        </div>
        <br>
        <div>
            <label for="specialty">Especialidad:</label>
            <input type="text" id="specialty" name="specialty" value="{{ $profesor->specialty }}" required>
        </div>
        <br>
        <div>
            <label for="bio">Biografía / Hoja de Vida:</label>
            <textarea id="bio" name="bio">{{ $profesor->bio }}</textarea>
        </div>
        <br>
        <button type="submit">Actualizar Perfil</button>
    </form>
@endsection
