<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="menu_adm.css">
    <link rel="stylesheet" href="actualizar">
</head>
<body>
<header>
<h2>Registro de usuarios</h2>
</header>

<aside class="sidebar">
    <ul class="menu">
        <li class="active" onclick="window.location.href='inicio_adm.php'"><i>🏠</i>Inicio</li>
        <li class="submenu">
            <i>👤</i>Usuarios
            <ul class="submenu-list">
                <li onclick="window.location.href='adm_usuarios.php'"><i>🔐</i>Administrador</li>
                <li onclick="window.location.href='adm_docentes.php'"><i>🖊️</i>Docentes</li>
                <li onclick="window.location.href='adm_alumnos.php'"><i>🎓</i>Alumnos</li>
            </ul>
        </li>

        <li onclick="window.location.href='adm_grupos.php'"><i>📜</i>Grupos</li>
        <li class="submenu">
            <i>📄</i>Horarios
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_horarios.php'"><i>📝</i>Horarios Alumnos</li>
        <li onclick="window.location.href='adm_horarios_D.php'"><i>📑</i>Horarios Docentes</li>
          </ul>
        </li>

        <li class="submenu">
            <i>📚</i>Materias
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_materias.php'"><i>📘</i>Materias</li>
        <li onclick="window.location.href='configurar_horas.php'"><i>⏱</i>Horas por semana</li>
        <li onclick="window.location.href='adm_materias_docente.php'"><i>🗳</i>Solicitud Materias</li>
          </ul>
        </li>
        <li onclick="window.location.href='panel_admin.php'"><i>📂</i>Calificaciones</li>
        <li onclick="window.location.href='index.php'"><i>🔙</i>Salir</li>
    </ul>
</aside>
<main>
<section class="registro">
        <form action="" method="post">
    <input type="text" name="usuario" placeholder="Usuario" required> <br><br>
    <input type="text" id="nombre" name="name" placeholder="Nombre" required> <br><br>
    <input type="email" id="edad" name="email" placeholder="Correo" required> <br><br>
    <input type="password" id="cedula" name="password" placeholder="Contraseña" required> <br><br>
    <button type="submit">Registrar</button>
    <button type="button" onclick="window.location.href='adm_usuarios.php'">Regresar</button>
                        <?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['usuario'])) {
        $name = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];

        $sql = "INSERT INTO administradores (nombre_completo, correo, usuario, contrasena) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $usuario, $password);
            if ($stmt->execute()) {
                echo "<br><br>Datos ingresados correctamente. <a href='adm_usuarios.php'>Regresar</a>";
            } else {
                echo "<br><br>Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "<br><br>Error en la preparación de la consulta: " . $conn->error;
        }
    }
}

$conexion->close();
?>

        </form>
    </section>
    </main>
    <footer>UICSLP © 2025 </footer>
</body>
</html>