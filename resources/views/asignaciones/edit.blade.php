@extends('layouts.app')

@section('content')
    <h1>Editar Asignación</h1>
    <form action="{{ route('asignaciones.update', ['asignacione' => $asignacione]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Aquí va el resto del formulario, es idéntico al de creación pero con valores preseleccionados --}}
        {{-- Te lo dejo como un reto final para que lo adaptes del formulario de creación. --}}
        {{-- Si te quedas atascado, ¡házmelo saber! --}}

        <button type="submit">Actualizar Asignación</button>
    </form>
@endsection
