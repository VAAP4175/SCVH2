<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}

$id_admin = $_SESSION['id_admin'];

// Obtener nombre del administrador
$sql = "SELECT nombre_completo FROM administradores WHERE id_admin = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel del Administrador</title>
  <link rel="stylesheet" href="panel_general_alumno.css">
</head>
<body>

  <header>
    <h1>Bienvenido al Panel del Administrador</h1>
  </header>

  <div class="container">
    <nav>
      <img src="logo.png" alt="Logo UICSLP" class="logo">
      <h2>Bienvenido Administrador</h2>
      <ul>
        <li><a href="panel_general_admin.php">Inicio</a></li>
        <li><a href="panel_admin.php">Editar Calificaciones</a></li>
        <li><a href="TablaG2.php">Reservar sala de computo</a></li>
        <li><a href="logout.php">Salir</a></li>
      </ul>
    </nav>

    <main>
      <?php
      $seccion = $_GET['seccion'] ?? 'inicio';
      if ($seccion === 'inicio') {
    include('calendario.php');
  }  elseif ($seccion === 'editar') {
    include ( 'editar_datos_maestro.php');
  }

      
  ?>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 Universidad Intercultural de Tamuín, SLP</p>
  </footer>

</body>
</html>