<?php
include('conexion.php');
//Consulta los datos de la tabla en la base de datos
$sql="SELECT id_admin,nombre_completo,usuario FROM administradores";
$result=$conn->query($sql);//almacena la consulta
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="tabla.css">
    <link rel="stylesheet" href="menu_adm.css">
</head>
<!------------------------------------------------->
<body>
<header>
<h2>Lista de Usuarios</h2>
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
<!------------------------------------------------->
<main>
<section class="secregistroG">
<!------------------------------------------------->
<form action="buscar.php" method="post">
<label for="filtro">Buscar por:</label>
<select name="filtro" id="">
    <option value="id_admin">ID</option>
    <option value="nombre">Nombre</option>
</select>
<input type="text" name="buscar" placeholder="Buscar..." required>
<input type="submit" value="buscar">
<button type="submit" onclick="window.location.href='adm_registro.php'">Registar usuario</button>
</form>
</section>
<!------------------------------------------------>
<section>
<table>
<tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th colspan="2">Acciones</th><!--Colspan son las columnas que utiliza-->
</tr>
<?php
    if ($result->num_rows>0) {
    while($row=$result->fetch_assoc()){
        echo"<tr>
        <td>".$row['id_admin']."</td>
        <td>".$row['nombre_completo']."</td>
        <td>".$row['usuario']."</td>
        <td><a href='eliminar.php?id=".$row['id_admin']."'>Eliminar</a>
        <td><a href='actualizar.php?id=".$row['id_admin']."'>Actualizar</a>
        </tr>";
        }
    }
?>
</table>
</section>
</main>
<footer>UICSLP © 2025 </footer>
</body>
</html>