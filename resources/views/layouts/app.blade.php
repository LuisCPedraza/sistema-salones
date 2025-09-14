<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Salones</title>
    {{-- Aquí podríamos añadir CSS en el futuro --}}
</head>
<body>
    <nav>
        <a href="{{ route('usuarios.index') }}">Gestionar Usuarios</a> |
        <a href="{{ route('grupos.index') }}">Gestionar Grupos</a>
        <a href="{{ route('salones.index') }}">Gestionar Salones</a> {{-- <-- AÑADE ESTO --}}
        <a href="{{ route('profesores.index') }}">Gestionar Profesores</a> {{-- <-- AÑADE ESTO --}}
    </nav>
    <hr>
    <main>
        @yield('content')
    </main>
</body>
</html>
