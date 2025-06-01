<?php
include "conexion.php";

$id_semestre = $_GET['id_semestre'] ?? '';

if (!$id_semestre) {
    echo "<p style='color:red;'>Selecciona un semestre válido.</p>";
    exit;
}

$sql = "SELECT h.hora_inicio, h.hora_fin, h.dia_semana, m.nombre_materia
        FROM horarios h
        JOIN materias m ON h.id_materia = m.id_materia
        WHERE h.id_semestre = $id_semestre
        ORDER BY h.hora_inicio, FIELD(h.dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes')";

$resultado = $conn->query($sql);

echo "<table><tr><th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";

$horas = ["07:00 - 07:50", "07:50 - 08:40", "08:40 - 09:30", "09:30 - 09:50 (Receso)", "09:50 - 10:40", "10:40 - 11:30", "11:30 - 12:20", "12:20 - 13:10"];

$horario = [];
while ($fila = $resultado->fetch_assoc()) {
    $horario[$fila['hora_inicio']][$fila['dia_semana']] = $fila['nombre_materia'];
}

foreach ($horas as $hora) {
    echo "<tr><td><strong>$hora</strong></td>";
    foreach (["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"] as $dia) {
        echo "<td>" . ($horario[$hora][$dia] ?? '') . "</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>
