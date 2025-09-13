@extends('layouts.app')

@section('content')
    <h1>Gestión de Salones</h1>
    <a href="{{ route('salones.create') }}">Crear Nuevo Salón</a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre/Número</th>
                <th>Ubicación</th>
                <th>Capacidad</th>
                <th>Recursos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salones as $salon)
                <tr>
                    <td>{{ $salon->id }}</td>
                    <td>{{ $salon->name }}</td>
                    <td>{{ $salon->location }}</td>
                    <td>{{ $salon->capacity }}</td>
                    <td>{{ $salon->resources }}</td>
                    <td>
                        </td>
                    <td>
                        <a href="{{ route('salones.edit', $salon) }}">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay salones registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection