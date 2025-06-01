<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $descripcion = $_POST["descripcion"];
    $usuario = $_POST["usuario"];

    $stmt = $conn->prepare("INSERT INTO reservas (fecha, hora, descripcion, usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fecha, $hora, $descripcion, $usuario);

    if ($stmt->execute()) {
        echo "<script>alert('Reserva guardada con éxito'); window.location.href='calendario.html';</script>";
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
