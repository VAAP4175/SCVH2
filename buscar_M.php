<?php
include "conexion.php";

$filtro = $_POST['filtro'] ?? '';
$buscar = $_POST['buscar'] ?? '';

$sql = "SELECT m.id_materia, m.nombre_materia, s.numero AS semestre 
        FROM materias m
        LEFT JOIN materias_semestre ms ON m.id_materia = ms.id_materia
        LEFT JOIN semestres s ON ms.id_semestre = s.id_semestre";

if ($filtro == "id") {
    $sql .= " WHERE m.id_materia LIKE '%$buscar%'";
} elseif ($filtro == "nombre") {
    $sql .= " WHERE m.nombre_materia LIKE '%$buscar%'";
} elseif ($filtro == "semestre") {
    $sql .= " WHERE s.numero LIKE '%$buscar%'";
}

$result = $conn->query($sql);

echo "<tr><th>ID</th><th>Nombre</th><th>Semestre</th><th>Acciones</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id_materia']}</td>
        <td>{$row['nombre_materia']}</td>
        <td>{$row['semestre']}°</td>
        <td>
            <button onclick=\"abrirModal('{$row['id_materia']}', '{$row['nombre_materia']}', '{$row['semestre']}')\">✏️ Editar</button>
        </td>
    </tr>";
}
?>
