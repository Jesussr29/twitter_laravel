<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Editar Publicación</h1>
        <form action="{{ route('publicacion.update', $publicacion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="contenido" required>{{ $publicacion->contenido }}</textarea>
            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>
</html>