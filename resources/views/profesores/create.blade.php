@extends('layouts.app')

@section('content')
    <h1>Crear Perfil de Profesor</h1>

    <form action="{{ route('profesores.store') }}" method="POST">
        @csrf
        <div>
            <label for="user_id">Usuario (Profesor):</label>
            <select name="user_id" id="user_id" required>
                <option value="">Seleccione un usuario</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="specialty">Especialidad:</label>
            <input type="text" id="specialty" name="specialty" required>
        </div>
        <br>
        <div>
            <label for="bio">Biografía / Hoja de Vida:</label>
            <textarea id="bio" name="bio"></textarea>
        </div>
        <br>
        <button type="submit">Guardar Perfil</button>
    </form>
@endsection
@extends('layouts.app')

@section('content')
    <h1>Crear Perfil de Profesor</h1>

    <form action="{{ route('profesores.store') }}" method="POST">
        @csrf
        <div>
            <label for="user_id">Usuario (Profesor):</label>
            <select name="user_id" id="user_id" required>
                <option value="">Seleccione un usuario</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="specialty">Especialidad:</label>
            <input type="text" id="specialty" name="specialty" required>
        </div>
        <br>
        <div>
            <label for="bio">Biografía / Hoja de Vida:</label>
            <textarea id="bio" name="bio"></textarea>
        </div>
        <br>
        <button type="submit">Guardar Perfil</button>
    </form>
@endsection
