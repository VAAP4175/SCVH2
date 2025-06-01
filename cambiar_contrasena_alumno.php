<?php
session_start();
if (!isset($_SESSION['id_alumno'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_alumno = $_SESSION['id_alumno'];
    $actual = $_POST['actual'] ?? '';
    $nueva = $_POST['nueva'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($nueva !== $confirmar) {
        echo "<script>alert('Las contraseñas nuevas no coinciden'); window.location='cambiar_contrasena.php';</script>";
        exit();
    }

    // Verificar contraseña actual
    $sql = "SELECT contrasena FROM alumnos WHERE id_alumno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!password_verify($actual, $row['contrasena'])) {
        echo "<script>alert('La contraseña actual es incorrecta'); window.location='cambiar_contrasena.php';</script>";
        exit();
    }

    // Actualizar contraseña
    $hash_nueva = password_hash($nueva, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE alumnos SET contrasena = ? WHERE id_alumno = ?");
    $update->bind_param("si", $hash_nueva, $id_alumno);
    $update->execute();

    echo "<script>alert('Contraseña actualizada correctamente'); window.location='panel_alumno.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="cambiar_contrasena.css">
</head>
<body>
<div class="contenedor">
    <h2>🔒 Cambiar Contraseña</h2>

    <form method="post" action="">
        <label for="actual">🔐 Contraseña actual:</label>
        <input type="password" name="actual" id="actual" required>

        <label for="nueva">🆕 Nueva contraseña:</label>
        <input type="password" name="nueva" id="nueva" required>

        <label for="confirmar">✅ Confirmar nueva contraseña:</label>
        <input type="password" name="confirmar" id="confirmar" required>

        <input type="submit" value="🔁 Actualizar">
    </form>

    <a class="volver" href="panel_general_alumno.php">⬅ Volver al Panel</a>
</div>
</body>
</html>
