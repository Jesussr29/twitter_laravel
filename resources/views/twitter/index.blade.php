<!DOCTYPE html>
<html lang="es" class="light-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Twitter</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <input type="text" id="searchBox" class="form-control me-2" placeholder="Buscar usuario..." onkeyup="buscarUsuario()"><br>
            
                <form action="{{ route('publicacion.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="contenido" class="form-control" placeholder="¿Qué estás pensando?" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                </form>

                <div class="publicaciones mt-4">
                    @foreach ($publicaciones as $publicacion)
                        <div class="card mb-3 publicacion" id="publicacion-{{ $publicacion->id }}" data-usuario="{{ strtolower($publicacion->usuario->name) }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $publicacion->usuario->name }}</h5>
                                <p class="card-text">{{ $publicacion->contenido }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            // Manejar el cambio de tema
            const themeToggle = document.getElementById('theme-toggle');
            const currentTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.className = currentTheme + '-theme';

            themeToggle.addEventListener('click', () => {
                let theme = document.documentElement.className.includes('light') ? 'dark' : 'light';
                document.documentElement.className = theme + '-theme';
                localStorage.setItem('theme', theme);
            });
        });
        
    function buscarUsuario() {
        const query = document.getElementById('searchBox').value.toLowerCase();
        const publicaciones = document.querySelectorAll('.publicacion');
        const paginationNav = document.getElementById('paginationNav'); // Obtener el contenedor de la paginación

        let hayCoincidencias = false;

        // Filtrar las publicaciones
        publicaciones.forEach(publicacion => {
            const usuario = publicacion.getAttribute('data-usuario').toLowerCase();
            if (usuario.includes(query)) {
                publicacion.style.display = 'block';
                hayCoincidencias = true;
            } else {
                publicacion.style.display = 'none';
            }
        });

        // Ocultar la paginación si hay búsqueda activa, mostrarla si no hay búsqueda
        if (query.trim() !== "" && hayCoincidencias) {
            paginationNav.classList.add('d-none');
        } else {
            paginationNav.classList.remove('d-none');
        }
    }

    </script>
</body>
</html>