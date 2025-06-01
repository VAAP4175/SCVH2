<?php

include("conexion.php");

if (!isset($_SESSION['id_alumno'])) {
    header("Location: index.php");
    exit();
}

$id_alumno = $_SESSION['id_alumno'];

// 1️⃣ Obtener el grupo del alumno
$stmt = $conn->prepare("
    SELECT g.id_grupo, g.nombre_grupo, g.id_semestre, c.nombre_carrera
    FROM alumnos a
    JOIN grupos g ON a.id_grupo = g.id_grupo
    JOIN carreras c ON g.id_carrera = c.id_carrera
    WHERE a.id_alumno = ?
");
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$grupo = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$grupo) {
    echo "<h2>No se encontró información de tu grupo.</h2>";
    exit();
}

$id_grupo = $grupo['id_grupo'];
$nombre_grupo = $grupo['nombre_grupo'];
$nombre_carrera = $grupo['nombre_carrera'];
$id_semestre = $grupo['id_semestre'];

echo "<h2>Horario del Grupo: $nombre_grupo</h2>";
echo "<p>Carrera: $nombre_carrera</p>";

// 2️⃣ Obtener horas únicas registradas para este grupo
$stmt = $conn->prepare("
    SELECT DISTINCT hora_inicio, hora_fin
    FROM horario_grupo
    WHERE id_grupo = ?
    ORDER BY hora_inicio
");
$stmt->bind_param("i", $id_grupo);
$stmt->execute();
$horas_result = $stmt->get_result();
$horas = [];
while ($row = $horas_result->fetch_assoc()) {
    $horas[] = [
        'hora_inicio' => $row['hora_inicio'],
        'hora_fin' => $row['hora_fin']
    ];
}
$stmt->close();

// 3️⃣ Obtener materias por día y hora
$stmt = $conn->prepare("
    SELECT dia_semana, hora_inicio, m.nombre_materia
    FROM horario_grupo hg
    JOIN materias m ON hg.id_materia = m.id_materia
    WHERE hg.id_grupo = ?
");
$stmt->bind_param("i", $id_grupo);
$stmt->execute();
$horario_result = $stmt->get_result();

$horario = [];
while ($row = $horario_result->fetch_assoc()) {
    $dia = $row['dia_semana'];
    $hora_inicio = $row['hora_inicio'];
    $materia = $row['nombre_materia'];

    $horario[$hora_inicio][$dia] = $materia;
}
$stmt->close();

// 4️⃣ Renderizar tabla de horario
echo "<div class='tabla-horario'>";
echo "<table border='1' cellpadding='5'>";
echo "<tr>
        <th>Hora</th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miércoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
      </tr>";

$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

foreach ($horas as $hora) {
    $hay_materia = false;
    foreach ($dias as $dia) {
        if (!empty($horario[$hora['hora_inicio']][$dia])) {
            $hay_materia = true;
            break;
        }
    }
    if ($hay_materia) {
        echo "<tr>";
        echo "<td>{$hora['hora_inicio']} - {$hora['hora_fin']}</td>";
        foreach ($dias as $dia) {
            $materia = isset($horario[$hora['hora_inicio']][$dia]) ? $horario[$hora['hora_inicio']][$dia] : "";
            echo "<td>$materia</td>";
        }
        echo "</tr>";
    }
}
echo "</table>";
echo "</div>";
echo "<br><br>";
// 5️⃣ Mostrar materias, docentes y horas por semana


// Consulta para materias, docentes y horas
$stmt = $conn->prepare("
    SELECT m.nombre_materia, ma.nombre_completo AS nombre_docente, COUNT(*) AS horas_por_semana
    FROM horario_grupo hg
    JOIN materias m ON hg.id_materia = m.id_materia
    JOIN maestros ma ON hg.id_maestro = ma.id_maestro
    WHERE hg.id_grupo = ?
    GROUP BY m.nombre_materia, ma.nombre_completo
    ORDER BY m.nombre_materia
");
$stmt->bind_param("i", $id_grupo);
$stmt->execute();
$result = $stmt->get_result();

// Renderizar tabla
echo "<div class='tabla-materias'>";
echo "<table border='1' cellpadding='5'>";
echo "<tr>
        <th>Materia</th>
        <th>Docente</th>
        <th>Horas por semana</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['nombre_materia']}</td>";
    echo "<td>{$row['nombre_docente']}</td>";
    echo "<td>{$row['horas_por_semana']}</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";

$stmt->close();

?>
