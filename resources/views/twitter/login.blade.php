<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="black"></div>
    <div class="login-container">

        <div class="foto">
            <img src="{{ asset('img/logo.png') }}" alt="">
        </div>
        <h2>Iniciar sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required autofocus>
                @error('email')
                    <span class="error">Nombre de usuario o contraseña incorrectos</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error">Contraseña incorrecta</span>
                @enderror
            </div>

            <button type="submit">Iniciar sesión</button>
        </form>

        <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
    </div>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    background-image: url("{{ asset('img/fondo.gif') }}");
    background-position: center;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
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

.login-container {
    background-color: rgba(255, 255, 255, 0.71);
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    z-index: 1001;
    padding: 30px 20px;

}

.foto{
    display: flex;
    width: 100%;
    justify-content: center;
}

.foto img{
    max-width: 100px;

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

input[type="email"],
input[type="password"] {
    width: 93%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 99%;
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