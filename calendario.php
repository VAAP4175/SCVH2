
<?php

include("conexion.php");

$id_usuario = null;
$rol = '';

if (isset($_SESSION['id_admin'])) {
    $id_usuario = $_SESSION['id_admin'];
    $rol = 'admin';
} elseif (isset($_SESSION['id_maestro'])) {
    $id_usuario = $_SESSION['id_maestro'];
    $rol = 'maestro';
} elseif (isset($_SESSION['id_alumno'])) {
    $id_usuario = $_SESSION['id_alumno'];
    $rol = 'alumno';
} else {
    echo "<p>Error de sesión. No has iniciado sesión.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calendario Escolar</title>
  <script>
  const ROL_USUARIO = "<?php echo $rol; ?>";
</script>

  <style>
    main {
        padding: 20px;
    }
    /* Estilos para el contenedor del calendario */
#calendar-container {
    width: 100%; /* El contenedor ocupa todo el ancho disponible */
    max-width: 900px; /* El ancho máximo es de 800px */
    margin-left: 170px;
    background-color: #f0f8ff; /* Fondo de color azul claro */
    padding: 15px; /* Espaciado interno */
    border-radius: 15px; /* Bordes redondeados */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Sombra sutil */
}
#month-navigation {
    display: flex; /* Usa Flexbox para alinear los botones */
    justify-content: center; /* Centra los botones horizontalmente */
    align-items: center; /* Alinea los botones verticalmente */
    gap: 10px; /* Espaciado entre los botones */
    font-size: 20px; /* Tamaño de la fuente */
    font-weight: bold; /* Pone el texto en negrita */
    margin-bottom: 15px; /* Deja un espacio debajo */
    background-color: #cce7ff; /* Fondo azul claro */
    padding: 10px; /* Espaciado interno */
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); /* Sombra sutil */
    position: relative; /* Permite que las flechas se queden en su lugar */
}

/* Estilos para los botones de la barra de navegación del mes */
#month-navigation button {
    background: none; /* Sin fondo por defecto */
    border: none; /* Sin borde */
    font-size: 18px; /* Tamaño de la fuente de las flechas */
    cursor: pointer; /* Cambia el cursor a mano al pasar sobre el botón */
    padding: 0 10px; /* Añade espaciado en los lados */
    font-weight: bold; /* Pone el texto en negrita */
    color: #174675; /* Color azul para el texto */
}

/* Efecto al pasar el cursor sobre los botones de navegación del mes */
#month-navigation button:hover {
    color: #e68223; /* Cambia el color al naranja */
}

/* Estilos para el texto del mes/año en el centro de la barra de navegación */
#month-navigation span {
    flex-grow: 1; /* Hace que el texto ocupe el espacio restante */
    text-align: center; /* Centra el texto */
}
/* Estilos para el calendario */
.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 5px;
  padding: 20px;
  max-width: 800px;
  margin: auto;
}

#calendar .weekday {
    font-weight: bold; /* Pone el texto en negrita */
    text-align: center; /* Centra el texto */
    padding: 11px 0; /* Altura compacta */
    background-color: #cce7ff; /* Fondo azul claro */
    border: 1px solid #ddd; /* Borde sutil */
    border-radius: 10px; /* Bordes redondeados */
}

/* Estilos para los días del mes */
#calendar .day {
    padding: 16px 0; /* Altura compacta */
    text-align: center; /* Centra el texto */
    border: 1px solid #ddd
}

.dia-ocupado {
  background-color: #ff9999 !important;
  color: white;
  border: 2px solid #cc0000;
}
/* ======= MODAL DE RESERVA ======= */
.modal {
  display: none;
  position: fixed;
  z-index: 999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
}

.modal-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 2px solid #174675;
  width: 320px;
  border-radius: 10px;
  position: relative;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
  font-family: Arial, sans-serif;
}

.modal-content h2 {
  text-align: center;
  color: #174675;
}

.modal-content label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
}

.modal-content input,
.modal-content button {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.modal-content button {
  background-color: #174675;
  color: white;
  font-weight: bold;
  border: none;
  margin-top: 15px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.modal-content button:hover {
  background-color: #0e3558;
}

.close {
  position: absolute;
  right: 15px;
  top: 10px;
  font-size: 22px;
  font-weight: bold;
  color: #174675;
  cursor: pointer;
}
  </style>
</head>



<main>
    <div id="calendar-container">
      <div id="month-navigation">
        <button id="prev-month">◀</button>
        <span id="month-year">Mes Año</span>
        <button id="next-month">▶</button>
      </div>

      <div id="calendar" class="calendar-grid"></div>
    </div>
    <div id="leyenda-calendario" style="max-width: 800px; margin: 20px auto; display: flex; flex-wrap: wrap; gap: 10px;">
  <div style="display: flex; align-items: center; gap: 8px;">
    <div style="width: 20px; height: 20px; background-color: #30814b; border: 1px solid #999;"></div>
    <span>Suspensión de labores</span>
  </div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <div style="width: 20px; height: 20px; background-color: #e2c131; border: 1px solid #999;"></div>
    <span>Evento institucional</span>
  </div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <div style="width: 20px; height: 20px; background-color: #9bd7a0; border: 1px solid #999;"></div>
    <span>Periodo de evaluación</span>
  </div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <div style="width: 20px; height: 20px; background-color: #dbb0cd; border: 1px solid #999;"></div>
    <span>Exámenes extraordinarios</span>
  </div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <div style="width: 20px; height: 20px; background-color: #8bb8a2; border: 1px solid #999;"></div>
    <span>Exámenes a título</span>
  </div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <div style="width: 20px; height: 20px; background-color: #86d5c3; border: 1px solid #999;"></div>
    <span>Vacaciones</span>
  </div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <div style="width: 20px; height: 20px; background-color: #ff9999; border: 1px solid #999;"></div>
    <span>Reservas de comunicados</span>
  </div>
</div>

  </main>

  <!-- MODAL DE RESERVA -->
  <div id="modalReserva" class="modal">
    <div class="modal-content">
      <span class="close" onclick="cerrarModal()">&times;</span>
      <h2>Reservar Sala</h2>
      <form action="guardar_reserva.php" method="post">
        <input type="hidden" name="fecha" id="modalFecha">
        <label>Hora:<br><input type="time" name="hora" required></label>
        <label>Descripción:<br><input type="text" name="descripcion" required></label>
        <button type="submit">Guardar Reserva</button>
      </form>
    </div>
  </div>

  <script src="calendario.js"></script>
  <script>
    function abrirModal(fecha) {
      document.getElementById("modalFecha").value = fecha;
      document.getElementById("modalReserva").style.display = "block";
    }
    function cerrarModal() {
      document.getElementById("modalReserva").style.display = "none";
    }
  </script>



</body>
</html>