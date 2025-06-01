<?php
session_start();
require 'conexion.php';

$id_admin = $_SESSION['id_admin'] ?? null;
if (!$id_admin) {
    die("Error: Sesión no válida");
}

$fecha       = $_POST['fecha'] ?? null;
$hora        = $_POST['hora'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;

if (!$fecha || !$hora || !$descripcion) {
    die("Error: Datos incompletos");
}

$sql = "INSERT INTO reservas (fecha, hora, descripcion, id_admin)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $fecha, $hora, $descripcion, $id_admin);

if ($stmt->execute()) {
    echo "<script>
    alert('Reserva guardada correctamente');
    window.location.href='panel_general_admin.php';
</script>";
exit;

} else {
    echo "Error al guardar la reserva: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
