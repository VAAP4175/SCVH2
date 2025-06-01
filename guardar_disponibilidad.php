<?php
include("conexion.php"); // Conexión a la base de datos
session_start();
if (!isset($_SESSION['id_maestro'])) {
    echo "Error: No se ha iniciado sesión.";
    exit();
}

$id_maestro = $_POST['id_maestro'];
$hora_inicio = $_POST['HoraI'];
$hora_fin = $_POST['HoraF'];

$sql = "INSERT INTO disponibilidad_maestros(id_maestro, hora_inicio, hora_fin) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id_maestro, $hora_inicio, $hora_fin);

if ($stmt->execute()) {

    echo "Disponibilidad registrada con éxito. <a href='inicio_maestro.php'>Regresar</a>";
} else {
    echo "Error: " . $conn->error;
}
?>
