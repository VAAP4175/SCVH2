<?php
include("conexion.php");

$sql = "SELECT fecha, descripcion FROM reservas";
$result = $conn->query($sql);

$fechas = [];
while ($row = $result->fetch_assoc()) {
    $fechas[] = [
        "fecha" => $row['fecha'],
        "descripcion" => $row['descripcion']
    ];
}

header('Content-Type: application/json');
echo json_encode($fechas);
?>
