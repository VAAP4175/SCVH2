<!-- disponibilidad.php -->
<?php
include("conexion.php");
$id_maestro = $_SESSION['id_maestro'] ?? null;
if (!$id_maestro) {
  echo "<p>Error de sesión.</p>";
  exit();
}

// Datos generales del maestro
$sql1 = "SELECT nombre_completo FROM maestros WHERE id_maestro = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $id_maestro);
$stmt1->execute();
$maestro = $stmt1->get_result()->fetch_assoc();
?>
<div class="card-datos">
<div class="datos-bloque">
<h2><?= $maestro['nombre_completo'] ?></h2>

<form action="guardar_disponibilidad.php" method="POST">
  <input type="hidden" name="id_maestro" value="<?= $id_maestro ?>">
  
  <p>por medio de la presente me dirijo a usted para hacer de su conocimiento 
  que tengo la disponibilidad de mi persona para trabajar como docente en la institución que preside en el próximo semestre
  en el siguiente horario:
  </p>
  <h3>De lunes a Viernes</h3>
<div class="form-group">
    <label for="HoraI">Hora Inicio:</label>
    <input type="time" id="HoraI" name="HoraI" style= " padding: 10px 14px; border: 1px solid #ccc; border-radius: 8px; background-color: #fff; transition: border-color 0.2s ease;" required>
  </div>
<div class="form-group">
  <label for="HoraF">Hora de fin:</label>
  <input type="time" id="HoraF" name="HoraF"  style= "padding: 10px 14px; border: 1px solid #ccc; border-radius: 8px; background-color: #fff; transition: border-color 0.2s ease;" required>
</div>
  <button type="submit">Guardar disponibilidad</button>
  
</form>
</div>
</div>
