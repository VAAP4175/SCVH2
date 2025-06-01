<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id_maestro'])) {
  header("Location: index.php");
  exit();
}

$id_maestro = $_SESSION['id_maestro'];

// Recoger los datos del formulario
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
$estado_civil     = $_POST['estado_civil'] ?? null;
$telefono         = $_POST['telefono'] ?? null;
$correo           = $_POST['correo'] ?? null;
$calle            = $_POST['calle'] ?? null;
$colonia          = $_POST['colonia'] ?? null;
$municipio        = $_POST['municipio'] ?? null;
$estado           = $_POST['estado'] ?? null;

// Verificar si ya existe un registro
$check = $conn->prepare("SELECT id_datos FROM maestros_datos WHERE id_maestro = ?");
$check->bind_param("i", $id_maestro);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  // Actualizar si ya existe
  $stmt = $conn->prepare("UPDATE maestros_datos SET 
    fecha_nacimiento = ?, estado_civil = ?, telefono = ?, correo = ?, 
    calle = ?, colonia = ?, municipio = ?, estado = ?
    WHERE id_maestro = ?");
  $stmt->bind_param("ssssssssi", $fecha_nacimiento, $estado_civil, $telefono, $correo,
                                 $calle, $colonia, $municipio, $estado, $id_maestro);
} else {
  // Insertar si no existe
  $stmt = $conn->prepare("INSERT INTO maestros_datos 
    (id_maestro, fecha_nacimiento, estado_civil, telefono, correo, calle, colonia, municipio, estado)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("issssssss", $id_maestro, $fecha_nacimiento, $estado_civil, $telefono, $correo,
                                   $calle, $colonia, $municipio, $estado);
}

if ($stmt->execute()) {
  header("Location: panel_general_maestro.php?seccion=inicio&actualizado=1");
  exit();
} else {
  echo "Error al guardar los datos.";
}