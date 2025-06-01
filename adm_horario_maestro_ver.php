<?php
include 'conexion.php';

// 1️⃣ Definir bloques de horario
$bloques = [
    1 => ['07:00', '07:50'],
    2 => ['07:50', '08:40'],
    3 => ['08:40', '09:30'],
    // Receso: 9:30-9:50
    4 => ['09:50', '10:40'],
    5 => ['10:40', '11:30'],
    6 => ['11:30', '12:20'],
    7 => ['12:20', '13:10'],
];

$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

// 2️⃣ Obtener todos los maestros
$sqlMaestros = "SELECT id_maestro, nombre_completo FROM maestros ORDER BY nombre_completo";
$resMaestros = $conn->query($sqlMaestros);
$maestros = [];
while ($row = $resMaestros->fetch_assoc()) {
    $maestros[] = $row;
}

// 3️⃣ Obtener maestro seleccionado
$idMaestroSeleccionado = isset($_GET['id_maestro']) ? (int)$_GET['id_maestro'] : null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Horario de Maestro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            background-color: #00125A;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #00125A;
            color: white;
            padding: 8px;
        }
        td, th {
            border: 1px solid #ccc;
            text-align: center;
            padding: 6px;
        }
        .receso {
            background-color: #f0f0f0;
            font-style: italic;
        }
        .form-container {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Consultar Horario de Maestro</h1>

    <!-- Formulario para seleccionar al maestro -->
    <div class="form-container">
        <form method="GET">
            <label for="id_maestro_ver">Selecciona un maestro:</label>
            <select name="id_maestro_ver" id="id_maestro_ver" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($maestros as $m): ?>
                    <option value="<?= $m['id_maestro'] ?>" <?= ($idMaestroSeleccionado == $m['id_maestro']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['nombre_completo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Consultar Horario</button>
        </form>
    </div>

     <?php if ($idMaestroSeleccionado): ?>
        <?php
        // 4️⃣ Consultar horario del maestro
        $horarioMaestro = [];

        $sqlHorario = "
            SELECT 
                hg.dia_semana,
                hg.bloque,
                g.nombre_grupo,
                m.nombre_materia
            FROM horario_grupo hg
            JOIN maestros_materias_grupos mmg 
                ON hg.id_materia = mmg.id_materia AND hg.id_grupo = mmg.id_grupo
            JOIN materias m 
                ON hg.id_materia = m.id_materia
            JOIN grupos g 
                ON hg.id_grupo = g.id_grupo
            WHERE mmg.id_maestro = ?
        ";

        $stmt = $conn->prepare($sqlHorario);
        $stmt->bind_param("i", $idMaestroSeleccionado);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $horarioMaestro[$row['bloque']][$row['dia_semana']] = "{$row['nombre_materia']}<br><small>{$row['nombre_grupo']}</small>";
        }

        $stmt->close();

        // Obtener nombre del maestro seleccionado
        $nombreMaestro = '';
        foreach ($maestros as $m) {
            if ($m['id_maestro'] == $idMaestroSeleccionado) {
                $nombreMaestro = $m['nombre_completo'];
                break;
            }
        }
        ?>
        <h2><?= htmlspecialchars($nombreMaestro) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Hora</th>
                    <?php foreach ($dias as $dia): ?>
                        <th><?= $dia ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bloques as $bloque => $horas): ?>
                    <tr>
                        <td><?= "{$horas[0]} - {$horas[1]}" ?></td>
                        <?php foreach ($dias as $dia): ?>
                            <td>
                                <?= isset($horarioMaestro[$bloque][$dia]) ? $horarioMaestro[$bloque][$dia] : '' ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php if ($bloque === 3): // Receso después del bloque 3 ?>
                        <tr class="receso">
                            <td colspan="<?= count($dias) + 1 ?>">Receso (9:30 - 9:50)</td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>


 SELECT 
                hg.dia_semana,
                hg.bloque,
                g.nombre_grupo,
                m.nombre_materia
            FROM horario_grupo hg
            JOIN maestros_materias_grupos mmg 
                ON hg.id_materia = mmg.id_materia AND hg.id_grupo = mmg.id_grupo
            JOIN materias m 
                ON hg.id_materia = m.id_materia
            JOIN grupos g 
                ON hg.id_grupo = g.id_grupo
            WHERE mmg.id_maestro = ?
        ";
