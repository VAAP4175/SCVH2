<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id_maestro'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel del Maestro</title>
  <link rel="stylesheet" href="panel_general_alumno.css">
</head>
<body>

  <header>
    <h1>Bienvenido al Panel del Maestro</h1>
  </header>

  <div class="container">
    <nav>
      <img src="logo.png" alt="Logo UICSLP" class="logo">
      <h2>Panel Maestro</h2>
      <ul>
        <li><a href="panel_general_maestro.php?seccion=inicio">Inicio</a></li>
        <li><a href="panel_general_maestro.php?seccion=editar">Editar Perfil</a></li>
        <li><a href="panel_general_maestro.php?seccion=Calendario">Calendario Escolar</a></li>
        <li><a href="cambiar_contrasena.php">Cambiar contraseña</a></li>
        <li><a href="panel_maestro.php">Subir Calificaciones</a></li>
        <li><a href="TAblaGG.php">Reservar la sala de computo</a></li>
        <li><a href="panel_general_maestro.php?seccion=disponibilidad">Disponibilidad de horarios</a></li>
        <li><a href="panel_general_maestro.php?seccion=selectMaterias">Materias Semestrales</a></li>
        <li><a href="logout.php">Salir</a></li>
      </ul>
    </nav>

    <main>
  <?php
  $seccion = $_GET['seccion'] ?? 'inicio';
  if ($seccion === 'inicio') {
    include('inicio_maestro.php');
  }  elseif ($seccion === 'editar'){
    include ( 'editar_datos_maestro.php');
  }elseif ($seccion === 'disponibilidad') {
    include ( 'disponibilidad_horasL.php');
  }elseif ($seccion === 'selectMaterias') {
    include ( 'selector_materias.php');
  }elseif ($seccion === 'Calendario') {
    include ( 'calendario.php');
  }

      
  ?>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 Universidad Intercultural de Tamuín, SLP</p>
  </footer>

</body>
</html>