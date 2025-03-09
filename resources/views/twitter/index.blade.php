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
            --nav-bg-color: lightgray;
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
        .navbar, .btn {
            background-color: var(--nav-bg-color);
        }
        .btn, .btn-outline-primary, .btn-outline-success, .btn-warning, .btn-danger {
            color: var(--button-text-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mi Twitter</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text">Bienvenido, {{ Auth::user()->name }}!</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger ms-3">Cerrar sesión</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <button id="theme-toggle" class="btn btn-secondary ms-3">Cambiar tema</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('publicacion.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="contenido" class="form-control" placeholder="¿Qué estás pensando?" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                </form>

                <div class="publicaciones mt-4">
                    @foreach ($publicaciones as $publicacion)
                        <div class="card mb-3" id="publicacion-{{ $publicacion->id }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $publicacion->usuario->name }}</h5>
                                <p class="card-text">{{ $publicacion->contenido }}</p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button class="btn btn-outline-primary like-button" data-id="{{ $publicacion->id }}">👍 <span class="like-count">{{ $publicacion->likes }}</span></button>
                                        <button class="btn btn-outline-success retweet-button" data-id="{{ $publicacion->id }}">🔁 <span class="retweet-count">{{ $publicacion->retweet }}</span></button>
                                    </div>
                                    @if ($publicacion->id_usuario == Auth::id())
                                        <div>
                                            <a href="{{ route('publicacion.edit', $publicacion->id) }}" class="btn btn-warning">Editar</a>
                                            <form action="{{ route('publicacion.destroy', $publicacion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
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
            // Manejar los likes
            $('.like-button').click(function() {
                var publicacionId = $(this).data('id');
                var likeButton = $(this);
                $.ajax({
                    url: '/publicacion/' + publicacionId + '/like',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        likeButton.find('.like-count').text(response.likes);
                    }
                });
            });

            // Manejar los retweets
            $('.retweet-button').click(function() {
                var publicacionId = $(this).data('id');
                var retweetButton = $(this);
                $.ajax({
                    url: '/publicacion/' + publicacionId + '/retweet',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        retweetButton.find('.retweet-count').text(response.retweets);
                    }
                });
            });

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
    </script>
</body>
</html>