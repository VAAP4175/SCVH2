<?php
include("conexion.php");

if (isset($_GET['actualizado']) && $_GET['actualizado'] == 1) {
  echo "<div class='alerta-exito'>¡Datos actualizados correctamente!</div>";
}

$id_alumno = $_SESSION['id_alumno'] ?? null;

$sql = "SELECT a.nombre_completo, g.nombre_grupo, c.nombre_carrera 
        FROM alumnos a
        JOIN grupos g ON a.id_grupo = g.id_grupo
        JOIN carreras c ON g.id_carrera = c.id_carrera
        WHERE a.id_alumno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$basicos = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("SELECT * FROM datos_alumno WHERE id_alumno = ?");
$stmt2->bind_param("i", $id_alumno);
$stmt2->execute();
$extra = $stmt2->get_result()->fetch_assoc();
?>

<div class="card-datos">
  <h2><?= $basicos['nombre_completo'] ?></h2>

  <div class="datos-bloque">
    <h3>Información general</h3>
    <p><strong>Fecha de nacimiento:</strong> <?= $extra['nacimiento'] ?? 'No registrado' ?></p>
    <p><strong>Estado civil:</strong> <?= $extra['estado_civil'] ?? 'No registrado' ?></p>
    <p><strong>Teléfono:</strong> <?= $extra['telefono'] ?? 'No registrado' ?></p>
    <p><strong>Correo:</strong> <?= $extra['correo'] ?? 'No registrado' ?></p>
  </div>

  <div class="datos-bloque">
    <h3>Información escolar</h3>
    <p><strong>N° de control:</strong> <?= $extra['control'] ?? 'No registrado' ?></p>
    <p><strong>Carrera:</strong> <?= $basicos['nombre_carrera'] ?></p>
    <p><strong>Grupo:</strong> <?= $basicos['nombre_grupo'] ?></p>
    <p><strong>Estatus:</strong> <?= $extra['estatus'] ?? 'No registrado' ?></p>
  </div>

  <div class="datos-bloque">
    <h3>Información de contacto</h3>
    <p><strong>Calle y número:</strong> <?= $extra['calle'] ?? 'No registrado' ?></p>
    <p><strong>Colonia:</strong> <?= $extra['colonia'] ?? 'No registrado' ?></p>
    <p><strong>Municipio:</strong> <?= $extra['municipio'] ?? 'No registrado' ?></p>
    <p><strong>Estado:</strong> <?= $extra['estado'] ?? 'No registrado' ?></p>
  </div>
</div>

