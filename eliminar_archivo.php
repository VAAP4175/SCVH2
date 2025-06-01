<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_archivo = intval($_GET['id']);

    // Obtener el nombre del archivo antes de eliminar
    $stmt = $conn->prepare("SELECT nombre_excel FROM archivos_calificaciones WHERE id_archivo = ?");
    $stmt->bind_param("i", $id_archivo);
    $stmt->execute();
    $stmt->bind_result($nombre_excel);
    $stmt->fetch();
    $stmt->close();

    if ($nombre_excel) {
        $ruta = "archivos_excel/" . $nombre_excel;

        // Borrar registro en la base de datos (activará el trigger)
        $stmt = $conn->prepare("DELETE FROM archivos_calificaciones WHERE id_archivo = ?");
        $stmt->bind_param("i", $id_archivo);
        $stmt->execute();
        $stmt->close();

        // Borrar archivo físico del servidor si existe
        if (file_exists($ruta)) {
            unlink($ruta);
        }

        echo "<script>alert('Archivo y calificaciones eliminados correctamente.'); window.location='panel_admin.php';</script>";
    } else {
        echo "<script>alert('No se encontró el archivo.'); window.location='panel_admin.php';</script>";
    }
} else {
    echo "<script>alert('Falta el parámetro ID.'); window.location='panel_admin.php';</script>";
}
?>
