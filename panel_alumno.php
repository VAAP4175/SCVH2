<?php
session_start();

if (!isset($_SESSION['id_alumno'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';

$id_alumno = $_SESSION['id_alumno'];
$nombre = $_SESSION['nombre_completo'] ?? 'Alumno';

// Obtener grupo
$sql_grupo = "SELECT g.nombre_grupo 
              FROM alumnos a
              JOIN grupos g ON a.id_grupo = g.id_grupo
              WHERE a.id_alumno = ?";
$stmt_grupo = $conn->prepare($sql_grupo);
$stmt_grupo->bind_param("i", $id_alumno);
$stmt_grupo->execute();
$res_grupo = $stmt_grupo->get_result();
$grupo = $res_grupo->fetch_assoc()['nombre_grupo'] ?? 'Desconocido';

// Obtener calificaciones
$sql = "SELECT m.nombre_materia, c.parcial, c.calificacion
        FROM calificaciones c
        JOIN materias m ON c.id_materia = m.id_materia
        WHERE c.id_alumno = ?
        ORDER BY m.nombre_materia, c.parcial";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$res = $stmt->get_result();

$calificaciones = [];
while ($row = $res->fetch_assoc()) {
    $materia = $row['nombre_materia'];
    $parcial = $row['parcial'];
    $nota = $row['calificacion'];
    $calificaciones[$materia][$parcial] = $nota;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Alumno</title>
    <link rel="stylesheet" href="panel_alumno.css">
</head>
<body>

<div class="logo-container">
    <img src="login_logo.png" alt="Logo Intercala" class="logo">
</div>

    <h2>🎓 Bienvenido, <?php echo htmlspecialchars($nombre); ?></h2>
    <h3>📘 Grupo: <?php echo htmlspecialchars($grupo); ?></h3>

     <!-- Botones con emojis -->
     <div class="botones-acciones">
    <form action="generar_pdf.php" method="post" style="display:inline;">
        <button type="submit">📄 Descargar PDF</button>
    </form>

    <form action="panel_general_alumno.php" method="post" style="display:inline; margin-left:10px;">
        <button type="submit">⬅ Volver al Panel </button>
    </form>

    <form action="logout.php" method="post" style="display:inline; margin-left:10px;">
        <button type="submit">🚪 Cerrar Sesión</button>
    </form>
</div><br>

    <p>📑 A continuación puedes consultar tus calificaciones por parcial:</p>
    <table border="1" cellpadding="5">
        <tr>
            <th>Materia</th>
            <th>1° Parcial</th>
            <th>2° Parcial</th>
            <th>3° Parcial</th>
            <th>Final</th>
        </tr>
        <?php foreach ($calificaciones as $materia => $parciales): 
            $p1 = $parciales[1] ?? null;
            $p2 = $parciales[2] ?? null;
            $p3 = $parciales[3] ?? null;
            $promedio = is_numeric($p1) && is_numeric($p2) && is_numeric($p3) ? round(($p1 + $p2 + $p3) / 3, 2) : '-';
        ?>
        <tr>
            <td><?php echo htmlspecialchars($materia); ?></td>
            <td><?php echo $p1 ?? '-'; ?></td>
            <td><?php echo $p2 ?? '-'; ?></td>
            <td><?php echo $p3 ?? '-'; ?></td>
            <td><?php echo $promedio; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br><hr><br>

</body>
</html>
