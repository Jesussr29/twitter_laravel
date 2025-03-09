<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Twitter</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Mi Twitter</h1>
        
        <!-- Mensaje de bienvenida y botón para cerrar sesión -->
        <div style="text-align: right;">
            <p>Bienvenido, {{ Auth::user()->name }}!</p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background-color: red; color: white; border: none; padding: 10px 20px; cursor: pointer;">Cerrar sesión</button>
            </form>
        </div>

        <form action="{{ route('publicacion.store') }}" method="POST">
            @csrf
            <textarea name="contenido" placeholder="¿Qué estás pensando?" required></textarea>
            <button type="submit">Publicar</button>
        </form>
        
        <div class="publicaciones">
            @foreach ($publicaciones as $publicacion)
                <div class="publicacion" id="publicacion-{{ $publicacion->id }}">
                    <p><strong>{{ $publicacion->usuario->name }}:</strong></p>
                    <p>{{ $publicacion->contenido }}</p>
                    <p>
                        <button class="like-button" data-id="{{ $publicacion->id }}">👍 <span class="like-count">{{ $publicacion->likes }}</span></button>
                        <button class="retweet-button" data-id="{{ $publicacion->id }}">🔁 <span class="retweet-count">{{ $publicacion->retweet }}</span></button>
                    </p>
                    @if ($publicacion->id_usuario == Auth::id())
                        <a href="{{ route('publicacion.edit', $publicacion->id) }}">Editar</a>
                        <form action="{{ route('publicacion.destroy', $publicacion->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        $(document).ready(function() {
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
        });
    </script>
</body>
</html>