<?php
session_start();
if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';

if (!isset($_GET['id_grupo'], $_GET['id_materia'], $_GET['id_maestro'], $_GET['parcial'])) {
    die("Faltan parámetros.");
}

$id_grupo = intval($_GET['id_grupo']);
$id_materia = intval($_GET['id_materia']);
$id_maestro = intval($_GET['id_maestro']);
$parcial = intval($_GET['parcial']);

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calificaciones'])) {
    foreach ($_POST['calificaciones'] as $id_alumno => $nueva_calif) {
        $nueva_calif = floatval($nueva_calif);
        $stmt = $conn->prepare("UPDATE calificaciones SET calificacion = ? 
            WHERE id_alumno = ? AND id_materia = ? AND id_grupo = ? AND parcial = ? AND id_maestro = ?");
        $stmt->bind_param("diiiii", $nueva_calif, $id_alumno, $id_materia, $id_grupo, $parcial, $id_maestro);
        $stmt->execute();
        $stmt->close();
    }
    echo "<script>alert('Calificaciones actualizadas.'); window.location='panel_admin.php';</script>";
    exit();
}

// Obtener alumnos con calificación en ese grupo/materia/parcial
$sql = "
SELECT a.id_alumno, a.nombre_completo, c.calificacion
FROM calificaciones c
JOIN alumnos a ON c.id_alumno = a.id_alumno
WHERE c.id_grupo = ? AND c.id_materia = ? AND c.parcial = ? AND c.id_maestro = ?
ORDER BY a.nombre_completo
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $id_grupo, $id_materia, $parcial, $id_maestro);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Calificaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editar_calificaciones.css">
</head>
<body>
    <div class="contenedor">
        <h2>✏️ Editar Calificaciones</h2>

        <input type="text" id="buscador" placeholder="🔍 Buscar alumno..." onkeyup="filtrarTabla()" class="buscador">

        <form method="post">
            <table>
                <tr>
                    <th>Alumno</th>
                    <th>Calificación</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_completo']); ?></td>
                        <td>
                            <input type="number" name="calificaciones[<?php echo $row['id_alumno']; ?>]"
                                   value="<?php echo $row['calificacion']; ?>" step="0.1" min="0" max="10" required>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <div class="acciones">
                <button type="submit">💾 Guardar Cambios</button>
                <a href="panel_admin.php" class="volver">🔙 Volver al Panel</a>
            </div>
        </form>
    </div>

    <script>
    function filtrarTabla() {
        const input = document.getElementById("buscador");
        const filtro = input.value.toLowerCase();
        const filas = document.querySelectorAll("table tr");

        filas.forEach((fila, index) => {
            if (index === 0) return; // Encabezado
            const celda = fila.cells[0];
            const nombre = celda.textContent.toLowerCase();
            fila.style.display = nombre.includes(filtro) ? "" : "none";
        });
    }
    </script>
</body>
</html>