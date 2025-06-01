<?php
include('conexion.php');
//Consulta los datos de la tabla en la base de datos
$sql = "SELECT a.id_alumno, a.nombre_completo, a.usuario, g.nombre_grupo, g.id_grupo
        FROM alumnos a
        JOIN grupos g ON a.id_grupo = g.id_grupo";


$result=$conn->query($sql);//almacena la consulta
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
</head>
<!------------------------------------------------->
<body>
<header>
    <section class="logo">
      <img src="./imgPH/logoazul.jpg" alt="logo" class="img-logo">
<h2>Lista de Alumnos</h2>
    </section>
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
<form id="buscador-form" class="buscador-form">
  <label for="filtro">Buscar por:</label>
  <select name="filtro" id="filtro" class="buscador-select">
    <option value="id_alumno">ID</option>
    <option value="nombre_completo">Nombre</option>
    <option value="nombre_grupo">Grupo</option>
  </select>
  <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="buscador-input">
 <button type="button" class="boton-registrar" onclick="abrirModal()">Registrar usuario</button>

</form>


</section>
<!------------------------------------------------>
<section id="tabla-alumnos">
<table>
<tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Grupo</th>
                <th colspan="2">Acciones</th><!--Colspan son las columnas que utiliza-->
</tr>
<?php
    if ($result->num_rows>0) {
    while($row=$result->fetch_assoc()){
        echo"<tr>
        <td>".$row['id_alumno']."</td>
        <td>".$row['nombre_completo']."</td>
        <td>".$row['usuario']."</td>
        <td>".htmlspecialchars($row['nombre_grupo'])."</td>
        <td><a href='eliminar.php?id=".$row['id_alumno']."'>Eliminar</a></td>
        <td><a href='#' onclick='editarAlumno(".$row['id_alumno'].", \"".addslashes($row['nombre_completo'])."\",
         \"".addslashes($row['usuario'])."\", ".$row['id_grupo'].")'>Actualizar</a>
        </td>

        </tr>";
        }
    }
?>
</table>
</section>
</main>
<footer>UICSLP © 2025 </footer>

<!------------- SCRIPT PARA EL FILTRO DE BUSQUEDA ------------------------>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const filtro = document.getElementById('filtro');
  const buscar = document.getElementById('buscar');

  function buscarAlumnos() {
    const filtroValor = filtro.value;
    const texto = buscar.value;

    fetch('buscar_alumnos.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `filtro=${encodeURIComponent(filtroValor)}&buscar=${encodeURIComponent(texto)}`
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('tabla-alumnos').innerHTML = data;
    });
  }

  buscar.addEventListener('keyup', buscarAlumnos);
  filtro.addEventListener('change', buscarAlumnos);
});
</script>
<!-----------------MODAL PARA REGISTRO-------------------------------->
<!-- MODAL -->
<div id="modal-registro" class="modal">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModal()">&times;</span>
    <h3>Registrar nuevo alumno</h3>
    <form action="guardar_alumno.php" method="post">
      <label>Nombre completo:</label>
      <input type="text" name="nombre_completo" required>

      <label>Usuario:</label>
      <input type="text" name="usuario" required>

      <label>Contraseña:</label>
      <input type="password" name="contrasena" required>

      <label>Grupo:</label>
      <select name="id_grupo" required>
        <?php
        // Mostrar los grupos desde la BD
        $grupos = $conn->query("SELECT id_grupo, nombre_grupo FROM grupos");
        while ($grupo = $grupos->fetch_assoc()) {
          echo "<option value='{$grupo['id_grupo']}'>{$grupo['nombre_grupo']}</option>";
        }
        ?>
      </select>

      <input type="submit" value="Registrar">
    </form>
  </div>
</div>
<!-----------------SCRIPT PARA ABRIR EL MODAL-------------------------------->
<script>
function abrirModal() {
  document.getElementById('modal-registro').style.display = 'flex';
}

function cerrarModal() {
  document.getElementById('modal-registro').style.display = 'none';
}

// También cierra el modal si haces clic fuera del cuadro
window.onclick = function(e) {
  const modal = document.getElementById('modal-registro');
  if (e.target === modal) {
    cerrarModal();
  }
}
</script>
<script>
function editarAlumno(id, nombre, usuario, id_grupo) {
  abrirModal(); // Muestra el modal
  document.querySelector("#modal-registro h3").innerText = "Actualizar alumno";
  document.querySelector("input[name='nombre_completo']").value = nombre;
  document.querySelector("input[name='usuario']").value = usuario;
  document.querySelector("select[name='id_grupo']").value = id_grupo;

  // Cambiar acción del formulario
  const form = document.querySelector("#modal-registro form");
  form.action = "actualizar_alumno.php";

  // Añadir campo oculto con el id
  if (!document.querySelector("input[name='id_alumno']")) {
    const inputHidden = document.createElement("input");
    inputHidden.type = "hidden";
    inputHidden.name = "id_alumno";
    inputHidden.value = id;
    form.appendChild(inputHidden);
  } else {
    document.querySelector("input[name='id_alumno']").value = id;
  }

  // Cambiar texto del botón
  document.querySelector("input[type='submit']").value = "Actualizar";
}
</script>


</body>
</html>