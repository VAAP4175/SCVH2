<?php
include('conexion.php');

$filtro = $_POST['filtro'] ?? 'nombre_completo';
$buscar = $_POST['buscar'] ?? '';

$sql = "SELECT a.id_alumno, a.nombre_completo, a.usuario, g.nombre_grupo
        FROM alumnos a
        JOIN grupos g ON a.id_grupo = g.id_grupo
        WHERE $filtro LIKE ?";

$stmt = $conn->prepare($sql);
$param = "%$buscar%";
$stmt->bind_param("s", $param);
$stmt->execute();
$result = $stmt->get_result();

echo "<table>
<tr>
  <th>id</th>
  <th>Nombre</th>
  <th>Usuario</th>
  <th>Grupo</th>
  <th colspan='2'>Acciones</th>
</tr>";

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>".htmlspecialchars($row['id_alumno'])."</td>
      <td>".htmlspecialchars($row['nombre_completo'])."</td>
      <td>".htmlspecialchars($row['usuario'])."</td>
      <td>".htmlspecialchars($row['nombre_grupo'])."</td>
      <td><a href='eliminar.php?id=".$row['id_alumno']."'>Eliminar</a></td>
      <td><a href='actualizar_alumnos.php?id=".$row['id_alumno']."'>Actualizar</a></td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='6'>No se encontraron resultados.</td></tr>";
}
echo "</table>";
?>
