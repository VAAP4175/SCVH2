<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "conexion.php";

$id_maestro   = $_SESSION['id_maestro'] ?? null;
if (!$id_maestro) {
    die("Error de sesión. Por favor inicia sesión.");
}

// 1) Capturamos valores previos
$sel_periodo  = $_POST['id_periodo']  ?? '';
$sel_carrera  = $_POST['id_carrera']  ?? '';
$sel_semestre = $_POST['id_semestre'] ?? '';
$msg = '';

// 2) Procesamos el POST al guardar materias
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['materias'])) {
    $materias = $_POST['materias']; // array de id_materia

    $conn->begin_transaction();
    try {
        // Inserta cada materia marcada como pendiente
        $ins = $conn->prepare("
            INSERT INTO maestros_materias_perfil
              (id_maestro, id_materia, estado, fecha_registro)
            VALUES (?, ?, 'pendiente', NOW())
        ");
        foreach ($materias as $id_mat) {
            $ins->bind_param("ii", $id_maestro, $id_mat);
            $ins->execute();
        }

        $conn->commit();
        $msg = "<p style='color:green;'>Perfil de materias enviado para aprobación correctamente.</p>";
    } catch (\Throwable $e) {
        $conn->rollback();
        $msg = "<p style='color:red;'>¡Error al guardar la materia seleccionada: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel del Maestro – Selección de Materias</title>
  <style>
   
    label { display: block; margin: 1rem 0 0.5rem; }
    select { padding: 0.3rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
    th { background: #f0f0f0; }
    button { margin-top: 1rem; padding: 0.6rem 1.2rem; }
  </style>
</head>
<body>
  
    <div class="card-datos">
  <h2>Seleccione las Materias Acorde a su Perfil</h2>
  <?= $msg ?>

  <form method="post" action="">
    <!-- Selección de Periodo -->
    <label><strong>Periodo:</strong>
      <select name="id_periodo" onchange="this.form.submit()">
        <option value="">-- selecciona --</option>
        <?php
        $r1 = $conn->query("SELECT id_periodo, periodo FROM periodo_semestral");
        while ($p = $r1->fetch_assoc()):
            $sel = $p['id_periodo'] == $sel_periodo ? 'selected' : '';
        ?>
          <option value="<?= $p['id_periodo'] ?>" <?= $sel ?>>
            <?= htmlspecialchars($p['periodo']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </label>

    <?php if ($sel_periodo): ?>
      <!-- Selección de Carrera -->
      <label><strong>Carrera:</strong>
        <select name="id_carrera" onchange="this.form.submit()">
          <option value="">-- selecciona --</option>
          <?php
          $r2 = $conn->query("SELECT id_carrera, nombre_carrera FROM carreras");
          while ($c = $r2->fetch_assoc()):
              $selC = $c['id_carrera'] == $sel_carrera ? 'selected' : '';
          ?>
            <option value="<?= $c['id_carrera'] ?>" <?= $selC ?>>
              <?= htmlspecialchars($c['nombre_carrera']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </label>
    <?php endif; ?>

    <?php if ($sel_periodo && $sel_carrera): ?>
      <!-- Selección de Semestre -->
      <label><strong>Semestre:</strong>
        <select name="id_semestre" onchange="this.form.submit()">
          <option value="">-- selecciona --</option>
          <?php
          $stmt = $conn->prepare("
            SELECT s.id_semestre, s.numero
              FROM semestres s
             WHERE s.id_periodo  = ?
               AND s.id_carrera  = ?
          ");
          $stmt->bind_param("ii", $sel_periodo, $sel_carrera);
          $stmt->execute();
          $rs = $stmt->get_result();
          while ($sem = $rs->fetch_assoc()):
              $sel2 = $sem['id_semestre'] == $sel_semestre ? 'selected' : '';
          ?>
            <option value="<?= $sem['id_semestre'] ?>" <?= $sel2 ?>>
              <?= htmlspecialchars($sem['numero'] . "°") ?>
            </option>
          <?php endwhile; ?>
        </select>
      </label>
    <?php endif; ?>

    <?php if ($sel_semestre): 
      // Consulta las materias de ese semestre
      $stmt2 = $conn->prepare("
        SELECT m.id_materia, m.nombre_materia
          FROM materias m
          JOIN materias_semestre ms USING(id_materia)
         WHERE ms.id_semestre = ?
      ");
      $stmt2->bind_param("i", $sel_semestre);
      $stmt2->execute();
      $rs2 = $stmt2->get_result();
    ?>
      <fieldset>
        <legend><strong>Selecciona las materias que puedes impartir:</strong></legend>
        <table>
          <tr>
            <th>✔</th>
            <th>Materia</th>
          </tr>
          <?php while ($m = $rs2->fetch_assoc()): ?>
          <tr>
            <td>
              <input type="checkbox" name="materias[]" value="<?= $m['id_materia'] ?>">
            </td>
            <td><?= htmlspecialchars($m['nombre_materia']) ?></td>
          </tr>
          <?php endwhile; ?>
        </table>
        <button type="submit">Guardar selecciones</button> <br>
      </fieldset>
    <?php endif; ?>

  </form>
  <!-- Al final de panel_general_maestro.php, antes de </body> -->
<div style="margin-top:2rem;">
  <form action="ver_materias_seleccionadas.php" method="get">
    <button type="submit">Ver materias seleccionadas</button>
  </form>
</div>

  </div>
</body>
</html>
