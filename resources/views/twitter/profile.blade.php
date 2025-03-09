<!DOCTYPE html>
<html lang="es" class="light-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
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
                <h2>Publicaciones de {{ $usuario->name }}</h2>
                <div class="publicaciones mt-4">
                    @foreach ($publicaciones as $publicacion)
                        <div class="card mb-3" id="publicacion-{{ $publicacion->id }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $publicacion->usuario->name }}</h5>
                                <p class="card-text">{{ $publicacion->contenido }}</p>
                                <div class="d-flex justify-content-between">
                                    @if ($publicacion->id_usuario == Auth::id())
                                        <div>
                                            <a href="{{ route('publicacion.edit', $publicacion->id) }}" class="btn btn-outline-warning">Editar</a>
                                            <form action="{{ route('publicacion.destroy', $publicacion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Comment Section -->
                                <div class="comments mt-3">
                                    @foreach ($publicacion->comments as $comment)
                                        <div class="comment mb-2">
                                            <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add Comment Form -->
                                <form action="{{ route('comments.store', $publicacion->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea name="content" class="form-control" placeholder="Añade tu respuesta..." rows="2" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Responder</button>
                                </form>
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