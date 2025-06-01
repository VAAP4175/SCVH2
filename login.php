<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form action="verificar_login.php" method="post">
        <div class="logo-container">
            <img src="login_logo.png" alt="Logo INTERCALA" class="logo">
        </div>

        <h2>Iniciar sesión</h2>

        <label for="usuario"></label>
        <input type="text" name="usuario" id="usuario" placeholder="👤 Usuario:" required><br><br>

        <label for="contrasena"></label>
        <input type="password" name="contrasena" id="contrasena" placeholder="🔒 Contraseña:" required><br><br>

        <input type="submit" value="Ingresar">
    </form>
</body>
</html>

