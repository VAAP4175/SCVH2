<?php
include "conexion.php";

$id_materia = $_GET['id'] ?? null;

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_materia) {
    $nombre_materia = $_POST['nombre_materia'];
    $id_carrera = $_POST['id_carrera'];

    $conexion->query("
        UPDATE materias
        SET nombre_materia = '$nombre_materia', id_carrera = $id_carrera
        WHERE id_materia = $id_materia
    ");

    header("Location: admin_materias.php");
    exit;
}

// Obtener datos actuales de la materia
$materia_actual = $conn->query("
    SELECT m.id_materia, m.nombre_materia, m.id_carrera
    FROM materias m
    WHERE m.id_materia = $id_materia
")->fetch_assoc();

// Obtener listado de carreras
$carreras = $conn->query("SELECT id_carrera, nombre_carrera FROM carreras");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Materia</title>
</head>
<body>
    <h2>Editar Materia</h2>
    <form method="post">
        <label>Nombre de la materia:</label>
        <input type="text" name="nombre_materia" value="<?= htmlspecialchars($materia_actual['nombre_materia']) ?>" required>
        <br><br>
        <label>Seleccionar carrera:</label>
        <select name="id_carrera" required>
            <?php while ($car = $carreras->fetch_assoc()): ?>
                <option value="<?= $car['id_carrera'] ?>" <?= ($car['id_carrera'] == $materia_actual['id_carrera']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($car['nombre_carrera']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
