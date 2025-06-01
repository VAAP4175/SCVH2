<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['id_materia'] as $hora => $dias) {
        foreach ($dias as $dia => $id_materia) {
            // Verificar que la materia pertenece al semestre correcto
            $validacion = $conn->query("
                SELECT id_materia FROM materias_semestre 
                WHERE id_materia = $id_materia
            ");

            if ($validacion->num_rows > 0) {
                // Actualizar el horario con la nueva materia
                $conn->query("
                    UPDATE horarios SET id_materia = $id_materia
                    WHERE hora_inicio = '$hora' AND dia_semana = '$dia'
                ");
            }
        }
    }

    echo "<script>alert('Horario actualizado correctamente.'); window.location.href='index.php';</script>";
    exit;
}
?>
