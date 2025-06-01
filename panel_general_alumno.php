<!DOCTYPE html><html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel del Alumno</title>
  <link rel="stylesheet" href="panel_general_alumno.css">
    <style>
    main h2,h3{
        color: #00125A;
        padding-bottom: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    th {
        background-color: #00125A;
        color: white;
        text-align: left;
    }
    td, th {
        border: 1px solid #ccc;
        padding: 0.5rem;
    }
  </style>
</head>
<body>
  <header>
    <h1>Bienvenido al Panel del Alumno</h1>
  </header>  <div class="container">
    <nav>
      <img src="logo.png" alt="Logo UICSLP" class="logo">
      <h2>Panel Alumno</h2>
      <ul>
        <li><a href="panel_general_alumno.php?seccion=inicio">Inicio</a></li>
       <li><a href="panel_general_alumno.php?seccion=horario">Horario</a></li>
        <li><a href="panel_general_alumno.php?seccion=Cardex">Cardex</a></li>
        <li><a href="TablaAlumnoG.php">Horario sala de computo</a></li>
        <li><a href="panel_general_alumno.php?seccion=Calendario">Calendario Escolar</a></li>
        <li><a href="panel_alumno.php">Calificaciones</a></li>
        <li><a href="panel_general_alumno.php?seccion=editar">Editar mis datos</a></li>
        <li><a href="cambiar_contrasena_alumno.php">Cambiar contraseña</a></li>
        <li><a href="logout.php">Salir</a></li>
      </ul>
    </nav>
    <main>
  <?php
  session_start();
  include("conexion.php");

  if (!isset($_SESSION['id_alumno'])) {
    header("Location: index.php");
    exit();
  }

  $id_alumno = $_SESSION['id_alumno'];
  $sql = "SELECT a.nombre_completo, g.nombre_grupo, c.nombre_carrera 
          FROM alumnos a 
          JOIN grupos g ON a.id_grupo = g.id_grupo 
          JOIN carreras c ON g.id_carrera = c.id_carrera 
          WHERE a.id_alumno = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_alumno);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();

  $seccion = $_GET['seccion'] ?? 'inicio';

  if ($seccion === 'inicio') {
    include('inicio_alumno.php');
  }  elseif ($seccion === 'editar') {
    include('editar_datos_alumno.php');
  }elseif ($seccion === 'Calendario') {
    include ( 'calendario.php');
  }elseif ($seccion === 'Cardex') {
    include ( 'cardex.php');
  }elseif ($seccion === 'horario') {
    include('horario_alumno.php');
}

  ?>
</main>

  </div>  <footer>
    <p>&copy; 2025 Universidad Intercultural de Tamuín, SLP</p>
  </footer>
</body>
</html>