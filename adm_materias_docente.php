<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "conexion.php";

// Obtener solicitudes de materias pendientes con la tabla `maestros`
$sql = "
    SELECT mm.id, m.nombre_completo AS docente, ma.nombre_materia
    FROM maestros_materias_perfil mm
    JOIN maestros m ON mm.id_maestro = m.id_maestro
    JOIN materias ma ON mm.id_materia = ma.id_materia
    WHERE mm.estado = 'pendiente'
";

$solicitudes = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aprobación de Materias</title>
    <link rel="stylesheet" href="tabla.css">
    <link rel="stylesheet" href="menu_adm.css">
   <style>
    main h2{
      text-align: center;
      font-family: Arial, Helvetica, sans-serif;
      color: blue;
    }
   </style>
</head>
<body>
 <header> <h2>Solicidut de materias</h2></header>
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
        <h2>Solicitudes de Materias</h2>
        <table>
            <tr>
                <th>Docente</th>
                <th>Materia</th>
                <th colspan="2">Acciones</th>
            </tr>
            <?php while ($fila = $solicitudes->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['docente']) ?></td>
                    <td><?= htmlspecialchars($fila['nombre_materia']) ?></td>
                    <td>
                        <a href="gestionar_materia.php?id=<?= $fila['id'] ?>&accion=aprobado">Aprobar</a>
                        <a href="gestionar_materia.php?id=<?= $fila['id'] ?>&accion=rechazado">Rechazar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>


  <h2>Materias Asignadas</h2>
<table>
    <tr>
        <th>Docente</th>
        <th>Materia</th>
        <th colspan="2">Acciones</th>
    </tr>
    <?php
    $materias_aprobadas = $conn->query("
        SELECT mm.id, m.nombre_completo AS docente, ma.nombre_materia
        FROM maestros_materias_perfil mm
        JOIN maestros m ON mm.id_maestro = m.id_maestro
        JOIN materias ma ON mm.id_materia = ma.id_materia
        WHERE mm.estado = 'aprobado'
    ");

    while ($fila = $materias_aprobadas->fetch_assoc()):
    ?>
    <tr>
        <td><?= htmlspecialchars($fila['docente']) ?></td>
        <td><?= htmlspecialchars($fila['nombre_materia']) ?></td>
        <td>
            <a href="editar_materia.php?id=<?= $fila['id'] ?>">Editar</a>
            <a href="gestionar_materia.php?id=<?= $fila['id'] ?>&accion=rechazado">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
    
</table>
</main>
<footer>UICSLP © 2025 </footer>
</body>
</html>
