<?php
include "conexion.php";

// Captura el semestre seleccionado (POST tiene prioridad)
$id_semestre = $_POST['id_semestre'] ?? $_GET['id_semestre'] ?? '';

// Guardar cambios cuando el formulario se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['horas'])) {
    foreach ($_POST['horas'] as $id_materia => $horas) {
        $conn->query("UPDATE materias_semestre SET horas_semana = $horas WHERE id_materia = $id_materia");
    }
    echo "<p style='color:green;'>Horas actualizadas correctamente.</p>";
}

// Obtener lista de semestres
$semestres = $conn->query("SELECT id_semestre, numero FROM semestres");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configurar Horas Semanales</title>
     <link rel="stylesheet" href="tabla.css">
    <link rel="stylesheet" href="menu_adm.css">
    <style>
main{
    margin-bottom: 60px;
}

.buscador-form {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 20px auto;
  justify-content: center;
  flex-wrap: wrap;
}

.buscador-select {
  padding: 8px 12px;
  font-size: 16px;
  border: 2px solid #143b66;
  border-radius: 6px;
  outline: none;
  transition: 0.3s ease;
}

.buscador-select:focus {
  border-color: #e27823;
  box-shadow: 0 0 5px rgba(226, 120, 35, 0.5);
}

    </style>
</head>
<body>
    <header> <h2>Asignar Horas Semanales por Materia</h2></header>
    <aside class="sidebar">
    <ul class="menu">
        <li class="active" onclick="window.location.href='inicio_adm.php'"><i>🏠</i>Inicio</li>
        <li class="submenu">
            <i>👤</i>Usuarios
            <ul class="submenu-list">
                <li onclick="window.location.href='adm_usuarios.php'"><i>🔐</i>Administrador</li>
                <li onclick="window.location.href='adm_docentes.php'"><i>🖊️</i>Docentes</li>
                <li onclick="window.location.href='adm_alumnos.php'"><i>🎓</i>Alumnos</li>
            </ul>
        </li>

        <li onclick="window.location.href='adm_grupos.php'"><i>📜</i>Grupos</li>
        <li class="submenu">
            <i>📄</i>Horarios
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_horarios.php'"><i>📝</i>Horarios Alumnos</li>
        <li onclick="window.location.href='adm_horarios_D.php'"><i>📑</i>Horarios Docentes</li>
          </ul>
        </li>

        <li class="submenu">
            <i>📚</i>Materias
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_materias.php'"><i>📘</i>Materias</li>
        <li onclick="window.location.href='configurar_horas.php'"><i>⏱</i>Horas por semana</li>
        <li onclick="window.location.href='adm_materias_docente.php'"><i>🗳</i>Solicitud Materias</li>
          </ul>
        </li>
        <li onclick="window.location.href='panel_admin.php'"><i>📂</i>Calificaciones</li>
        <li onclick="window.location.href='index.php'"><i>🔙</i>Salir</li>
    </ul>
</aside>
<main>
    <form method="post">
        <div class="buscador-form">
            <label>Filtrar por semestre:</label>
            <select name="id_semestre" onchange="this.form.submit()" class="buscador-select">
                <option value="">-- Selecciona un semestre --</option>
                <?php 
                // Vuelve a obtener la lista de semestres porque ya se hizo fetch antes
                $semestres = $conn->query("SELECT id_semestre, numero FROM semestres");
                while ($sem = $semestres->fetch_assoc()): ?>
                    <option value="<?= $sem['id_semestre'] ?>" <?= ($id_semestre == $sem['id_semestre']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sem['numero']) ?>° semestre
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Guardar Cambios</button>
        </div>

        <?php
        // Consulta de materias filtradas por semestre
        $sql = "SELECT ms.id_materia, ma.nombre_materia, ms.horas_semana 
                FROM materias_semestre ms 
                JOIN materias ma ON ms.id_materia = ma.id_materia";
        if ($id_semestre) {
            $sql .= " WHERE ms.id_semestre = $id_semestre";
        }
        $materias = $conn->query($sql);
        ?>

        <!-- Tabla de Materias -->
        <table>
            <tr>
                <th>Materia</th>
                <th>Horas por Semana</th>
            </tr>
            <?php while ($fila = $materias->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre_materia']) ?></td>
                <td>
                    <input type="number" name="horas[<?= $fila['id_materia'] ?>]" value="<?= $fila['horas_semana'] ?>" min="1">
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </form>
</main>

<footer>UICSLP © 2025 </footer>
</body>
</html>
