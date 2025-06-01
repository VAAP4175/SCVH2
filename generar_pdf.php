<?php
session_start();
require 'conexion.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_SESSION['id_alumno'])) {
    die("No autorizado");
}

$id_alumno = $_SESSION['id_alumno'];
$nombre = $_SESSION['nombre_completo'] ?? 'Alumno';

// Obtener grupo
$sql_grupo = "SELECT g.nombre_grupo 
              FROM alumnos a
              JOIN grupos g ON a.id_grupo = g.id_grupo
              WHERE a.id_alumno = ?";
$stmt = $conn->prepare($sql_grupo);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$res_grupo = $stmt->get_result();
$grupo = $res_grupo->fetch_assoc()['nombre_grupo'] ?? 'Desconocido';

// Obtener calificaciones
$sql = "SELECT m.nombre_materia, c.parcial, c.calificacion
        FROM calificaciones c
        JOIN materias m ON c.id_materia = m.id_materia
        WHERE c.id_alumno = ?
        ORDER BY m.nombre_materia, c.parcial";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$res = $stmt->get_result();

$calificaciones = [];
while ($row = $res->fetch_assoc()) {
    $materia = $row['nombre_materia'];
    $parcial = $row['parcial'];
    $nota = $row['calificacion'];
    $calificaciones[$materia][$parcial] = $nota;
}

// Crear contenido HTML para PDF
$html = "<style>
            h2, h3 { text-align: center; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid black; padding: 6px; text-align: center; }
            th { background-color: #f2f2f2; }
        </style>";

$html .= "<h2>Calificaciones de $nombre</h2>";
$html .= "<h3>Grupo: $grupo</h3>";
$html .= "<table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>1°</th>
                    <th>2°</th>
                    <th>3°</th>
                    <th>Final</th>
                </tr>
            </thead>
            <tbody>";

foreach ($calificaciones as $materia => $parciales) {
    $html .= "<tr>
                <td>$materia</td>
                <td>" . ($parciales[1] ?? '-') . "</td>
                <td>" . ($parciales[2] ?? '-') . "</td>
                <td>" . ($parciales[3] ?? '-') . "</td>
                <td>" . ($parciales[4] ?? '-') . "</td>
              </tr>";
}

$html .= "</tbody></table>";

// Configurar Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Descargar PDF
$dompdf->stream("calificaciones_$nombre.pdf", ["Attachment" => true]);
?>
