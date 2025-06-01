<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "conexion.php";

$id_maestro = $_SESSION['id_maestro'] ?? null;
if (!$id_maestro) {
    die("Error de sesión");
}

$msg = '';

// Eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['eliminar'])) {
    $conn->begin_transaction();
    try {
        $del = $conn->prepare("DELETE FROM maestros_materias_perfil WHERE id = ?");
        foreach ($_POST['eliminar'] as $perfil_id) {
            $del->bind_param("i", $perfil_id);
            $del->execute();
        }
        $conn->commit();
        $msg = "<p class='success'>Selecciones actualizadas correctamente.</p>";
    } catch (\Throwable $e) {
        $conn->rollback();
        $msg = "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// Carreras
$carreras = [];
$stmt_car = $conn->prepare("
SELECT DISTINCT c.id_carrera, c.nombre_carrera
FROM maestros_materias_perfil pf
JOIN materias m ON pf.id_materia = m.id_materia
JOIN materias_semestre ms ON m.id_materia = ms.id_materia
JOIN semestres s ON ms.id_semestre = s.id_semestre
JOIN carreras c ON s.id_carrera = c.id_carrera
WHERE pf.id_maestro = ?
");
$stmt_car->bind_param("i", $id_maestro);
$stmt_car->execute();
$res_car = $stmt_car->get_result();
while ($row = $res_car->fetch_assoc()) {
    $carreras[] = $row;
}

// Periodos
$periodos = [];
$stmt_per = $conn->prepare("
SELECT DISTINCT ps.id_periodo, ps.periodo
FROM maestros_materias_perfil pf
JOIN materias m ON pf.id_materia = m.id_materia
JOIN materias_semestre ms ON m.id_materia = ms.id_materia
JOIN semestres s ON ms.id_semestre = s.id_semestre
JOIN periodo_semestral ps ON s.id_periodo = ps.id_periodo
WHERE pf.id_maestro = ?
");
$stmt_per->bind_param("i", $id_maestro);
$stmt_per->execute();
$res_per = $stmt_per->get_result();
while ($row = $res_per->fetch_assoc()) {
    $periodos[] = $row;
}

$id_carrera = $_POST['id_carrera'] ?? '';
$id_periodo = $_POST['id_periodo'] ?? '';

if (!empty($id_periodo)) {
    $_SESSION['id_periodo'] = $id_periodo;
}


$datos = [];

if (!empty($id_carrera) && !empty($id_periodo)) {
    $sql = "
    SELECT 
        pf.id,
        m.nombre_materia,
        pf.fecha_registro,
        s.numero AS semestre,
        c.nombre_carrera,
        ps.periodo
    FROM maestros_materias_perfil pf
    JOIN materias m ON pf.id_materia = m.id_materia
    JOIN materias_semestre ms ON m.id_materia = ms.id_materia
    JOIN semestres s ON ms.id_semestre = s.id_semestre
    JOIN carreras c ON s.id_carrera = c.id_carrera
    JOIN periodo_semestral ps ON s.id_periodo = ps.id_periodo
    WHERE pf.id_maestro = ?
      AND c.id_carrera = ?
      AND ps.id_periodo = ?
    ORDER BY c.nombre_carrera, ps.periodo, s.numero, m.nombre_materia
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id_maestro, $id_carrera, $id_periodo);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $grupo = $row['nombre_carrera'] . " - " . $row['periodo'];
        $datos[$grupo][$row['semestre']][] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Materias seleccionadas</title>
<link rel="stylesheet" href="styleVermaterias.css">
</head>
<body>

<div class="card-datos">
    <h2 style="text-align: center;">MIS MATERIAS SELECCIONADAS</h2>
    <?= $msg ?>
   <section>
  <div class="filtros-contenedor">
    <form method="post">
      <label>Carrera:</label>
      <select name="id_carrera" onchange="this.form.submit()">
        <option value="">-- Todas --</option>
        <?php foreach ($carreras as $c): ?>
          <option value="<?= $c['id_carrera'] ?>" <?= $id_carrera == $c['id_carrera'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['nombre_carrera']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label>Periodo:</label>
      <select name="id_periodo" onchange="this.form.submit()">
        <option value="">-- Todos --</option>
        <?php foreach ($periodos as $p): ?>
          <option value="<?= $p['id_periodo'] ?>" <?= $id_periodo == $p['id_periodo'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['periodo']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <form method="post" action="descargar_materias_pdf.php" target="_blank">
      <input type="hidden" name="id_periodo" value="<?= htmlspecialchars($id_periodo)?>">
      <button type="submit" class="btn-pdf">Descargar PDF</button>
    </form>
  </div>
</section>



    <?php if (empty($datos)): ?>
        <p>Por favor, selecciona carrera y periodo para ver las materias</p>
    <?php else: ?>
        <form method="post">
            <?php foreach ($datos as $grupo => $semestres): ?>
                <h3 style="text-align: center;"><?= $grupo ?></h3>
                <?php foreach ($semestres as $semestre => $materias): ?>
                    <h4>Semestre <?= $semestre ?></h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Eliminar</th>
                                <th>Materia</th>
                                <th>Fecha de registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $m): ?>
                            <tr>
                                <td><input type="checkbox" name="eliminar[]" value="<?= $m['id'] ?>"></td>
                                <td><?= htmlspecialchars($m['nombre_materia']) ?></td>
                                <td><?= htmlspecialchars($m['fecha_registro']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <button type="submit">Actualizar selecciones</button>
        </form>
    
    <?php endif; ?>

    <p><a href="panel_general_maestro.php">← Volver al panel</a></p>
</div>
</body>
</html>
