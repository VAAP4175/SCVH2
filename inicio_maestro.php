<?php
include("conexion.php");

$id_maestro = $_SESSION['id_maestro'] ?? null;

if (!$id_maestro) {
  echo "<p>Error de sesión.</p>";
  exit();
}

if (isset($_GET['actualizado']) && $_GET['actualizado'] == 1) {
  echo "<div class='alerta-exito'>¡Datos actualizados correctamente!</div>";
}

// Datos generales del maestro
$sql1 = "SELECT nombre_completo FROM maestros WHERE id_maestro = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $id_maestro);
$stmt1->execute();
$maestro = $stmt1->get_result()->fetch_assoc();

// Datos extendidos del maestro
$sql2 = "SELECT * FROM maestros_datos WHERE id_maestro = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $id_maestro);
$stmt2->execute();
$datos = $stmt2->get_result()->fetch_assoc();

// Materias y grupos asignados
$sql3 = "
  SELECT m.nombre_materia, g.nombre_grupo
  FROM maestros_materias_grupos mmg
  JOIN materias m ON mmg.id_materia = m.id_materia
  JOIN grupos g ON mmg.id_grupo = g.id_grupo
  WHERE mmg.id_maestro = ?
";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("i", $id_maestro);
$stmt3->execute();
$materias = $stmt3->get_result();
?><div class="card-datos">
  <h2><?= $maestro['nombre_completo'] ?></h2>  <div class="datos-bloque">
    <h3>Información general</h3>
    <p><strong>Fecha de nacimiento:</strong> <?= $datos['fecha_nacimiento'] ?? 'No registrado' ?></p>
    <p><strong>Estado civil:</strong> <?= $datos['estado_civil'] ?? 'No registrado' ?></p>
    <p><strong>Teléfono:</strong> <?= $datos['telefono'] ?? 'No registrado' ?></p>
    <p><strong>Correo:</strong> <?= $datos['correo'] ?? 'No registrado' ?></p>
  </div>  <div class="datos-bloque">
    <h3>Información de contacto</h3>
    <p><strong>Calle y número:</strong> <?= $datos['calle'] ?? 'No registrado' ?></p>
    <p><strong>Colonia:</strong> <?= $datos['colonia'] ?? 'No registrado' ?></p>
    <p><strong>Municipio:</strong> <?= $datos['municipio'] ?? 'No registrado' ?></p>
    <p><strong>Estado:</strong> <?= $datos['estado'] ?? 'No registrado' ?></p>
  </div>  <div class="datos-bloque">
    <h3>Materias y Grupos asignados</h3>
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="text-align: left; padding: 8px; background-color: #030059; color: white;">Materia</th>
          <th style="text-align: left; padding: 8px; background-color: #030059; color: white;">Grupo</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $materias->fetch_assoc()): ?>
        <tr>
          <td style="padding: 8px; border-bottom: 1px solid #ccc;"><?= $row['nombre_materia'] ?></td>
          <td style="padding: 8px; border-bottom: 1px solid #ccc;"><?= $row['nombre_grupo'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>