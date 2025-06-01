<?php
include "conexion.php";
$id_alumno = $_SESSION['id_alumno'];


$sql = "SELECT a.nombre_completo, g.nombre_grupo, c.nombre_carrera 
        FROM alumnos a
        JOIN grupos g ON a.id_grupo = g.id_grupo
        JOIN carreras c ON g.id_carrera = c.id_carrera
        WHERE a.id_alumno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$basicos = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("SELECT * FROM datos_alumno WHERE id_alumno = ?");
$stmt2->bind_param("i", $id_alumno);
$stmt2->execute();
$extra = $stmt2->get_result()->fetch_assoc();

// Consulta para saber en qué semestre está el alumno
$sql = "SELECT s.numero AS semestre_actual
        FROM alumnos a
        JOIN grupos g ON a.id_grupo = g.id_grupo
        JOIN semestres s ON g.id_semestre = s.id_semestre
        WHERE a.id_alumno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();
$semestre_actual = $resultado['semestre_actual'];

// Obtener materias por semestre
$sqlMaterias = "SELECT ms.id_semestre, m.nombre_materia
                FROM materias_semestre ms
                JOIN materias m ON ms.id_materia = m.id_materia
                ORDER BY ms.id_semestre, m.id_materia";
$materias = $conn->query($sqlMaterias);

//mapeo por semestre
$orden_logico = [
    5 => 1, // ID 5 → Semestre 1
    1 => 2, // ID 1 → Semestre 2
    6 => 3, // ID 6 → Semestre 3
    2 => 4, // ID 2 → Semestre 4
    7 => 5, // ID 7 → Semestre 5
    3 => 6, // ID 3 → Semestre 6
    8 => 7, // ID 8 → Semestre 7
    4 => 8  // ID 4 → Semestre 8
];

// Organizar materias en el orden visual correcto
$porSemestre = [];
while ($row = $materias->fetch_assoc()) {
    $orden = $orden_logico[$row['id_semestre']] ?? null;
    if ($orden) {
        $porSemestre[$orden][] = $row['nombre_materia'];
    }
}
?>
 

 <style>
    /* Centrar el título */
h2 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 24px;
 
}

/* Tabla principal */
table {
  width: 100%;
  border-collapse: collapse;
  margin: 0 auto;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  border-radius: 8px;
}

/* Encabezados de los semestres */
th {
  background-color: #1e3a8a; /* azul marino */
  color: white;
  padding: 12px;
  font-size: 16px;
}

/* Celdas */
td {
  vertical-align: top;
  padding: 10px;
}

/* Materia individual */
td div {
  margin: 6px 0;
  padding: 6px 8px;
  border-radius: 2px;
  font-size: 14px;
  text-align: left;
  font-weight: 500;
}

/* Colores de estado */
.verde {
  background-color: #b1eebf;
}
.azul {
  background-color: #add8e6;
}
.gris {
  background-color: #e0e0e0;
}

 </style>
<table border="1" style="width:100%; text-align:center; ">
  <tr>
    
    <?php for ($s = 1; $s <= 8; $s++): ?>
      <th>Semestre <?= $s ?></th>
    <?php endfor; ?>
  </tr>
  <tr>
    <?php for ($s = 1; $s <= 8; $s++): ?>
      <td style="vertical-align:top;">
        <?php foreach ($porSemestre[$s] ?? [] as $materia): ?>
          <div style="margin:4px; padding:4px;
              background-color: <?= 
                ($s < $semestre_actual) ? '#b1eebf' : 
                (($s == $semestre_actual) ? '#add8e6' : '#e0e0e0') ?>;
              border-radius: 6px;">
            <?= $materia ?>
          </div>
        <?php endforeach; ?>
      </td>
    <?php endfor; ?>
  </tr>
</table><br>
    
    <div class="datos-bloque">
        <h3>Información adicional</h3>
        <p><strong>Semestre actual:</strong> <?= $semestre_actual ?></p>
        <p><strong>Carrera:</strong> <?= $basicos['nombre_carrera'] ?></p>
        <p><strong>Grupo:</strong> <?= $basicos['nombre_grupo'] ?></p>
    </div>