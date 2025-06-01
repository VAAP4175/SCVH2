<?php
include "conexion.php";

$fecha = $_GET["fecha"] ?? date("Y-m-d");

$sql = "SELECT * FROM reservas WHERE fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();

$reservas = [];
while ($row = $result->fetch_assoc()) {
    $reservas[] = $row;
}

header('Content-Type: application/json');
echo json_encode($reservas);
?>
