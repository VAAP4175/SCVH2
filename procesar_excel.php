<?php
session_start();
if (!isset($_SESSION['id_maestro'])) {
    header("Location: index.php");
    exit();
}

require 'conexion.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$id_maestro = $_SESSION['id_maestro'];

if (isset($_POST['grupo'], $_POST['materia'], $_POST['parcial']) && isset($_FILES['archivo_excel'])) {
    $id_grupo = intval($_POST['grupo']);
    $id_materia = intval($_POST['materia']);
    $parcial = intval($_POST['parcial']);

    $nombre_archivo_original = $_FILES['archivo_excel']['name'];
    $archivo_temporal = $_FILES['archivo_excel']['tmp_name'];
    $extension = pathinfo($nombre_archivo_original, PATHINFO_EXTENSION);

    if ($extension !== 'xlsx') {
        die("Solo se permiten archivos .xlsx");
    }

    // Validar relación maestro-grupo-materia
    $validar_relacion = $conn->prepare("
        SELECT 1 FROM maestros_materias_grupos 
        WHERE id_maestro = ? AND id_grupo = ? AND id_materia = ?
    ");
    $validar_relacion->bind_param("iii", $id_maestro, $id_grupo, $id_materia);
    $validar_relacion->execute();
    $validar_relacion->store_result();
    if ($validar_relacion->num_rows === 0) {
        die("Error: No tienes asignado este grupo con esta materia.");
    }
    $validar_relacion->close();

    // Validar que no se suba el mismo parcial 2 veces
    $stmt = $conn->prepare("SELECT COUNT(*) FROM archivos_calificaciones 
        WHERE id_maestro = ? AND id_grupo = ? AND id_materia = ? AND parcial = ?");
    $stmt->bind_param("iiii", $id_maestro, $id_grupo, $id_materia, $parcial);
    $stmt->execute();
    $stmt->bind_result($existe);
    $stmt->fetch();
    $stmt->close();

    if ($existe > 0) {
        die("Ya se ha subido un archivo para este grupo, materia y parcial.");
    }

    // Validar secuencia de parciales
    if ($parcial > 1) {
        $prev = $parcial - 1;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM archivos_calificaciones 
            WHERE id_maestro = ? AND id_grupo = ? AND id_materia = ? AND parcial = ?");
        $stmt->bind_param("iiii", $id_maestro, $id_grupo, $id_materia, $prev);
        $stmt->execute();
        $stmt->bind_result($conteo);
        $stmt->fetch();
        $stmt->close();

        if ($conteo == 0) {
            die("Debe subir primero el parcial anterior antes de continuar.");
        }
    }

    try {
        $spreadsheet = IOFactory::load($archivo_temporal);
        $hoja = $spreadsheet->getActiveSheet();
        $datos = $hoja->toArray();

        $col_nombre = ($parcial == 4) ? 3 : 2;
        $col_calif = ($parcial == 4) ? 8 : 9;
        $fila_inicio = ($parcial == 4) ? 24 : 16;

        $no_encontrados = [];
        $grupo_incorrecto = [];
        $calificaciones_registradas = 0;

        for ($i = $fila_inicio; $i < count($datos); $i++) {
            $nombre = isset($datos[$i][$col_nombre]) ? trim((string)$datos[$i][$col_nombre]) : '';
            $calificacion = isset($datos[$i][$col_calif]) ? floatval($datos[$i][$col_calif]) : null;

            if ($nombre && is_numeric($calificacion)) {
                $buscar = $conn->prepare("SELECT id_alumno, id_grupo FROM alumnos WHERE nombre_completo = ?");
                $buscar->bind_param("s", $nombre);
                $buscar->execute();
                $buscar->bind_result($id_alumno, $grupo_alumno);
                $tiene_resultado = $buscar->fetch();
                $buscar->close();

                if ($tiene_resultado) {
                    if ($grupo_alumno == $id_grupo) {
                        $guardar = $conn->prepare("REPLACE INTO calificaciones 
                            (id_alumno, id_maestro, id_materia, id_grupo, parcial, calificacion, fecha_registro)
                            VALUES (?, ?, ?, ?, ?, ?, NOW())");
                        $guardar->bind_param("iiiiid", $id_alumno, $id_maestro, $id_materia, $id_grupo, $parcial, $calificacion);
                        $guardar->execute();
                        $guardar->close();
                        $calificaciones_registradas++;
                    } else {
                        $grupo_incorrecto[] = $nombre;
                    }
                } else {
                    $no_encontrados[] = $nombre;
                }
            }
        }

        if ($calificaciones_registradas == 0) {
            echo "<h3>⚠️ No se guardaron calificaciones válidas. El archivo fue descartado.</h3>";
            echo "<script>alert('⚠️ No se guardaron calificaciones válidas. Verifica el grupo y la lista.');</script>";
            echo "<br><a href='panel_maestro.php'>🔙 Volver al Panel</a>";
            exit();
        }

        // Crear carpeta si no existe
        if (!is_dir('archivos_excel')) {
            mkdir('archivos_excel', 0777, true);
        }

        // Obtener nombre de la materia
        $stmt = $conn->prepare("SELECT nombre_materia FROM materias WHERE id_materia = ?");
        $stmt->bind_param("i", $id_materia);
        $stmt->execute();
        $stmt->bind_result($nombre_materia);
        $stmt->fetch();
        $stmt->close();

        // Generar nombre personalizado del archivo
        $iniciales = implode('', array_map(fn($w) => strtoupper($w[0]), explode(' ', $_SESSION['nombre_completo'])));
        $materia_abrev = strtoupper(str_replace(' ', '', substr($nombre_materia, 0, 15)));
        $nombre_final = "{$parcial}P-{$materia_abrev}-{$iniciales}.xlsx";

        $ruta = "archivos_excel/" . $nombre_final;
        move_uploaded_file($archivo_temporal, $ruta);

        // Guardar en base de datos
        $stmt = $conn->prepare("INSERT INTO archivos_calificaciones 
            (id_maestro, id_grupo, id_materia, parcial, nombre_excel, fecha_subida)
            VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiiis", $id_maestro, $id_grupo, $id_materia, $parcial, $nombre_final);
        $stmt->execute();
        $stmt->close();

        echo "<h3>✅ Calificaciones subidas correctamente.</h3>";

        if (!empty($no_encontrados)) {
            echo "<h4>❌ Alumnos no encontrados:</h4><ul>";
            foreach ($no_encontrados as $n) echo "<li>" . htmlspecialchars($n) . "</li>";
            echo "</ul>";
        }

        if (!empty($grupo_incorrecto)) {
            echo "<h4>⚠️ Alumnos en grupo incorrecto:</h4><ul>";
            foreach ($grupo_incorrecto as $n) echo "<li>" . htmlspecialchars($n) . "</li>";
            echo "</ul>";
        }

        echo "<script>alert('✅ Calificaciones subidas.');</script>";
        echo "<br><a href='panel_maestro.php'>🔙 Volver al Panel</a>";

    } catch (Exception $e) {
        die("Error al procesar el archivo Excel: " . $e->getMessage());
    }

} else {
    die("Faltan datos.");
}
?>
