<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

$id_maestro = $_SESSION['id_maestro'];
$nombre_maestro = $_SESSION['nombre_completo'] ?? 'Maestro';

$sql = "
SELECT g.nombre_grupo, m.nombre_materia, c.parcial, COUNT(c.id_calificacion) AS total_calificaciones
FROM calificaciones c
JOIN materias m ON c.id_materia = m.id_materia
JOIN grupos g ON c.id_grupo = g.id_grupo
JOIN maestros_materias_grupos mmg ON mmg.id_materia = c.id_materia AND mmg.id_grupo = c.id_grupo
WHERE mmg.id_maestro = ?
GROUP BY g.nombre_grupo, m.nombre_materia, c.parcial
ORDER BY g.nombre_grupo, m.nombre_materia, c.parcial;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_maestro);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Calificaciones</title>
    <link rel="stylesheet" href="historial_calificaciones.css">
</head>
<body>

<div class="logo-container">
    <img src="login_logo.png" alt="Logo" class="logo">
</div>

<h2>📋 Historial de Calificaciones de <?php echo htmlspecialchars($nombre_maestro); ?></h2>
<p>Aquí puedes ver cuántas calificaciones has subido por grupo, materia y parcial.</p>

<table>
    <tr>
        <th>Grupo</th>
        <th>Materia</th>
        <th>Parcial</th>
        <th>Total de Calificaciones</th>
    </tr>
    <?php while ($row = $res->fetch_assoc()):
        if ($row['parcial'] == 4) continue;
    ?>
    <tr>
        <td><?php echo htmlspecialchars($row['nombre_grupo']); ?></td>
        <td><?php echo htmlspecialchars($row['nombre_materia']); ?></td>
        <td><?php echo $row['parcial']; ?></td>
        <td><?php echo $row['total_calificaciones']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<hr>

<div class="botones-acciones">
    <form action="panel_maestro.php" method="get">
        <button type="submit">🔙 Volver al Panel</button>
    </form>
</div>

</body>
</html>

