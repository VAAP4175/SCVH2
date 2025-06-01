<?php
include "conexion.php";

$id_solicitud = $_GET['id'] ?? null;
$accion = $_GET['accion'] ?? null;

if ($id_solicitud && in_array($accion, ['aprobado', 'rechazado'])) {
    $stmt = $conn->prepare("UPDATE maestros_materias_perfil SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $accion, $id_solicitud);
    $stmt->execute();
    $stmt->close();
    
    header("Location: adm_materias_docente.php");
    exit;
} else {
    echo "Error: Solicitud no válida.";
}
?>
