<?php
require 'conexion.php';

$inicio = $_GET["inicio"];
$fin = $_GET["fin"];

$sql = "SELECT nombre, motivo, fecha, hora FROM reservacion WHERE fecha BETWEEN '$inicio' AND '$fin'";
$result = $conn->query($sql);

$reservas = [];
while ($row = $result->fetch_assoc()) {
    // Recorta la hora a formato "HH:MM" para que coincida con el JavaScript
    $row["hora"] = substr($row["hora"], 0, 5);
    $reservas[] = $row;
}

echo json_encode($reservas);
$conn->close();
?>
