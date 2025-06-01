<!DOCTYPE html>
<html lang="es">
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
    <h1>Bienvenido al Panel de Horarios</h1>
  </header>
  <div class="container">
    <nav>
      <img src="logo.png" alt="Logo UICSLP" class="logo">
      <h2>Panel Alumno</h2>
      <ul>
        <?php
        include('conexion.php');

        // Obtener carrera desde GET o usar valor por defecto
        $carrera = isset($_GET['carrera']) ? $_GET['carrera'] : "LICENCIATURA EN INFORMATICA ADMINISTRATIVA";

        $stmt = $conn->prepare("
            SELECT g.id_grupo, g.nombre_grupo
            FROM grupos g
            INNER JOIN carreras c ON g.id_carrera = c.id_carrera
            WHERE c.nombre_carrera = ?
        ");
        $stmt->bind_param("s", $carrera);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $id_grupo = $row['id_grupo'];
            $nombre_grupo = $row['nombre_grupo'];
            echo "<li><a href='?grupo=$id_grupo&carrera=$carrera'>Grupo: $nombre_grupo</a></li>";
          }
        } else {
          echo "<li>No se encontraron grupos para esta carrera.</li>";
        }
         echo "<li><a href='index.php'>Salir</a></li>";
        $stmt->close();
        ?>
        
      </ul>
    </nav>
    <main>
      <?php
      include('conexion.php');

      if (isset($_GET['grupo'])) {
          $id_grupo = intval($_GET['grupo']);

          // 1️⃣ Obtener datos básicos del grupo
          $stmt = $conn->prepare("
              SELECT g.nombre_grupo, c.nombre_carrera, g.id_semestre
              FROM grupos g
              INNER JOIN carreras c ON g.id_carrera = c.id_carrera
              WHERE g.id_grupo = ?
          ");
          $stmt->bind_param("i", $id_grupo);
          $stmt->execute();
          $grupo = $stmt->get_result()->fetch_assoc();
          $stmt->close();

          if (!$grupo) {
              echo "<h2>Grupo no encontrado.</h2>";
              exit;
          }

          $nombre_grupo = $grupo['nombre_grupo'];
          $nombre_carrera = $grupo['nombre_carrera'];
          $id_semestre = $grupo['id_semestre'];

          echo "<h2>Horario del Grupo: $nombre_grupo</h2>";
          echo "<p>Carrera: $nombre_carrera</p>";

          // 2️⃣ Obtener horas existentes
          $stmt = $conn->prepare("
              SELECT DISTINCT hora_inicio, hora_fin
              FROM horario_grupo
              WHERE id_grupo = ?
              ORDER BY hora_inicio
          ");
          $stmt->bind_param("i", $id_grupo);
          $stmt->execute();
          $horas_result = $stmt->get_result();
          $horas = [];
          while ($row = $horas_result->fetch_assoc()) {
              $horas[] = [
                  'hora_inicio' => $row['hora_inicio'],
                  'hora_fin' => $row['hora_fin']
              ];
          }
          $stmt->close();

          // 3️⃣ Calcular la última hora registrada
          $ultima_hora = new DateTime("07:00");
          foreach ($horas as $hora) {
              if (!empty($hora['hora_fin'])) {
                  $fin = new DateTime($hora['hora_fin']);
                  if ($fin > $ultima_hora) {
                      $ultima_hora = $fin;
                  }
              }
          }

          // 4️⃣ Generar bloques de 50 minutos
          $horas_def = [];
          $hora_actual = new DateTime("07:00");
          $receso_inicio = new DateTime("09:30");
          $receso_fin = new DateTime("09:50");

          while ($hora_actual < $ultima_hora) {
              $hora_inicio_str = $hora_actual->format("H:i");

              if ($hora_inicio_str == $receso_inicio->format("H:i")) {
                  $horas_def[] = [
                      'hora_inicio' => $receso_inicio->format("H:i"),
                      'hora_fin' => $receso_fin->format("H:i"),
                      'receso' => true
                  ];
                  $hora_actual = $receso_fin;
              } else {
                  $hora_fin = clone $hora_actual;
                  $hora_fin->modify("+50 minutes");
                  $horas_def[] = [
                      'hora_inicio' => $hora_inicio_str,
                      'hora_fin' => $hora_fin->format("H:i"),
                      'receso' => false
                  ];
                  $hora_actual = $hora_fin;
              }
          }

          // 5️⃣ Obtener materias por día y hora
          $stmt = $conn->prepare("
              SELECT hg.dia_semana, 
                     DATE_FORMAT(hg.hora_inicio, '%H:%i') AS hora_inicio, 
                     m.nombre_materia
              FROM horario_grupo hg
              INNER JOIN materias m ON hg.id_materia = m.id_materia
              WHERE hg.id_grupo = ?
          ");
          $stmt->bind_param("i", $id_grupo);
          $stmt->execute();
          $horario_result = $stmt->get_result();
          $horario = [];
          while ($row = $horario_result->fetch_assoc()) {
              $dia = $row['dia_semana'];
              $hora_inicio = $row['hora_inicio'];
              $materia = $row['nombre_materia'];
              $horario[$hora_inicio][$dia] = $materia;
          }
          $stmt->close();

          // 6️⃣ Renderizar tabla de horario
          echo "<h3>Horario:</h3>";
          echo "<table border='1' cellpadding='5'>";
          echo "<tr>
                  <th>Hora</th>
                  <th>Lunes</th>
                  <th>Martes</th>
                  <th>Miércoles</th>
                  <th>Jueves</th>
                  <th>Viernes</th>
                </tr>";

          $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

          foreach ($horas_def as $hora) {
              echo "<tr>";
              echo "<td>{$hora['hora_inicio']} - {$hora['hora_fin']}</td>";

              foreach ($dias as $dia) {
                  if ($hora['receso']) {
                      echo "<td style='background-color:rgb(255, 255, 255);'>Receso</td>";
                  } else {
                      $materia = isset($horario[$hora['hora_inicio']][$dia]) ? $horario[$hora['hora_inicio']][$dia] : "";
                      echo "<td>$materia</td>";
                  }
              }
              echo "</tr>";
          }
          echo "</table>";

          // 7️⃣ Materias, maestros y horas/semana
          echo "<h3>Materias y Maestros:</h3>";
          echo "<table border='1' cellpadding='5'>
                  <tr><th>Materia</th><th>Maestro</th><th>Horas/Semana</th></tr>";

          $stmt = $conn->prepare("
              SELECT m.nombre_materia, ma.nombre_completo, ms.horas_semana
              FROM horario_grupo hg
              INNER JOIN materias m ON hg.id_materia = m.id_materia
              INNER JOIN maestros ma ON hg.id_maestro = ma.id_maestro
              INNER JOIN materias_semestre ms ON m.id_materia = ms.id_materia AND ms.id_semestre = ?
              WHERE hg.id_grupo = ?
              GROUP BY m.nombre_materia, ma.nombre_completo, ms.horas_semana
          ");
          $stmt->bind_param("ii", $id_semestre, $id_grupo);
          $stmt->execute();
          $result = $stmt->get_result();
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['nombre_materia']}</td>
                      <td>{$row['nombre_completo']}</td>
                      <td>{$row['horas_semana']}</td>
                    </tr>";
          }
          echo "</table>";
          $stmt->close();

      } else {
          echo "<h2>Selecciona un grupo para ver su horario.</h2>";
      }
      ?>
    </main>
  </div>
  <footer>
    <p>&copy; 2025 Universidad Intercultural de Tamuín, SLP</p>
  </footer>
</body>
</html>

