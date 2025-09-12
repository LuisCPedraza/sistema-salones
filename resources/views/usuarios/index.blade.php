<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <a href="/usuarios/create">Crear Nuevo Usuario</a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td> 
                        <a href="{{ route('usuarios.edit', $usuario) }}">Editar</a>

                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar a este usuario?')">Eliminar</button>
                        </form> 
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>