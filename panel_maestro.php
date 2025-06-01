<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

$id_maestro = $_SESSION['id_maestro'];
$nombre_maestro = $_SESSION['nombre_completo'] ?? 'Maestro';

// Obtener relaciones grupo-materia del maestro
$query = "
SELECT g.id_grupo, g.nombre_grupo, m.id_materia, m.nombre_materia
FROM maestros_materias_grupos mmg
JOIN grupos g ON mmg.id_grupo = g.id_grupo
JOIN materias m ON mmg.id_materia = m.id_materia
WHERE mmg.id_maestro = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_maestro);
$stmt->execute();
$resultado = $stmt->get_result();

$relaciones = [];
foreach ($resultado as $row) {
    $relaciones[$row['id_grupo']][] = [
        'id_materia' => $row['id_materia'],
        'nombre_materia' => $row['nombre_materia'],
        'nombre_grupo' => $row['nombre_grupo']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Maestro</title>
    <link rel="stylesheet" href="panel_maestro.css">
</head>
<body>

<div class="logo-container">
    <img src="login_logo.png" alt="Logo Intercala" class="logo">
</div>

<h2>👨‍🏫 Bienvenido, <?php echo htmlspecialchars($nombre_maestro); ?></h2>

<!-- BOTONES EN GRUPO -->
<div class="botones-acciones">
    <form action="historial_calificaciones.php" method="get">
        <button type="submit">📋 Ver Historial</button>
    </form>

    <form action="panel_general_maestro.php" method="post" style="display:inline; margin-left:10px;">
        <button type="submit">⬅ Volver al Panel </button>
    </form>

    <form action="logout.php" method="post">
        <button type="submit">🚪 Cerrar Sesión</button>
    </form>
</div><br><br>

<p>📤 Utilice el siguiente formulario para subir calificaciones por grupo, materia y parcial.</p>

<!-- FORMULARIO PRINCIPAL CON CLASE -->
<form class="formulario-calificaciones" action="procesar_excel.php" method="post" enctype="multipart/form-data">
    <label for="grupo">📘 Grupo:</label>
    <select id="grupo" name="grupo" required onchange="filtrarMaterias()">
        <option value="">Seleccione grupo</option>
        <?php
        foreach ($relaciones as $id_grupo => $materias) {
            echo "<option value='$id_grupo'>{$materias[0]['nombre_grupo']}</option>";
        }
        ?>
    </select><br><br>

    <label for="materia">📚 Materia:</label>
    <select id="materia" name="materia" required>
        <option value="">Seleccione una materia</option>
    </select><br><br>

    <label for="parcial">📝 Parcial:</label>
    <select name="parcial" required>
        <option value="">Seleccione parcial</option>
        <option value="1">1° Parcial</option>
        <option value="2">2° Parcial</option>
        <option value="3">3° Parcial</option>
    </select><br><br>

    <label for="archivo_excel">📎 Archivo Excel:</label>
    <input type="file" name="archivo_excel" accept=".xlsx" required><br><br>

    <input type="submit" value="📥 Subir Calificaciones">
</form>

<br><hr><br>

<script>
    const materiasPorGrupo = <?php echo json_encode($relaciones); ?>;

    function filtrarMaterias() {
        const grupoSelect = document.getElementById('grupo');
        const materiaSelect = document.getElementById('materia');
        const idGrupoSeleccionado = grupoSelect.value;

        materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';

        if (materiasPorGrupo[idGrupoSeleccionado]) {
            materiasPorGrupo[idGrupoSeleccionado].forEach(materia => {
                const option = document.createElement('option');
                option.value = materia.id_materia;
                option.textContent = materia.nombre_materia;
                materiaSelect.appendChild(option);
            });
        }
    }
</script>

</body>
</html>


