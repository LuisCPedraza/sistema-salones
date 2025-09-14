@extends('layouts.app')

@section('content')
    <h1>Editar Usuario: {{ $usuario->name }}</h1>

    {{-- Bloque para mostrar errores de validación --}}
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <strong>¡Ups! Hubo algunos problemas con tu entrada.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ $usuario->name }}" required>
        </div>
        <br>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $usuario->email }}" required>
        </div>
        <br>
        <div>
            <label for="role_id">Rol:</label>
            <select name="role_id" id="role_id" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $usuario->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        <button type="submit">Actualizar Usuario</button>
    </form>
@endsection
