<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario: {{ $usuario->name }}</h1>

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT') <div>
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
</body>
</html>