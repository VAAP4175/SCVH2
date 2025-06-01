<?php
include("conexion.php");

$id_maestro = $_SESSION['id_maestro'] ?? null;

if (!$id_maestro) {
  echo "<p>Error de sesión.</p>";
  exit();
}

// Obtener datos existentes del maestro
$sql = "SELECT * FROM maestros_datos WHERE id_maestro = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_maestro);
$stmt->execute();
$datos = $stmt->get_result()->fetch_assoc();
?><div class="card-datos">
  <h2>Editar Mis Datos</h2>  <form action="procesar_edicion_datos_maestro.php" method="POST">
    <div class="datos-bloque">
      <h3>Información general</h3><div class="form-group">
    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $datos['fecha_nacimiento'] ?? '' ?>">
  </div>

  <div class="form-group">
    <label for="estado_civil">Estado civil:</label>
    <select id="estado_civil" name="estado_civil">
      <option value="Soltero" <?= ($datos['estado_civil'] ?? '') === 'Soltero' ? 'selected' : '' ?>>Soltero</option>
      <option value="Casado" <?= ($datos['estado_civil'] ?? '') === 'Casado' ? 'selected' : '' ?>>Casado</option>
      <option value="Otro" <?= ($datos['estado_civil'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
    </select>
  </div>

  <div class="form-group">
    <label for="telefono">Teléfono:</label>
    <input type="tel" id="telefono" name="telefono" value="<?= $datos['telefono'] ?? '' ?>">
  </div>

  <div class="form-group">
    <label for="correo">Correo electrónico:</label>
    <input type="email" id="correo" name="correo" value="<?= $datos['correo'] ?? '' ?>">
  </div>
</div>

<div class="datos-bloque">
  <h3>Información de contacto</h3>

  <div class="form-group">
    <label for="calle">Calle y número:</label>
    <input type="text" id="calle" name="calle" value="<?= $datos['calle'] ?? '' ?>">
  </div>

  <div class="form-group">
    <label for="colonia">Colonia:</label>
    <input type="text" id="colonia" name="colonia" value="<?= $datos['colonia'] ?? '' ?>">
  </div>

  <div class="form-group">
    <label for="municipio">Municipio:</label>
    <input type="text" id="municipio" name="municipio" value="<?= $datos['municipio'] ?? '' ?>">
  </div>

  <div class="form-group">
    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado" value="<?= $datos['estado'] ?? '' ?>">
  </div>
</div>

<button type="submit">Guardar cambios</button>

  </form>
</div>