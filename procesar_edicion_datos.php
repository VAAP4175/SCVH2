<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id_alumno'])) {
  header("Location: index.php");
  exit();
}

$id_alumno = $_SESSION['id_alumno'];

// Recoger datos del formulario
$nacimiento     = $_POST['nacimiento'] ?? null;
$estado_civil   = $_POST['estado_civil'] ?? null;
$telefono       = $_POST['telefono'] ?? null;
$correo         = $_POST['correo'] ?? null;
$calle          = $_POST['calle'] ?? null;
$colonia        = $_POST['colonia'] ?? null;
$municipio      = $_POST['municipio'] ?? null;
$estado         = $_POST['estado'] ?? null;

// Verificar si ya existen datos previos
$check = $conn->prepare("SELECT id_datos FROM datos_alumno WHERE id_alumno = ?");
$check->bind_param("i", $id_alumno);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  // Actualizar si ya existen
  $stmt = $conn->prepare("UPDATE datos_alumno SET 
    nacimiento = ?, estado_civil = ?, telefono = ?, correo = ?, 
    calle = ?, colonia = ?, municipio = ?, estado = ?
    WHERE id_alumno = ?");
  $stmt->bind_param("ssssssssi", $nacimiento, $estado_civil, $telefono, $correo,
                                $calle, $colonia, $municipio, $estado, $id_alumno);
} else {
  // Insertar si no existen
  $stmt = $conn->prepare("INSERT INTO datos_alumno 
    (id_alumno, nacimiento, estado_civil, telefono, correo, calle, colonia, municipio, estado)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("issssssss", $id_alumno, $nacimiento, $estado_civil, $telefono, $correo,
                                   $calle, $colonia, $municipio, $estado);
}

if ($stmt->execute()) {
  header("Location: panel_general_alumno.php?seccion=inicio&actualizado=1");
  exit();
} else {
  echo "Error al guardar los datos.";
}