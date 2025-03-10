<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="shortcut icon" href="https://cdn.iconscout.com/icon/free/png-256/free-twitter-logo-icon-download-in-svg-png-gif-file-formats--social-media-pack-logos-icons-721979.png?f=webp&w=256" type="image/x-icon">
</head>
<body>
    <div class="black"></div>
    <div class="register-container">

        <div class="foto">
            <img src="{{ asset('img/logo.png') }}" alt="">
        </div>

        <h2>Registrarse</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error">Correo electronico ya registrado</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error">La contraseña debe tener minimo 8 caracteres</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password')
                    <span class="error">Las contraseñas no coinciden</span>
                @enderror
            </div>

            <button type="submit">Registrar</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
    </div>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-image: url("{{ asset('img/fondo.gif') }}");
    background-position: center;
    background-size: cover;
}

.black{
    position: absolute;
    background-color: black;
    opacity: 40%;
    width: 100%;
    height: 100vh;
    z-index: 1000;
}

.logo{
    z-index: 1002;
    background-color: rgba(255, 255, 255, 0.36);
    padding: 50px;
    border-radius: 15px;
}

.register-container {
    background-color: rgba(255, 255, 255, 0.71);
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    z-index: 1001;
}

.foto img{
    max-width: 100px;

}

.foto{
    display: flex;
    width: 100%;
    justify-content: center;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 95%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.error {
    color: red;
    font-size: 12px;
}

p {
    text-align: center;
}

a {
    color: #007bff;
}

a:hover {
    text-decoration: underline;
}
</style>