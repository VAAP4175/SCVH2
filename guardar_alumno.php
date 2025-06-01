<?php
include("conexion.php");

$nombre = $_POST['nombre_completo'];
$usuario = $_POST['usuario'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$id_grupo = $_POST['id_grupo'];

$sql = "INSERT INTO alumnos (nombre_completo, usuario, contrasena, id_grupo)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $nombre, $usuario, $contrasena, $id_grupo);

if ($stmt->execute()) {
    header("Location: adm_alumnos.php");
} else {
    echo "Error al registrar alumno: " . $conn->error;
}
?>
