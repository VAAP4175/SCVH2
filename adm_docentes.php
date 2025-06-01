<?php
include('conexion.php');
//Consulta los datos de la tabla en la base de datos
$sql="SELECT id_maestro,nombre_completo, usuario FROM maestros";
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
</head>
<!------------------------------------------------->
<body>
<header>
<section class="logo">
      <img src="./imgPH/logoazul.jpg" alt="logo" class="img-logo">
<h2>Lista de Docentes</h2>
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
<form action="buscar_docente.php" method="post">
<label for="filtro">Buscar por:</label>
<select name="filtro" id="">
    <option value="id_maestro">ID</option>
    <option value="nombre">Nombre</option>
</select>
<input type="text" name="buscar" placeholder="Buscar..." required>
<input type="submit" value="buscar">
<button type="submit" onclick="window.location.href='registro_docente.php'">Registar usuario</button>
</form>
</section>
<!------------------------------------------------>
<section>
<table>
<tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th colspan="2">Acciones</th><!--Colspan son las columnas que utiliza-->
</tr>
<?php
    if ($result->num_rows>0) {
    while($row=$result->fetch_assoc()){
        echo"<tr>
        <td>".$row['id_maestro']."</td>
        <td>".$row['nombre_completo']."</td>
        <td>".$row['usuario']."</td>
       
        <td><a href='eliminar.php?id=".$row['id_maestro']."'>Eliminar</a></td>
        <td><a href='#' onclick='editarAlumno(".$row['id_maestro'].", \"".addslashes($row['nombre_completo'])."\",
         \"".addslashes($row['usuario']).")'>Actualizar</a>
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
    <h3>Registrar nuevo Docente</h3>
    <form action="guardar_alumno.php" method="post">
      <label>Nombre completo:</label>
      <input type="text" name="nombre_completo" required>

      <label>Usuario:</label>
      <input type="text" name="usuario" required>

      <label>Contraseña:</label>
      <input type="password" name="contrasena" required>

    
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
  document.querySelector("#modal-registro h3").innerText = "Actualizar docente";
  document.querySelector("input[name='nombre_completo']").value = nombre;
  document.querySelector("input[name='usuario']").value = usuario;
  

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