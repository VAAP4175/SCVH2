<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_grupo = (int)$_POST['id_grupo'];
    $horario = $_POST['horario'] ?? [];

    // Limpiar el horario anterior (opcional)
    // Podrías usar DELETE si quieres reiniciar completamente:
    // $conn->query("DELETE FROM horario_grupo WHERE id_grupo = $id_grupo");

    // O actualizas bloque por bloque:
    foreach ($horario as $dia => $bloques) {
        foreach ($bloques as $bloque => $id_materia) {
            // Borra el registro si está vacío
            if (empty($id_materia)) {
                $stmt = $conn->prepare("
                    DELETE FROM horario_grupo 
                    WHERE id_grupo = ? AND dia_semana = ? AND bloque = ?
                ");
                $stmt->bind_param("isi", $id_grupo, $dia, $bloque);
                $stmt->execute();
                $stmt->close();
            } else {
                // Verifica si existe ya un registro
                $stmt = $conn->prepare("
                    SELECT COUNT(*) 
                    FROM horario_grupo 
                    WHERE id_grupo = ? AND dia_semana = ? AND bloque = ?
                ");
                $stmt->bind_param("isi", $id_grupo, $dia, $bloque);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count > 0) {
                    // Actualizar
                    $stmt = $conn->prepare("
                        UPDATE horario_grupo 
                        SET id_materia = ? 
                        WHERE id_grupo = ? AND dia_semana = ? AND bloque = ?
                    ");
                    $stmt->bind_param("iisi", $id_materia, $id_grupo, $dia, $bloque);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // Insertar
                    $stmt = $conn->prepare("
                        INSERT INTO horario_grupo (id_grupo, dia_semana, bloque, id_materia) 
                        VALUES (?, ?, ?, ?)
                    ");
                    $stmt->bind_param("isii", $id_grupo, $dia, $bloque, $id_materia);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }

    header("Location: adm_horarios.php?id_grupo=$id_grupo&success=1");
    exit();
}
?>
