<!DOCTYPE html>
<html>
<head>
    <title>Crear Grupo</title>
</head>
<body>
    <h1>Crear Nuevo Grupo</h1>

    <form action="{{ route('grupos.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nombre del Grupo:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <br>
        <div>
            <label for="level">Nivel:</label>
            <input type="text" id="level" name="level" required>
        </div>
        <br>
        <div>
            <label for="students_count">Número de Estudiantes:</label>
            <input type="number" id="students_count" name="students_count" required>
        </div>
        <br>
        <div>
            <label for="special_characteristics">Características Especiales:</label>
            <textarea id="special_characteristics" name="special_characteristics"></textarea>
        </div>
        <br>
        <button type="submit">Guardar Grupo</button>
    </form>
</body>
</html>