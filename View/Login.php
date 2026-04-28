<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css"> 
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <!-- FORMULARIO REAL QUE ENVÍA AL CONTROLADOR -->
        <form class="login-form" method="POST" action="../../Controller/UserController/UserController.php">

            <div class="login-form-group">
                <label class="login-label">Correo electrónico</label>
                <input type="email" class="login-input" name="email" required>
            </div>

            <div class="login-form-group">
                <label class="login-label">Contraseña</label>
                <input type="password" class="login-input" name="password" required>
            </div>

            <button type="submit" name="Login" class="login-submit-btn">
                Iniciar Sesión
            </button>

            <button type="submit" name="Register" class="login-submit-btn">
                ¡Regístrate aquí!
            </button>

            <a href="Registro.html" class="login-forgot">
                ¿Has olvidado la contraseña?
            </a>

        </form>
    </div>
</body>
</html>
