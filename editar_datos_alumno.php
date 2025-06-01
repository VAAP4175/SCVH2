<?php
include("conexion.php");

$id_alumno = $_SESSION['id_alumno'] ?? null;

if (!$id_alumno) {
  echo "<p>Error de sesión.</p>";
  exit();
}

// Datos del alumno
$sql1 = "SELECT a.nombre_completo, g.nombre_grupo, c.nombre_carrera 
         FROM alumnos a
         JOIN grupos g ON a.id_grupo = g.id_grupo
         JOIN carreras c ON g.id_carrera = c.id_carrera
         WHERE a.id_alumno = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $id_alumno);
$stmt1->execute();
$basicos = $stmt1->get_result()->fetch_assoc();

// Datos adicionales
$stmt2 = $conn->prepare("SELECT * FROM datos_alumno WHERE id_alumno = ?");
$stmt2->bind_param("i", $id_alumno);
$stmt2->execute();
$extra = $stmt2->get_result()->fetch_assoc();
?>

<div class="card-datos">
  <h2>Editar Mis Datos</h2>

  <form action="procesar_edicion_datos.php" method="POST">

    <div class="datos-bloque">
      <h3>Información general</h3>

      <div class="form-group">
        <label for="nacimiento">Fecha de nacimiento:</label>
        <input type="date" id="nacimiento" name="nacimiento" value="<?= $extra['nacimiento'] ?? '' ?>" required>
      </div>

      <div class="form-group">
        <label for="estado_civil">Estado civil:</label>
        <select id="estado_civil" name="estado_civil">
          <option value="Soltero" <?= ($extra['estado_civil'] ?? '') === 'Soltero' ? 'selected' : '' ?>>Soltero</option>
          <option value="Casado" <?= ($extra['estado_civil'] ?? '') === 'Casado' ? 'selected' : '' ?>>Casado</option>
          <option value="Otro" <?= ($extra['estado_civil'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
        </select>
      </div>

      <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" value="<?= $extra['telefono'] ?? '' ?>" required>
      </div>

      <div class="form-group">
        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" value="<?= $extra['correo'] ?? '' ?>" required>
      </div>
    </div>

    <div class="datos-bloque">
      <h3>Información escolar</h3>

      <div class="form-group">
        <label>N° de control:</label>
        <input type="text" value="<?= $extra['control'] ?? '' ?>" disabled>
      </div>

      <div class="form-group">
        <label>Estatus:</label>
        <input type="text" value="<?= $extra['estatus'] ?? '' ?>" disabled>
      </div>

      <div class="form-group">
        <label>Carrera:</label>
        <input type="text" value="<?= $basicos['nombre_carrera'] ?>" disabled>
      </div>

      <div class="form-group">
        <label>Grupo:</label>
        <input type="text" value="<?= $basicos['nombre_grupo'] ?>" disabled>
      </div>
    </div>

    <div class="datos-bloque">
      <h3>Información de contacto</h3>

      <div class="form-group">
        <label for="calle">Calle y número:</label>
        <input type="text" id="calle" name="calle" value="<?= $extra['calle'] ?? '' ?>">
      </div>

      <div class="form-group">
        <label for="colonia">Colonia:</label>
        <input type="text" id="colonia" name="colonia" value="<?= $extra['colonia'] ?? '' ?>">
      </div>

      <div class="form-group">
        <label for="municipio">Municipio:</label>
        <input type="text" id="municipio" name="municipio" value="<?= $extra['municipio'] ?? '' ?>">
      </div>

      <div class="form-group">
        <label for="estado">Estado:</label>
        <input type="text" id="estado" name="estado" value="<?= $extra['estado'] ?? '' ?>">
      </div>
    </div>

    <button type="submit">Guardar cambios</button>
  </form>
</div>