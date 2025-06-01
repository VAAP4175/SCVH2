<?php
include('conexion.php');

// Consulta los datos de la tabla en la base de datos
$sql = "
SELECT m.id_materia, m.nombre_materia, s.numero AS semestre, s.id_semestre
FROM materias m
LEFT JOIN materias_semestre ms ON m.id_materia = ms.id_materia
LEFT JOIN semestres s ON ms.id_semestre = s.id_semestre
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="tabla.css">
    <link rel="stylesheet" href="menu_adm.css">
    <style>

        /* Estilos para el modal */
        .modal {
  display: none;
  position: fixed;
  z-index: 999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  justify-content: center;
  align-items: center;
}

.modal-contenido {
  background: white;
  padding: 25px;
  border-radius: 8px;
  width: 400px;
  max-width: 95%;
  box-shadow: 0 0 15px rgba(0,0,0,0.3);
  position: relative;
}

.modal-contenido h3 {
  margin-top: 0;
  text-align: center;
}

.modal-contenido label {
  display: block;
  margin-top: 10px;
}

.modal-contenido input,
.modal-contenido select {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.modal-contenido input[type="submit"] {
  background-color: #143b66;
  color: white;
  border: none;
  margin-top: 15px;
  cursor: pointer;
}

.cerrar {
  position: absolute;
  top: 10px; right: 15px;
  font-size: 20px;
  cursor: pointer;
}
/* Estilos para el buscador */
        .buscador-form {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 20px auto;
  justify-content: center;
  flex-wrap: wrap;
}

.buscador-select,
.buscador-input {
  padding: 8px 12px;
  font-size: 16px;
  border: 2px solid #143b66;
  border-radius: 6px;
  outline: none;
  transition: 0.3s ease;
}

.buscador-input:focus,
.buscador-select:focus {
  border-color: #e27823;
  box-shadow: 0 0 5px rgba(226, 120, 35, 0.5);
}

.boton-registrar {
  background-color: #28a745;
  color: white;
  padding: 8px 15px;
  font-size: 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.boton-registrar:hover {
  background-color: #218838;
}

    </style>
    <script>
        
function abrirModal(id, nombre, semestre) {
    console.log("Editando:", id, nombre, semestre); // Depuración

    document.getElementById('modal-editar').style.display = 'flex';
    document.querySelector("input[name='id_materia']").value = id;
    document.querySelector("input[name='nombre_materia']").value = nombre;
    document.querySelector("select[name='id_semestre']").value = semestre;
}

document.addEventListener('DOMContentLoaded', function () {
    const filtro = document.getElementById('filtro');
    const buscar = document.getElementById('buscar');

    function buscarMaterias() {
        const filtroValor = filtro.value;
        const texto = buscar.value;

        fetch('buscar_M.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `filtro=${encodeURIComponent(filtroValor)}&buscar=${encodeURIComponent(texto)}`
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('tabla-materias').innerHTML = data;
        })
        .catch(error => console.log("Error en la búsqueda:", error));
    }

    buscar.addEventListener('keyup', buscarMaterias);
    filtro.addEventListener('change', buscarMaterias);
});
</script>

</head>
<!------------------------------------------------->
<body>
<header>
<h2>Lista de materias</h2>
</header>

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
<!------------------------------------------------->
<section class="secregistroG">
<!------------------------------------------------->

    <form id="form-busqueda">
        <label for="filtro">Buscar por:</label>
        <select id="filtro">
            <option value="id">ID</option>
            <option value="nombre">Nombre</option>
            <option value="semestre">Semestre</option>
        </select>
        <input type="text" id="buscar" placeholder="Buscar..." required>
        <button type="button" onclick="abrirModalRegistro()">Registrar Materia</button>
    </form>

    <div id="modal-registro" class="modal">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarModalRegistro()">&times;</span>
        <h3>Registrar Nueva Materia</h3>
        <form action="guardar_materia.php" method="post">
            <label>Nombre de la materia:</label>
            <input type="text" name="nombre_materia" required>

            <label>Semestre:</label>
            <select name="id_semestre">
                <?php
                $semestres = $conn->query("SELECT id_semestre, numero FROM semestres");
                while ($sem = $semestres->fetch_assoc()) {
                    echo "<option value='{$sem['id_semestre']}'>{$sem['numero']}° semestre</option>";
                }
                ?>
            </select>

            <input type="submit" value="Registrar">
        </form>
    </div>
</div>
<script>
function abrirModalRegistro() {
    document.getElementById('modal-registro').style.display = 'flex';
}

function cerrarModalRegistro() {
    document.getElementById('modal-registro').style.display = 'none';
}

// También cierra el modal si haces clic fuera del cuadro
window.onclick = function(e) {
    const modal = document.getElementById('modal-registro');
    if (e.target === modal) {
        cerrarModalRegistro();
    }
}
</script>

</section>

<section>
<table id="tabla-materias">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Semestre</th>
    <th>Acciones</th>
</tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id_materia']}</td>
            <td>{$row['nombre_materia']}</td>
            <td>{$row['semestre']}°</td>
            <td>
                <button onclick=\"abrirModal('{$row['id_materia']}', '{$row['nombre_materia']}', '{$row['id_semestre']}')\">✏️ Editar</button>
                <a href='eliminar_M.php?id={$row['id_materia']}'>❌ Eliminar</a>
            </td>
        </tr>";
    }
}
?>
</table>
</section>

<!------------- SCRIPT PARA EL FILTRO DE BUSQUEDA ------------------------>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const filtro = document.getElementById('filtro');
  const buscar = document.getElementById('buscar');

  function buscarMaterias() {
    const filtroValor = filtro.value;
    const texto = buscar.value;

    fetch('buscar_materias.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `filtro=${encodeURIComponent(filtroValor)}&buscar=${encodeURIComponent(texto)}`
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('tabla-materias').innerHTML = data;
    });
  }

  buscar.addEventListener('keyup', buscarMaterias);
  filtro.addEventListener('change', buscarMaterias);
});
</script>

<!-----------------MODAL PARA EDITAR MATERIAS-------------------------------->
<div id="modal-editar" class="modal">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarModal()">&times;</span>
        <h3>Actualizar Materia</h3>
        <form action="" method="post">
            <input type="hidden" name="id_materia">
            
            <label>Nombre de la materia:</label>
            <input type="text" name="nombre_materia" required>

            <label>Semestre:</label>
            <select name="id_semestre">
                <?php
                $semestres = $conn->query("SELECT id_semestre, numero FROM semestres");
                while ($sem = $semestres->fetch_assoc()) {
                    echo "<option value='{$sem['id_semestre']}'>{$sem['numero']}° semestre</option>";
                }
                ?>
            </select>

            <input type="submit" value="Actualizar">
            <?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materia = $_POST['id_materia'];
    $nombre_materia = $_POST['nombre_materia'];
    $id_semestre = $_POST['id_semestre'];

    // Validaciones básicas antes de actualizar
    if (!empty($id_materia) && !empty($nombre_materia) && !empty($id_semestre)) {
        $conn->query("UPDATE materias SET nombre_materia = '$nombre_materia' WHERE id_materia = $id_materia");
        $conn->query("UPDATE materias_semestre SET id_semestre = $id_semestre WHERE id_materia = $id_materia");

        echo "<script>alert('Materia actualizada correctamente.'); window.location.href='adm_materias.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error: Todos los campos son obligatorios.'); window.history.back();</script>";
    }
}
?>

        </form>
    </div>
</div>

<!-----------------SCRIPT PARA ABRIR Y CERRAR EL MODAL-------------------------------->
<script>
function abrirModal(id, nombre, semestre) {
  document.getElementById('modal-editar').style.display = 'flex';

  // Insertar valores en los campos del formulario
  document.querySelector("input[name='id_materia']").value = id;
  document.querySelector("input[name='nombre_materia']").value = nombre;
  document.querySelector("select[name='id_semestre']").value = semestre;

  // Cambiar el título del modal
  document.querySelector("#modal-editar h3").innerText = "Actualizar Materia";
}

function cerrarModal() {
  document.getElementById('modal-editar').style.display = 'none';
}

// También cierra el modal si haces clic fuera del cuadro
window.onclick = function(e) {
  const modal = document.getElementById('modal-editar');
  if (e.target === modal) {
    cerrarModal();
  }
}
</script>
</section>
</main>
<footer>UICSLP © 2025 </footer>
</body>
</html>