const horarios = [
  { inicio: "07:00", fin: "07:50" },
  { inicio: "07:50", fin: "08:40" },
  { inicio: "08:40", fin: "09:30" },
  { inicio: "09:30", fin: "09:50", tipo: "receso" },
  { inicio: "09:50", fin: "10:40" },
  { inicio: "10:40", fin: "11:30" },
  { inicio: "11:30", fin: "12:20" },
  { inicio: "12:20", fin: "13:10" },
  { inicio: "13:10", fin: "13:50", tipo: "intercambio" },
  { inicio: "13:50", fin: "14:40" },
  { inicio: "14:40", fin: "15:30" },
  { inicio: "15:30", fin: "16:20" },
  { inicio: "16:20", fin: "16:40", tipo: "receso" },
  { inicio: "16:40", fin: "17:30" },
  { inicio: "17:30", fin: "18:20" },
  { inicio: "18:20", fin: "19:10" },
  { inicio: "19:10", fin: "20:00" }
];

const dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];


const tabla = document.getElementById("tabla-bloques");
const dialogo = document.getElementById("formulario");
const infoHorario = document.getElementById("info-horario");
const nombreInput = document.getElementById("nombre");
const motivoInput = document.getElementById("motivo");
const cancelarBtn = document.getElementById("cancelar");
const guardarBtn = document.getElementById("guardar");
const rangoSemana = document.getElementById("rango-semana");
const btnAnterior = document.getElementById("semana-anterior");
const btnSiguiente = document.getElementById("semana-siguiente");

let semanaOffset = 0;
let semanaActual = [];

let bloqueActual = null;
let horaSeleccionada = "";
let fechaSeleccionada = "";

// Formateo largo en español (ej. Lunes 27 de mayo de 2025)
function fechaLargaES(fecha) {
  return fecha.toLocaleDateString("es-MX", {
    weekday: "long",
    day: "numeric",
    month: "long",
    year: "numeric"
  });
}

// Capitaliza primera letra
function capitalizar(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function obtenerSemana(offset = 0) {
  const hoy = new Date();
  const diaActual = hoy.getDay(); // 0 = domingo, 1 = lunes, ..., 6 = sábado
  const diasDesdeLunes = diaActual === 0 ? 6 : diaActual - 1;

  const lunes = new Date(hoy);
  lunes.setDate(hoy.getDate() - diasDesdeLunes + offset * 7);
  lunes.setHours(0, 0, 0, 0);

  const semana = [];
  for (let i = 0; i < 5; i++) {
    const dia = new Date(lunes);
    dia.setDate(lunes.getDate() + i);
    semana.push(dia);
  }
  return semana;
}

function formatearFecha(date) {
  return date.toISOString().split("T")[0];
}

function cargarSemana() {
  semanaActual = obtenerSemana(semanaOffset);
  const inicio = semanaActual[0];
  const fin = semanaActual[4];
  rangoSemana.textContent = `${capitalizar(fechaLargaES(inicio))} al ${capitalizar(fechaLargaES(fin))}`;
  tabla.innerHTML = "";

  const inicioStr = formatearFecha(inicio);
  const finStr = formatearFecha(fin);

  fetch(`obtener_reservas.php?inicio=${inicioStr}&fin=${finStr}`)
    .then(res => res.json())
    .then(data => crearTabla(data));
}

function crearTabla(reservas) {
  horarios.forEach(bloque => {
    const fila = document.createElement("tr");
    const celdaHora = document.createElement("td");
    celdaHora.textContent = `${bloque.inicio} - ${bloque.fin}`;
    fila.appendChild(celdaHora);

    semanaActual.forEach((fecha, i) => {
      const celda = document.createElement("td");

      if (bloque.tipo === "receso" || bloque.tipo === "intercambio") {
        celda.textContent = bloque.tipo === "receso" ? "Receso" : "Intercambio";
        celda.classList.add("intermedio");
      } else {
        celda.classList.add("bloque");
        const fechaStr = formatearFecha(fecha);
        celda.dataset.fecha = fechaStr;
        celda.dataset.hora = bloque.inicio;

        const reserva = reservas.find(r => r.fecha === fechaStr && r.hora === bloque.inicio);
        const ahora = new Date();
        const fechaHoraBloque = new Date(`${fechaStr}T${bloque.inicio}`);

        if (reserva) {
          celda.innerHTML = `<strong>${reserva.nombre}</strong><br><small>${reserva.motivo}</small>`;
          celda.classList.add("ocupado");
        } else if (fechaHoraBloque < ahora) {
          celda.textContent = "No disponible";
          celda.classList.add("pasado");
        } else {
          celda.textContent = "Disponible";
          celda.classList.add("disponible");

         celda.addEventListener("click", () => {
  bloqueActual = celda;
  fechaSeleccionada = celda.dataset.fecha;
  horaSeleccionada = celda.dataset.hora;

  // Construcción local segura
  const [anio, mes, dia] = fechaSeleccionada.split("-");
  const fechaObj = new Date(anio, mes - 1, dia);

  const diaNombre = dias[fechaObj.getDay()];
  const opciones = { day: 'numeric', month: 'long', year: 'numeric' };
  const fechaFormateada = fechaObj.toLocaleDateString('es-MX', opciones);

  infoHorario.textContent = `Reservar: ${diaNombre}, ${fechaFormateada} ${horaSeleccionada}`;

  nombreInput.value = "";
  motivoInput.value = "";
  dialogo.showModal();
});

        }
      }

      fila.appendChild(celda);
    });

    tabla.appendChild(fila);
  });
}

cancelarBtn.addEventListener("click", () => dialogo.close());

guardarBtn.addEventListener("click", () => {
  const nombre = nombreInput.value.trim();
  const motivo = motivoInput.value.trim();

  if (nombre && motivo) {
    fetch("guardar_reserva.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nombre, motivo, fecha: fechaSeleccionada, hora: horaSeleccionada })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          cargarSemana();
          dialogo.close();
        } else {
          alert("Error al guardar: " + data.error);
        }
      });
  }
});

btnAnterior.addEventListener("click", () => {
  semanaOffset--;
  cargarSemana();
});

btnSiguiente.addEventListener("click", () => {
  semanaOffset++;
  cargarSemana();
});

cargarSemana();
