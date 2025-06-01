<?php
ob_start();
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
include "conexion.php";

$id_maestro = $_SESSION['id_maestro'] ?? null;
if (!$id_maestro) {
    ob_end_clean();
    echo "Error de sesión";
    exit;
}

$id_periodo = $_POST['id_periodo'] ?? null;
if (!$id_periodo) {
    ob_end_clean();
    echo "Periodo no especificado.";
    exit;
}

// Obtener nombre del maestro
$stmt_nombre = $conn->prepare("SELECT nombre_completo FROM maestros WHERE id_maestro = ?");
$stmt_nombre->bind_param("i", $id_maestro);
$stmt_nombre->execute();
$res_nombre = $stmt_nombre->get_result();
$nombre_maestro = ($res_nombre->num_rows > 0) ? $res_nombre->fetch_assoc()['nombre_completo'] : 'Docente';

// Obtener nombre del periodo
$stmt_per = $conn->prepare("SELECT periodo FROM periodo_semestral WHERE id_periodo = ?");
$stmt_per->bind_param("i", $id_periodo);
$stmt_per->execute();
$res_per = $stmt_per->get_result();
$nombre_periodo = ($res_per->num_rows > 0) ? $res_per->fetch_assoc()['periodo'] : 'Desconocido';

// Obtener materias
$stmt = $conn->prepare("
SELECT 
    pf.id,
    m.nombre_materia,
    pf.fecha_registro,
    s.numero AS semestre,
    c.nombre_carrera
FROM maestros_materias_perfil pf
JOIN materias m ON pf.id_materia = m.id_materia
JOIN materias_semestre ms ON m.id_materia = ms.id_materia
JOIN semestres s ON ms.id_semestre = s.id_semestre
JOIN carreras c ON s.id_carrera = c.id_carrera
WHERE pf.id_maestro = ? AND s.id_periodo = ?
ORDER BY c.nombre_carrera, s.numero, m.nombre_materia
");
$stmt->bind_param("ii", $id_maestro, $id_periodo);
$stmt->execute();
$result = $stmt->get_result();

$datos = [];
while ($row = $result->fetch_assoc()) {
    $clave = $row['nombre_carrera'] . '-' . $row['semestre'];
    $datos[$clave][] = $row;
}

// Construir HTML
$html = "<h2 style='text-align:center;'>DISPONIBILIDAD DE MATERIAS DEL DOCENTE:<br> $nombre_maestro</h2>";
$html .= "<h3 style='text-align:center;'>PARA EL PERIODO ESCOLAR: $nombre_periodo</h3><hr>";

if (empty($datos)) {
    $html .= "<p>No se encontraron materias para este periodo.</p>";
} else {
    foreach ($datos as $grupo => $materias) {
        $semestre = $materias[0]['semestre'];
        $carrera = $materias[0]['nombre_carrera'];
        $html .= "<h3 style='color:#00125A;'>$semestre ° SEMESTRE - $carrera</h3>";
        $html .= "<table style='width:100%; border-collapse:collapse; margin-bottom:1rem;'>";
        $html .= "<thead><tr>
            <th style='border:1px solid #ccc; background:#00125A; color:white; padding:6px;'>Materia</th>
            <th style='border:1px solid #ccc; background:#00125A; color:white; padding:6px;'>Fecha de registro</th>
        </tr></thead><tbody>";
        foreach ($materias as $m) {
            $html .= "<tr>
                <td style='border:1px solid #ccc; padding:6px;'>{$m['nombre_materia']}</td>
                <td style='border:1px solid #ccc; padding:6px;'>{$m['fecha_registro']}</td>
            </tr>";
        }
        $html .= "</tbody></table>";
    }
}

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

if (ob_get_length()) {
    ob_end_clean();
}
header_remove();

$nombre_archivo = 'Materias_' . preg_replace('/\s+/', '_', $nombre_maestro) . '_' . preg_replace('/\s+/', '_', $nombre_periodo) . '.pdf';
$dompdf->stream($nombre_archivo, ["Attachment" => true]);
exit;
