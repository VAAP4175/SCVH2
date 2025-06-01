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

// 3️⃣ Obtener maestro seleccionado y acción
$idMaestroSeleccionado = isset($_GET['id_maestro']) ? (int)$_GET['id_maestro'] : null;
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;

// 4️⃣ Procesar acción de generación
if ($idMaestroSeleccionado && $accion === 'generar') {
    // a) Borrar horario anterior del maestro
    $stmtDelete = $conn->prepare("DELETE FROM horario_maestro WHERE id_maestro = ?");
    $stmtDelete->bind_param("i", $idMaestroSeleccionado);
    $stmtDelete->execute();
    $stmtDelete->close();

    // b) Generar el horario desde horario_grupo (como plantilla)
    $sqlHorario = "
        SELECT 
            hg.dia_semana,
            hg.bloque,
            hg.id_grupo,
            hg.id_materia
        FROM horario_grupo hg
        JOIN maestros_materias_grupos mmg 
            ON hg.id_materia = mmg.id_materia AND hg.id_grupo = mmg.id_grupo
        WHERE mmg.id_maestro = ?
    ";
    $stmt = $conn->prepare($sqlHorario);
    $stmt->bind_param("i", $idMaestroSeleccionado);
    $stmt->execute();
    $result = $stmt->get_result();

    // c) Insertar en horario_maestro
    $stmtInsert = $conn->prepare("
        INSERT INTO horario_maestro 
        (id_maestro, id_grupo, id_materia, dia_semana, bloque, hora_inicio, hora_fin)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    while ($row = $result->fetch_assoc()) {
        $bloque = $row['bloque'];
        $hora_inicio = $bloques[$bloque][0];
        $hora_fin = $bloques[$bloque][1];

        $stmtInsert->bind_param(
            "iiissss",
            $idMaestroSeleccionado,
            $row['id_grupo'],
            $row['id_materia'],
            $row['dia_semana'],
            $bloque,
            $hora_inicio,
            $hora_fin
        );
        $stmtInsert->execute();
    }

    $stmtInsert->close();
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horarios por Maestro</title>
    <link rel="stylesheet" href="menu_adm.css">
    <style>
        main {
            margin-top: 60px;
            margin-left: 199px;
            margin-bottom: 60px;
        }
        table, td, th {
            border: 1px solid black;
            text-align: center;
            border-collapse: collapse;
            padding: 6px;
        }
        tr.incompleto {
            background-color: #ffb3b3;
        }
    </style>
</head>
<body>
  <header>
    <h1>Horarios por Maestro</h1>
    </header>
    <aside class="sidebar">
    <ul class="menu">
        <li class="active" onclick="window.location.href='inicio_adm.php'"><i>🏠</i>Inicio</li>
        <li class="submenu">
            <i>👤</i>Usuarios
            <ul class="submenu-list">
                <li onclick="window.location.href='adm_usuarios.php'"><i>🔐</i>Administrador</li>
                <li onclick="window.location.href='adm_docentes.php'"><i>🖊️</i>Docentes</li>
                <li onclick="window.location.href='adm_alumnos.php'"><i>🎓</i>Alumnos</li>
            </ul>
        </li>

        <li onclick="window.location.href='adm_grupos.php'"><i>📜</i>Grupos</li>
        <li class="submenu">
            <i>📄</i>Horarios
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_horarios.php'"><i>📝</i>Horarios Alumnos</li>
        <li onclick="window.location.href='adm_horarios_D.php'"><i>📑</i>Horarios Docentes</li>
          </ul>
        </li>

        <li class="submenu">
            <i>📚</i>Materias
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_materias.php'"><i>📘</i>Materias</li>
        <li onclick="window.location.href='configurar_horas.php'"><i>⏱</i>Horas por semana</li>
        <li onclick="window.location.href='adm_materias_docente.php'"><i>🗳</i>Solicitud Materias</li>
          </ul>
        </li>
        <li onclick="window.location.href='panel_admin.php'"><i>📂</i>Calificaciones</li>
        <li onclick="window.location.href='index.php'"><i>🔙</i>Salir</li>
    </ul>
</aside>
<main>
    <div class="form-container">
        <form method="GET">
            <label for="id_maestro">Selecciona un maestro:</label>
            <select name="id_maestro" id="id_maestro" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($maestros as $m): ?>
                    <option value="<?= $m['id_maestro'] ?>" <?= ($idMaestroSeleccionado == $m['id_maestro']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['nombre_completo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="accion" value="generar">Generar y Guardar Horario</button>
            <button type="submit" name="accion" value="consultar">Consultar Horario</button>
        </form>
    </div>

    <?php if ($idMaestroSeleccionado && $accion === 'consultar'): ?>
        <?php
        // 5️⃣ Consultar horario del maestro desde horario_maestro
        $horarioMaestro = [];

        $sqlHorario = "
            SELECT 
                hm.dia_semana,
                hm.bloque,
                g.nombre_grupo,
                m.nombre_materia
            FROM horario_maestro hm
            JOIN grupos g ON hm.id_grupo = g.id_grupo
            JOIN materias m ON hm.id_materia = m.id_materia
            WHERE hm.id_maestro = ?
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
        <h2>Horario de <?= htmlspecialchars($nombreMaestro) ?></h2>
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
                    <?php if ($bloque === 3): ?>
                        <tr class="receso">
                            <td colspan="<?= count($dias) + 1 ?>">Receso (9:30 - 9:50)</td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </main>
    <footer>UICSLP © 2025</footer>
</body>
</html>
