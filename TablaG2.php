<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Horario sala de computo</title>
  <link rel="stylesheet" href="panel_general_alumno.css">
</head>
<body>

  <header>
    <h1>Bienvenido al Panel del Administrador</h1>
  </header>

  <div class="container">
    <nav>
      <img src="login_logo.png" alt="Logo UICSLP" class="logo">
      <h2>Panel de Administradores</h2>
      <ul>
        <li><a href="panel_general_admin.php">Inicio</a></li>
       <li><a href="panel_admin.php">Editar Calificaciones</a></li>
        <li><a href="TAblaG.html">Reservar sala de computo</a></li>
        <li><a href="logout.php">Salir</a></li>
      </ul>
    </nav>

    <main>
      <?php
      $seccion = $_GET['seccion'] ?? 'inicio';
      if ($seccion === 'inicio') {
    include('TAblaG.html');
  }  elseif ($seccion === 'editar') 
 

      
  ?>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 Universidad Intercultural de Tamuín, SLP</p>
  </footer>

</body>
</html>
