<?php
include 'conexion.php';

// Obtener grupos
$sql = "SELECT id_grupo, nombre_grupo FROM grupos";
$resGrupos = $conn->query($sql);
$gruposArr = [];
while ($g = $resGrupos->fetch_assoc()) {
    $gruposArr[] = $g;
}

// Variables para la vista
$idGrupoSeleccionado = isset($_GET['id_grupo']) ? (int)$_GET['id_grupo'] : null;
$accion = $_GET['accion'] ?? '';

$bloques = [
    1 => ['07:00', '07:50'],
    2 => ['07:50', '08:40'],
    3 => ['08:40', '09:30'],
    4 => ['09:50', '10:40'],
    5 => ['10:40', '11:30'],
    6 => ['11:30', '12:20'],
    7 => ['12:20', '13:10'],
];
$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

$horario = [];
$materiasGrupo = [];
$materiasPendientes = [];

// Mostrar el horario actual del grupo seleccionado
if ($idGrupoSeleccionado && $accion === 'ver') {
    // Cargar horario
    $sqlHorario = "
        SELECT hg.bloque, hg.dia_semana, m.nombre_materia
        FROM horario_grupo hg
        LEFT JOIN materias m ON hg.id_materia = m.id_materia
        WHERE hg.id_grupo = $idGrupoSeleccionado
        ORDER BY hg.bloque, FIELD(hg.dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes')
    ";
    $resHorario = $conn->query($sqlHorario);
    while ($row = $resHorario->fetch_assoc()) {
        $bloque = (int)$row['bloque'];
        $horario[$bloque][$row['dia_semana']] = $row['nombre_materia'] ?? '';
    }

    // Obtener materias del grupo con maestro y horas semanales
    $sqlMaterias = "
        SELECT 
            m.id_materia,
            m.nombre_materia,
            ma.nombre_completo AS nombre_maestro,
            ms.horas_semana
        FROM grupos g
        JOIN semestres s ON g.id_semestre = s.id_semestre
        JOIN materias_semestre ms ON ms.id_semestre = s.id_semestre
        JOIN materias m ON ms.id_materia = m.id_materia
        JOIN maestros_materias_grupos mmg ON mmg.id_materia = m.id_materia AND mmg.id_grupo = g.id_grupo
        JOIN maestros ma ON ma.id_maestro = mmg.id_maestro
        WHERE g.id_grupo = $idGrupoSeleccionado
    ";
    $materiasGrupo = $conn->query($sqlMaterias)->fetch_all(MYSQLI_ASSOC);

    // Calcular bloques pendientes (si algún bloque no está asignado)
    $sqlPendientes = "
        SELECT id_materia, COUNT(*) AS pendientes
        FROM horario_grupo
        WHERE id_grupo = $idGrupoSeleccionado
        AND (id_materia IS NULL OR bloque IS NULL)
        GROUP BY id_materia
    ";
    $resPendientes = $conn->query($sqlPendientes);
    while ($row = $resPendientes->fetch_assoc()) {
        $materiasPendientes[$row['id_materia']] = (int)$row['pendientes'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Horario Alumnos</title>
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
    <h2>Horario Alumnos</h2>
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
            <label for="grupo">Selecciona un grupo:</label>
            <select name="id_grupo" id="grupo" required>
                <option value="">-- Seleccionar grupo --</option>
                <?php foreach ($gruposArr as $g): ?>
                    <option value="<?= $g['id_grupo'] ?>" <?= $idGrupoSeleccionado == $g['id_grupo'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($g['nombre_grupo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="accion" value="ver">Ver Horario</button>
            <button type="submit" formaction="generar_horario.php" formmethod="POST" name="id_grupo" value="<?= $idGrupoSeleccionado ?>">Generar Horario</button>
        </form>
    </div>

    <?php if ($idGrupoSeleccionado && $accion === 'ver'): ?>
        <h3>Horario del grupo</h3>
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
                        <td><?= $horas[0] ?> - <?= $horas[1] ?></td>
                        <?php foreach ($dias as $dia): ?>
                            <td><?= $horario[$bloque][$dia] ?? '' ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Materias asignadas al grupo</h3>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Maestro</th>
                    <th>Horas Semanales</th>
                    <th>Bloques Pendientes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materiasGrupo as $m): 
                    $idMateria = $m['id_materia'];
                    $pendientes = $materiasPendientes[$idMateria] ?? 0;
                ?>
                    <tr class="<?= $pendientes > 0 ? 'incompleto' : '' ?>">
                        <td><?= htmlspecialchars($m['nombre_materia']) ?></td>
                        <td><?= htmlspecialchars($m['nombre_maestro']) ?></td>
                        <td><?= (int)$m['horas_semana'] ?></td>
                        <td>
                            <?= $pendientes > 0 ? "$pendientes bloque(s) pendientes" : "✔ Completo" ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>
<footer>UICSLP © 2025</footer>
</body>
</html>
