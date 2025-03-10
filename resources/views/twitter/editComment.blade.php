<!DOCTYPE html>
<html lang="es" class="light-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comentario</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://cdn.iconscout.com/icon/free/png-256/free-twitter-logo-icon-download-in-svg-png-gif-file-formats--social-media-pack-logos-icons-721979.png?f=webp&w=256" type="image/x-icon">

</head>
<style>
        /* Estilos para el tema claro y oscuro */
        .light-theme {
            --bg-color: white;
            --text-color: black;
            --card-bg-color: white;
            --nav-bg-color: #f8f9fa;
            --card-text-color: black;
            --button-text-color: black;
        }
        .dark-theme {
            --bg-color: #121212;
            --text-color: white;
            --card-bg-color: #1e1e1e;
            --nav-bg-color: #333;
            --card-text-color: white;
            --button-text-color: white;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .card {
            background-color: var(--card-bg-color);
            color: var(--card-text-color);
        }
        .navbar {
            background-color: var(--nav-bg-color);
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }
        .navbar-toggler {
            border: none;
        }
        .navbar-text {
            font-size: 1rem;
            color: var(--text-color);
        }
        .btn {
            border-radius: 20px;
            padding: 8px 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mi Twitter</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <span class="navbar-text me-3">Bienvenido, {{ Auth::user()->name }}!</span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('publicacion.index') }}" class="btn btn-outline-primary me-2">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile') }}" class="btn btn-outline-success me-2">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger me-2">Cerrar sesión</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <button id="theme-toggle" class="btn btn-secondary">Cambiar tema</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>Editar Comentario</h2>
                <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="3" required>{{ $comment->content }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Comentario</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Obtener el tema guardado en localStorage o establecer 'light' por defecto
        let currentTheme = localStorage.getItem("theme") || "light";
        document.documentElement.classList.remove("light-theme", "dark-theme"); // Eliminar clases previas
        document.documentElement.classList.add(currentTheme + "-theme"); // Aplicar tema actual

        // Manejar el botón de cambio de tema
        const themeToggle = document.getElementById("theme-toggle");
        themeToggle.addEventListener("click", () => {
            let newTheme = document.documentElement.classList.contains("light-theme") ? "dark" : "light";
            document.documentElement.classList.remove("light-theme", "dark-theme");
            document.documentElement.classList.add(newTheme + "-theme");
            localStorage.setItem("theme", newTheme);
        });
    });
</script>

</body>
</html>