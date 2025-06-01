<?php
include 'conexion.php';

// Definir bloques horarios
$bloques = [
    1 => ['07:00:00', '07:50:00'],
    2 => ['07:50:00', '08:40:00'],
    3 => ['08:40:00', '09:30:00'],
    4 => ['09:50:00', '10:40:00'],
    5 => ['10:40:00', '11:30:00'],
    6 => ['11:30:00', '12:20:00'],
    7 => ['12:20:00', '13:10:00'],
];
$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

// Validar ID de grupo
if (!isset($_POST['id_grupo'])) {
    die("Grupo no especificado.");
}
$idGrupoSeleccionado = $_POST['id_grupo'];

// Obtener materias del grupo
$sql = "
    SELECT 
        g.id_grupo, 
        mmg.id_maestro, 
        m.id_materia, 
        ms.horas_semana
    FROM grupos g
    JOIN semestres s ON g.id_semestre = s.id_semestre
    JOIN materias_semestre ms ON s.id_semestre = ms.id_semestre
    JOIN materias m ON ms.id_materia = m.id_materia
    JOIN maestros_materias_grupos mmg 
        ON mmg.id_grupo = g.id_grupo 
        AND mmg.id_materia = m.id_materia
    JOIN maestros_materias_perfil mp
        ON mp.id_maestro = mmg.id_maestro
        AND mp.id_materia = mmg.id_materia
        AND mp.estado = 'aprobado'
    WHERE g.id_grupo = $idGrupoSeleccionado
";
$materias = $conn->query($sql);

// Obtener disponibilidad de maestros
$disponibilidadRaw = $conn->query("
    SELECT id_maestro, hora_inicio, hora_fin
    FROM disponibilidad_maestros
");
$disponibilidad = [];
while ($d = $disponibilidadRaw->fetch_assoc()) {
    $disponibilidad[$d['id_maestro']][] = $d;
}

// Función para validar la disponibilidad del maestro
function maestroDisponible($id_maestro, $hora_inicio, $hora_fin, $disponibilidad) {
    if (!isset($disponibilidad[$id_maestro])) return false;
    foreach ($disponibilidad[$id_maestro] as $slot) {
        if ($hora_inicio >= $slot['hora_inicio'] && $hora_fin <= $slot['hora_fin']) {
            return true;
        }
    }
    return false;
}

// Inicializar estructuras
$asignados = [];
$ocupadoGrupo = [];
$ocupadoMaestro = [];
$materiaPorDia = []; // [id_grupo][id_materia][dia] => count

// Consultar ocupaciones existentes para el maestro
$res = $conn->query("
    SELECT id_maestro, dia_semana, bloque
    FROM horario_grupo
    WHERE id_maestro IS NOT NULL
");
while ($fila = $res->fetch_assoc()) {
    $claveMaestro = "{$fila['id_maestro']}-{$fila['dia_semana']}-{$fila['bloque']}";
    $ocupadoMaestro[$claveMaestro] = true;
}

// 🔧 Asignar bloques de horario
while ($mat = $materias->fetch_assoc()) {
    $id_grupo = $mat['id_grupo'];
    $id_maestro = $mat['id_maestro'];
    $id_materia = $mat['id_materia'];
    $horas_necesarias = (int)$mat['horas_semana'];

    // 📝 Consulta cuántos bloques ya tiene esta materia asignada
    $stmtExistentes = $conn->prepare("
        SELECT COUNT(*) AS asignados
        FROM horario_grupo
        WHERE id_grupo = ? AND id_materia = ? AND id_maestro = ? AND dia_semana IS NOT NULL AND bloque IS NOT NULL
    ");
    $stmtExistentes->bind_param("iii", $id_grupo, $id_materia, $id_maestro);
    $stmtExistentes->execute();
    $resExistentes = $stmtExistentes->get_result();
    $rowExistentes = $resExistentes->fetch_assoc();
    $asignadosExistentes = (int)$rowExistentes['asignados'];

    // Ajustar horas necesarias
    $horas_restantes = $horas_necesarias - $asignadosExistentes;
    if ($horas_restantes <= 0) {
        continue; // Ya están completas, no asignar más
    }

    $asignadosBloques = 0;

    foreach ($dias as $dia) {
        for ($b = 1; $b <= 7; $b++) {
            if ($asignadosBloques >= $horas_restantes) break;

            // Limitar a máximo 2 bloques por día para la misma materia
            if (!isset($materiaPorDia[$id_grupo][$id_materia][$dia])) {
                $materiaPorDia[$id_grupo][$id_materia][$dia] = 0;
            }
            if ($materiaPorDia[$id_grupo][$id_materia][$dia] >= 2) continue;

            $hora_inicio = $bloques[$b][0];
            $hora_fin = $bloques[$b][1];

            $claveGrupo = "$id_grupo-$dia-$b";
            $claveMaestro = "$id_maestro-$dia-$b";

            if (isset($ocupadoGrupo[$claveGrupo]) || isset($ocupadoMaestro[$claveMaestro])) continue;

            if (maestroDisponible($id_maestro, $hora_inicio, $hora_fin, $disponibilidad)) {
                $asignados[] = [$id_grupo, $id_maestro, $id_materia, $dia, $b, $hora_inicio, $hora_fin];
                $ocupadoGrupo[$claveGrupo] = true;
                $ocupadoMaestro[$claveMaestro] = true;
                $materiaPorDia[$id_grupo][$id_materia][$dia]++;
                $asignadosBloques++;
            }
        }
    }

    // 🔧 Inserción de bloques vacíos si faltan horas
    if ($asignadosBloques < $horas_restantes) {
        $faltantes = $horas_restantes - $asignadosBloques;
        for ($i = 0; $i < $faltantes; $i++) {
            $stmt = $conn->prepare("
                INSERT INTO horario_grupo 
                (id_grupo, id_maestro, id_materia, dia_semana, bloque, hora_inicio, hora_fin) 
                VALUES (?, NULL, ?, NULL, NULL, NULL, NULL)
            ");
            $stmt->bind_param("ii", $id_grupo, $id_materia);
            $stmt->execute();
        }
    }
}


// 🔧 Guardar horarios asignados
foreach ($asignados as $fila) {
    list($id_grupo, $id_maestro, $id_materia, $dia, $bloque, $hora_inicio, $hora_fin) = $fila;
    $stmt = $conn->prepare("
        INSERT INTO horario_grupo 
        (id_grupo, id_maestro, id_materia, dia_semana, bloque, hora_inicio, hora_fin) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iiisiss", $id_grupo, $id_maestro, $id_materia, $dia, $bloque, $hora_inicio, $hora_fin);
    $stmt->execute();
}

echo "<h2>Horario generado exitosamente para el grupo ID $idGrupoSeleccionado.</h2>";
echo "<a href='adm_horarios.php'>Volver</a>";
?>
